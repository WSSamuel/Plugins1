<?php
/**
 * Plugin Name: Easy Digital Downloads - Block Editor
 * Description: Enable the new WordPress block editor for Easy Digital Downloads products
 * Author: RavanH
 * Author URI: https://status301.net
 * Version: 1.0
 * License: GPL-3.0
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 */

defined( 'ABSPATH' ) or exit;

/**
 * Filters the register post type arguments for download post type
 *
 * @since 1.0
 * @param array $args Register post type arguments
 * @param array $post_type Post type slug
 * @return array $args
 */

function edd_block_editor_register_post_type_args( $args, $post_type ) {
  // set show_in_rest for download post type
	if ( $post_type == 'download' ) {
      $args['show_in_rest'] = true;
  }

  return $args;
}

add_filter( 'register_post_type_args', 'edd_block_editor_register_post_type_args', 20, 2 );

/**
 * Filters the register taxonomy arguments for download post type
 *
 * @since 1.0
 * @param array $args Register taxonomy arguments
 * @param array $taxonomy Taxonomy slug
 * @return array $args
 */

function edd_block_editor_register_taxonomy_args( $args, $taxonomy ) {
	// set show_in_rest for download_category and download_tag taxonomies
  if ( in_array( $taxonomy, array('download_category','download_tag') ) ) {
      $args['show_in_rest'] = true;
  }

  return $args;
}

add_filter( 'register_taxonomy_args', 'edd_block_editor_register_taxonomy_args', 20, 2 );
