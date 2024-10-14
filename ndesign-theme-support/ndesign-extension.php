<?php
/*
   Plugin Name: NDesign Theme Support
   description: A Plugin to extend NDesign Theme
   Version: 1.0.1
   Author: SPEC INDIA
   Author URI: http://spec-india.com
   License: GPLv2 or later
*/

/*
 * A function to register custom post type portfolio
 */
   function ndesign_extension_create_posttype() {
   	register_post_type( 'portfolio',
   		array(
   			'labels' => array(
   				'name' => __( 'Portfolio', 'ndesign-extension' ),
   				'singular_name' => __( 'Portfolio', 'ndesign-extension' ),
   			),
   			'public' => true,
   			'show_ui' => true,
   			'rewrite' => array('slug' => 'portfolio'),
   			'supports' => array( 'thumbnail','title','post-formats'),
   			'taxonomies' => array( 'category' ),
   			'capability_type' => 'page',
   		)
   	);
   }
/*
 * Hooking up our function to theme setup
 */ 
   add_action( 'init', 'ndesign_extension_create_posttype' );
?>
