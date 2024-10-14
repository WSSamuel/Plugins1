<?php
/*
Plugin Name: Remove Wordpress to WordPress filter
Plugin URI: https://tomlany.net/code/
Description: This turns off the default filter that changes all instances of "Wordpress" to "WordPress".
Version: 1.3
Author: Tom Lany
Author URI: https://tomlany.net/
License: GPLv2 or later
*/

/* For more information about this plugin, see the readme.txt file included with the download package. */

foreach ( array( 'the_content', 'the_title', 'wp_title', 'comment_text' ) as $filter ) {
	$priority = has_filter( $filter, 'capital_P_dangit' );
	if ( $priority !== FALSE ) {
		remove_filter( $filter, 'capital_P_dangit', $priority );
	}
}

?>