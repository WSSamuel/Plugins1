<?php
/**
 * Plugin Name: Exclude From Search
 * Plugin URI: https://wordpress.org/plugins/exclude-from-search/
 * Description: Exclude Page and Attachment post types from search results.
 * Version: 0.2.1
 * Author: Alberto Ochoa
 * Author URI: https://gitlab.com/albertochoa
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

/* Add 'exclude_from_search' on the 'init' hook. */
add_action( 'init', 'exclude_from_search' );

/**
 * Exclude 'page' and 'attachment' post type from search results.
 *
 * @since 0.1
 */
function exclude_from_search() {
	global $wp_post_types;

	$wp_post_types['page']->exclude_from_search = true;

	$wp_post_types['attachment']->exclude_from_search = true;
}

