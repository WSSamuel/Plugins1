<?php

namespace Vardaam\FilterAnything;

use PostTypes\PostType;

class CptAndTax {
	public function __construct() {
		$directories = new PostType( [
			'name'     => 'wfa-filters',
			'singular' => __( 'Filter' ),
			'plural'   => __( 'Filters' ),
			'slug'     => 'wfa-filters',
		] );
		$directories->icon( 'dashicons-filter' );
		$directories->options( [
			'supports'            => [ 'title' ],
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
		] );
		$directories->register();

		add_filter( 'manage_wfa-filters_posts_columns', array( $this, 'columns' ) );
		add_action( 'manage_wfa-filters_posts_custom_column', array( $this, 'custom_column' ), 10, 2 );
		add_filter( 'manage_edit-wfa-filters_sortable_columns', array( $this, 'column_register_sortable' ) );
	}

	public function columns( $columns ): array {
		return array_merge( $columns, array(
			'shortcode' => __( 'Shortcode' ),
		) );
	}

	public function custom_column( $column, $post_id ) {
		if ( $column == 'shortcode' ) {
			echo wp_kses_post( '<code>[wfa_filter id="' . $post_id . '"]</code>' );
		}
	}

	public function column_register_sortable( $columns ) {
		$columns['shortcode'] = 'shortcode';

		return $columns;
	}
}
