<?php

/*
 Plugin Name:Insertify - Ad,HTML,CSS,JS,PHP,PDF,Header & Footer
 Description:Insert useful contents including Ads/content in posts, HTML, CSS, JS, PHP, header & footer scripts, PDF, YouTube videos, posts list, users list, any page/post contents, specific user's comments, etc. with controls.
 Version: 1.1.4
 Author: Sourov Amin
 Author URI: https://www.linkedin.com/in/hossain-amin/
 License: GPLv2+
 Text Domain:insertify
*/


//adding required files
require_once plugin_dir_path(__FILE__).'create_db.php';
require_once plugin_dir_path(__FILE__).'dashboard.php';
require_once plugin_dir_path(__FILE__).'regular.php';
require_once plugin_dir_path(__FILE__).'include_free.php';
require_once plugin_dir_path(__FILE__).'shortcodes.php';

//adding stylesheet
function icp_style(){
    wp_enqueue_style( 'icp', plugin_dir_url( __FILE__ ).'css/icp.css' );
}

add_action( 'wp_enqueue_scripts', 'icp_style' );
add_action('admin_enqueue_scripts', 'icp_style');
add_action('login_enqueue_scripts', 'icp_style');

//add js to admin area
function icp_js_script(){
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'icp_js', plugin_dir_url( __FILE__ ).'js/admin.js' );
}

add_action('admin_enqueue_scripts', 'icp_js_script');
//add_action('login_enqueue_scripts', 'icp_js_script');

//register hook to be triggered on plugin activation and create database table
register_activation_hook( __FILE__, 'icp_table_install' );

//deactivation hook to be triggered on plugin deactivation
register_deactivation_hook( __FILE__, 'icp_deactivate_func' );

//adding menu
function icp_add_menu() {

add_menu_page( __('Insertify', 'insertify'), __('Insertify', 'insertify'), 'manage_options', 'icps-main','icp_main', plugins_url('image/ic-logo.png', __FILE__),'25');

add_submenu_page('icps-main',//parent menu
                     __('Entries', 'insertify'), //title in bar
                     __('Entries', 'insertify'), //name in dashboard
                     'manage_options',
                     'icps_entries',//slug
                     'icp_entries'//function
                     );

add_submenu_page('icps-main',//parent menu
                     __('Add New', 'insertify'), //title in bar
                     __('Add New', 'insertify'), //name in dashboard
                     'manage_options',
                     'icps_add_new',//slug
                     'icp_add_new'//function
                     );

add_submenu_page('icps-main',//parent menu
                     __('Site Info', 'insertify'), //title in bar
                     __('Site Info', 'insertify'), //name in dashboard
                     'manage_options',
                     'icps_site_info',//slug
                     'show_icp_site_info'//function
                     );                     
                 
}

add_action( 'admin_menu', 'icp_add_menu' );

//loading text domain
function icp_load_text_domain() {

	load_plugin_textdomain( 'insertify', false, dirname(plugin_basename(__FILE__)).'/languages/' );

	}
        
add_action('plugins_loaded', 'icp_load_text_domain');

