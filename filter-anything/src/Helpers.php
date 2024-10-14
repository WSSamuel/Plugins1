<?php

namespace Vardaam\FilterAnything;

use WP_Roles;

class Helpers {
	/**
	 * Debug function to dump variable and die
	 *
	 * @param $var
	 *
	 * @return void
	 */
	public static function dd( $var ) {
		self::d( $var );
		die();
	}

	/**
	 * Debug function to dump variable
	 *
	 * @param $var
	 *
	 * @return void
	 */
	public static function d( $var ) {
		echo '<pre>', print_r( $var, 1 ), '</pre>';
	}

	public static function get_sanitized_selected_value( array $filter ) {
		if ( isset( $_GET[ $filter['name'] ] ) ) {
			$data = $_GET[ $filter['name'] ];

			return is_array( $data ) ? array_map( 'esc_attr', $data ) : esc_attr( $data );
		}

		return $filter['default_value'];
	}

	public static function get_choices_array( $filter ) {
		if ( $filter['filter_type'] === 'taxonomy' ) {
         $args = ['hide_empty' => false];
         $parent_term = get_term_by( 'slug', sanitize_text_field( $filter['filter_by_child_terms_of'] ), $filter['taxonomy_select'] );
         if ( false === empty( sanitize_text_field( $filter['filter_by_child_terms_of'] ) ) && !empty( $parent_term ) ) {
            $args['parent'] = $parent_term->term_id;
         }

			return wp_list_pluck( get_terms( $filter['taxonomy_select'], $args ), 'name', 'term_id' );
		} elseif ( $filter['filter_type'] === 'author' ) {
			$roles__in = [];
			foreach ( wp_roles()->roles as $role_slug => $role ) {
				if ( false === empty( $role['capabilities']['publish_posts'] ) ) {
					$roles__in[] = $role_slug;
				}
			}

			return wp_list_pluck( get_users( [
				'roles__in' => $roles__in,
				'fields'    => [ 'ID', 'display_name' ]
			] ), 'display_name', 'ID' );
		} elseif ( $filter['filter_type'] === 'role' ) {
			return wp_list_pluck( wp_roles()->roles, 'name' );
		} else {
			if ( ! empty( $filter['choices'] ) ) {
				return self::build_selection_choices( $filter['choices'] );
			}
		}
	}

	public static function build_selection_choices( $choices_string ): array {
		$choices_raw = explode( PHP_EOL, $choices_string );
		$choices     = [];
		foreach ( $choices_raw as $choice_raw ) {
			if ( str_contains( $choice_raw, ' : ' ) ) {
				$key_value                        = explode( ' : ', $choice_raw );
				$choices[ trim( $key_value[0] ) ] = trim( $key_value[1] );
			} else {
				$choices[ trim( $choice_raw ) ] = trim( $choice_raw );
			}
		}

		return $choices;
	}

	public static function get_role_names(): array {
		global $wp_roles;

		if ( ! isset( $wp_roles ) ) {
			$wp_roles = new WP_Roles();
		}

		return $wp_roles->get_names();
	}
}
