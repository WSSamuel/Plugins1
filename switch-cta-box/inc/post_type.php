<?php
/*
* Creating a function to create our CPT
*/

function wppw_cttabox_custom_post_type() {

// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x( 'CTA Box', 'Post Type General Name', 'twentythirteen' ),
		'singular_name'       => _x( 'CTA Box', 'Post Type Singular Name', 'twentythirteen' ),
		'menu_name'           => __( 'CTA Box', 'twentythirteen' ),
		'parent_item_colon'   => __( 'Parent CTA Box', 'twentythirteen' ),
		'all_items'           => __( 'All CTA Box', 'twentythirteen' ),
		'view_item'           => __( 'View CTA Box', 'twentythirteen' ),
		'add_new_item'        => __( 'Add New CTA Box', 'twentythirteen' ),
		'add_new'             => __( 'Add New', 'twentythirteen' ),
		'edit_item'           => __( 'Edit CTA Box', 'twentythirteen' ),
		'update_item'         => __( 'Update CTA Box', 'twentythirteen' ),
		'search_items'        => __( 'Search CTA Box', 'twentythirteen' ),
		'not_found'           => __( 'Not Found', 'twentythirteen' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
	);
	
// Set other options for Custom Post Type
	
	$args = array(
		'label'               => __( 'CTA Box', 'twentythirteen' ),
		'description'         => __( 'CTA Box news and reviews', 'twentythirteen' ),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'revisions', 'custom-fields', ),
		// You can associate this CPT with a taxonomy or custom taxonomy. 
		'taxonomies'          => array( 'genres' ),
		/* A hierarchical CPT is like Pages and can have
		* Parent and child items. A non-hierarchical CPT
		* is like Posts.
		*/	
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'has_archive' => false, 
		'rewrite' => false,
	);
	
	// Registering your Custom Post Type
	register_post_type( 'CTA Box', $args );

}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/

add_action( 'init', 'wppw_cttabox_custom_post_type', 0 );
require_once ('post_type_meta_feilds.php');
require_once ('shortcode_setup.php');
require_once ('admin/admin_enuqe.php');