<?php

namespace Vardaam\FilterAnything;

use WP_Query;
use WP_User_Query;
use function Crontrol\Event\get;

class AjaxHandler {
	public function __construct() {
		add_action( "wp_ajax_get_directory_results", array( $this, 'get_directory_results' ) );
		add_action( "wp_ajax_nopriv_get_directory_results", array( $this, 'get_directory_results' ) );
	}

	public function get_directory_results() {
		$directory = sanitize_text_field( $_REQUEST['directory'] );
		if ( empty( $directory ) || ! wp_verify_nonce( $_REQUEST['nonce'], "directory_nonce_" . $directory ) ) {
			exit( "No naughty business please" );
		}
		$directory = get_post( $directory );

		$directory_type = carbon_get_post_meta( $directory->ID, 'directory_type' );

		$args    = ( 'posts_directory' === $directory_type )
			? self::build_wp_query_args( $directory )
			: self::build_user_query_args( $directory );
		$results = ( 'posts_directory' === $directory_type )
			? self::get_post_html_data( $args, $directory->ID )
			: self::get_user_html_data( $args, $directory->ID );

		$response = [
			'page'        => sanitize_text_field( $_REQUEST['page'] ),
			'data'        => $results['content'],
			'max_pages'   => $results['max_pages'],
			'total_count' => $results['total_count']
		];

		if ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) {
			$response['query'] = $results['query'];
		}

		wp_send_json( $response, 200 );
	}

	private function build_wp_query_args( $directory ): array {
		$args = [
			'post_status'        => 'publish',
			'post_type'          => carbon_get_post_meta( $directory->ID, 'post_type_select' ),
			'posts_per_page'     => carbon_get_post_meta( $directory->ID, 'per_page' ),
			'order'              => carbon_get_post_meta( $directory->ID, 'order' ),
			'orderby'            => carbon_get_post_meta( $directory->ID, 'order_by_post_query' ),
			'paged'              => sanitize_text_field( $_REQUEST['page'] ),
        	'suppress_filters'   => true
		];

		$args = self::build_sort_by_query( $args );

		if ( 'meta_value' === carbon_get_post_meta( $directory->ID, 'order_by_post_query' ) ) {
			$args['meta_key'] = carbon_get_post_meta( $directory->ID, 'meta_key_post_query' );
		}

		$filters = carbon_get_post_meta( $directory->ID, 'post_filters' );

		$date_query = $tax_query = $meta_query = [];

		$pre_taxonomy_filters = carbon_get_post_meta( $directory->ID, 'taxonomy_pre_filters' );

		if ( ! empty( $pre_taxonomy_filters ) ) {
			foreach ( $pre_taxonomy_filters as $k => $filter ) {
				$tax_query[] = [
					'taxonomy' => $filter['taxonomy_select'],
					'field'    => 'slug',
					'terms'    => explode( ',', $filter['taxonomy_terms'] )
				];
			}
		}

		if ( ! empty( $filters ) ) {
			foreach ( $filters as $filter ) {
				if (
					in_array( $filter['name'], array_keys( $_REQUEST ) )
					&& $_REQUEST[ $filter['name'] ] !== ''
					&& $_REQUEST[ $filter['name'] ] !== []
					&& $_REQUEST[ $filter['name'] ] !== [ '' ]
				) {

					if ( is_array( $_REQUEST[ $filter['name'] ] ) ) {
						$value = array_map( 'sanitize_text_field', $_REQUEST[ $filter['name'] ] ) ;
					} else {
						$value = sanitize_text_field( $_REQUEST[ $filter['name'] ] );
					}

					switch ( $filter['filter_type'] ) {
						case 'search':
							$args['s'] = is_array( $value ) ? implode( ', ', $value ) : $value;
							break;
						case 'post_date':
							$date_query[] = self::build_date_query( $filter, $value );
							break;
						case 'author':
							if ( self::is_filter_and_value_array( $filter, $value ) ) {
								$args['author__in'] = $value;
							} else {
								$args['author'] = $value;
							}
							break;
						case 'taxonomy':
							$tax_query[] = [
								'taxonomy' => $filter['taxonomy_select'],
								'field'    => 'term_id',
								'terms'    => $value
							];
							break;
						case 'meta':
							$meta_query[] = self::build_meta_query( $filter, $value );
							break;
					}
				}
			}
		}

		if ( ! empty( $date_query ) ) {
			$date_query['relation'] = 'AND';
			$args['date_query']     = $date_query;
		}

		if ( ! empty( $tax_query ) ) {
			$tax_query['relation'] = 'AND';
			$args['tax_query']     = $tax_query;
		}

		if ( ! empty( $meta_query ) ) {
			$meta_query['relation'] = 'AND';
			$args['meta_query']     = $meta_query;
		}

		return apply_filters( 'wfa_directory_query_args_' . $directory->ID, $args, $filters, $_REQUEST );
	}

	private function build_sort_by_query( array $args, string $directory_type = 'posts_directory' ): array {
		$sort_by           = sanitize_text_field( $_REQUEST['sort_by'] );
		$is_user_directory = 'posts_directory' !== $directory_type;

		if ( false === empty( $sort_by ) ) {
			switch ( $sort_by ) {
				case 'newest':
					$args['order']   = 'DESC';
					$args['orderby'] = $is_user_directory ? 'registered' : 'date';
					break;
				case 'oldest':
					$args['order']   = 'ASC';
					$args['orderby'] = $is_user_directory ? 'registered' : 'date';
					break;
				case 'atoz':
					$args['order']   = 'ASC';
					$args['orderby'] = $is_user_directory ? 'display_name' : 'title';
					break;
				case 'ztoa':
					$args['order']   = 'DESC';
					$args['orderby'] = $is_user_directory ? 'display_name' : 'title';
					break;
			}
		}

		return $args;
	}

	private function build_date_query( $filter, $value ): array {
		$date_query = [];

		if ( in_array( $filter['date_compare'], [ '=', '!=' ] ) ) {
			$value      = strtotime( $value );
			$date_query = [
				'year'    => date( 'Y', $value ),
				'month'   => date( 'm', $value ),
				'day'     => date( 'd', $value ),
				'compare' => $filter['date_compare']
			];
			if ( $filter['input_type'] == 'datetime' ) {
				$date_query = [
					'hour'   => date( 'H', $value ),
					'minute' => date( 'i', $value ),
				];
			}
		} elseif ( in_array( $filter['date_compare'], [ '<', '<=' ] ) ) {
			$date_query = [
				'before'    => $value,
				'inclusive' => str_contains( $filter['date_compare'], '=' )
			];
		} elseif ( in_array( $filter['date_compare'], [ '>', '>=' ] ) ) {
			$date_query = [
				'after'     => $value,
				'inclusive' => str_contains( $filter['date_compare'], '=' )
			];
		}

		return $date_query;
	}

	private function is_filter_and_value_array( $filter, $value ): bool {
		if ( ( $filter['input_type'] === 'checkbox'
		       || ( $filter['input_type'] === 'select' && $filter['multiselect'] ) )
		     && is_array( $value )
		) {
			return true;
		}

		return false;
	}

	private function build_meta_query( $filter, $value ): array {
		$meta_query = [
			'key'     => $filter['meta_key'],
			'compare' => $filter['compare']
		];

		if ( ! in_array( $filter['compare'], [ 'EXISTS', 'NOT EXISTS' ] ) ) {
			$meta_query['value'] = $value;
		}

		return $meta_query;
	}

	private function build_user_query_args( $directory ): array {
		$args = [
			'number'             => carbon_get_post_meta( $directory->ID, 'per_page' ),
			'order'              => carbon_get_post_meta( $directory->ID, 'order' ),
			'orderby'            => carbon_get_post_meta( $directory->ID, 'order_by_user_query' ),
			'paged'              => sanitize_text_field( $_REQUEST['page'] ),
         'suppress_filters'   => true
		];

		$args = self::build_sort_by_query( $args, 'user_directory' );

		$roles = carbon_get_post_meta( $directory->ID, 'user_role_select' );
		if ( false === empty( $roles ) ) {
			$args['role__in'] = carbon_get_post_meta( $directory->ID, 'user_role_select' );
		}

		if ( 'meta_value' === carbon_get_post_meta( $directory->ID, 'order_by_user_query' ) ) {
			$args['meta_key'] = carbon_get_post_meta( $directory->ID, 'meta_key_user_query' );
		}

		$filters = carbon_get_post_meta( $directory->ID, 'user_filters' );

		$date_query = $meta_query = [];

		if ( ! empty( $filters ) ) {
			foreach ( $filters as $filter ) {
				if ( in_array( $filter['name'], array_keys( $_REQUEST ) ) && $_REQUEST[ $filter['name'] ] !== '' ) {

               if( is_array( $_REQUEST[ $filter['name'] ] ) ) {
                  $value = array_map( 'sanitize_text_field', $_REQUEST[ $filter['name'] ] ) ;
               } else {
                  $value = sanitize_text_field( $_REQUEST[ $filter['name'] ] );
               }

					switch ( $filter['filter_type'] ) {
						case 'search':
							$args['search'] = is_array( $value ) ? implode( ', ', $value ) : $value;
							break;
						case 'registration_date':
							$date_query[] = self::build_date_query( $filter, $value );
							break;
						case 'role':
							if ( self::is_filter_and_value_array( $filter, $value ) ) {
								$args['role__in'] = $value;
							} else {
								$args['role'] = $value;
							}
							break;
						case 'meta':
							$meta_query[] = self::build_meta_query( $filter, $value );
							break;
					}
				}
			}
		}

		if ( ! empty( $date_query ) ) {
			$date_query['relation'] = 'AND';
			$args['date_query']     = $date_query;
		}

		if ( ! empty( $meta_query ) ) {
			$meta_query['relation'] = 'AND';
			$args['meta_query']     = $meta_query;
		}

		return apply_filters( 'wfa_directory_query_args_' . $directory->ID, $args, $filters, $_REQUEST );
	}

	private function get_post_html_data( $args, $directory_id ): array {
      $entries = new WP_Query( $args );

		if ( empty( $entries ) ) {
			return [
				'max_pages' => $entries->max_num_pages,
				'content'   => ''
			];
		}

		$full_html = '';
		if ( $entries->have_posts() ) :
			while ( $entries->have_posts() ) : $entries->the_post();
				$entry = $entries->post;
				ob_start();
				include plugin_dir_path( __FILE__ ) . '../templates/tp-directory-result-item.php';
				$html = ob_get_contents();
				ob_end_clean();
				$full_html .= apply_filters( 'wfa_directory_entry_html_' . $directory_id, $html, $entry );
			endwhile;
			wp_reset_postdata();
		endif;

		return [
			'max_pages'   => $entries->max_num_pages,
			'total_count' => $entries->found_posts,
			'content'     => $full_html,
			'query'       => $entries->request
		];
	}

	private function get_user_html_data( $args, $directory_id ): array {
		$entries       = new WP_User_Query( $args );
		$max_num_pages = ceil( $entries->get_total() / carbon_get_post_meta( $directory_id, 'per_page' ) );

		if ( empty( $entries ) ) {
			return [
				'max_pages' => $max_num_pages,
				'content'   => ''
			];
		}

		$full_html = '';
		if ( ! empty( $entries->get_results() ) ) :
			foreach ( $entries->get_results() as $user ) :
				$entry = $user;
				ob_start();
				include plugin_dir_path( __FILE__ ) . '../templates/tp-directory-user-result.php';
				$html = ob_get_contents();
				ob_end_clean();
				$full_html .= apply_filters( 'wfa_directory_entry_html_' . $directory_id, $html, $entry );
			endforeach;
		endif;

		return [
			'max_pages'   => $max_num_pages,
			'total_count' => $entries->get_total(),
			'content'     => $full_html,
			'query'       => $entries->request
		];
	}
}

