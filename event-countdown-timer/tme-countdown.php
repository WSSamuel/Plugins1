<?php
/*
Plugin Name: Event Countdown Timer Plugin by TechMix
Plugin URI: https://techmix.xyz/downloads/tme-countdown-plugin-for-wordpress/
Description: Display your event countdown Timer anywhere in your website. You can change any color, image and text. Shortcode, Widget supported. 
Version: 1.4
Text Domain: event-countdown-timer
Domain Path: /languages
Author: TechMix
Author URI: https://techmix.xyz/
*/


global $wpdb;
define('tme_COUNT_TABLE_NAME', $wpdb->prefix . 'tme_countdown_setting');
define('tme_COUNT_VERSION', 101);

$default_setting = array( 'title' => 'Countdown' , 'img_link' => plugin_dir_url( __FILE__ )."image/default-img.jpg", 'background_color' => '#53bde3', 'time_box_color' => '#2c4f90', 'time_text_color' => '#ffffff', 'time_title_color' => '#ffffff',  'countdown_date' => '' , 'countdown_datetime' => '','countdown_timezone' => date_default_timezone_get()  );

require_once( ABSPATH . 'wp-includes/pluggable.php' );
require_once (dirname ( __FILE__ ) . '/tme_wp_query.php');
require_once (dirname ( __FILE__ ) . '/tme_countdown_views.php');
require_once (dirname ( __FILE__ ) . '/tme-countdown-widgets.php');



function tme_countdown_option() {
	require_once (dirname ( __FILE__ ) . '/tme-countdown-options-general.php');
}

function tme_countdown_widgets_init() {
register_widget('tme_countdown');
}

function tme_countdown_admin_menu() {
	add_options_page('Plugin Stats tme', 'Event Countdown', "manage_options", 'tmecountdown_options', 'tme_countdown_option');
}


function tme_countdown_deactivation_hook(){
	// global $wpdb;
	// $sql = "DROP TABLE `". tme_COUNT_TABLE_NAME . "`;";
	// $wpdb->query($sql);
}


register_activation_hook(__FILE__, 'tme_countdown_activation_hook');
register_deactivation_hook(__FILE__, 'tme_countdown_deactivation_hook');
add_action('widgets_init', 'tme_countdown_widgets_init');
add_action('admin_menu', 'tme_countdown_admin_menu');





//add shortcode
function tme_add_countdown_shortcode($atts){
  global $default_setting;
  $attrs = shortcode_atts( $default_setting, $atts );
    return tme_add_countdown($attrs);
  
}






function tme_countdown_init() {
  add_shortcode( 'tme_countdown', 'tme_add_countdown_shortcode' );
    if ( !function_exists( 'register_block_type' ) ) {
  		return;
  	}

    
}

add_action( 'init', 'tme_countdown_init' );





//add script
function tmecountdown_enqueue_scripts() {
    global $wp;
    if ( is_admin() ) {
      wp_enqueue_script( 'tme-countdown-datetime-js', plugin_dir_url( __FILE__ ) . 'styles/js/jquery.datetimepicker.full.min.js', array( 'jquery' ),tme_COUNT_VERSION, false );
    wp_enqueue_script( 'tme-countdown-script', plugin_dir_url( __FILE__ ) . 'styles/js/jquery.custom-admin.js', array( 'jquery',"tme-countdown-datetime-js" ),tme_COUNT_VERSION, true );
    wp_enqueue_style( 'tme-countdown-datetime-css', plugin_dir_url( __FILE__ ).'styles/css/jquery.datetimepicker.min.css', array(),tme_COUNT_VERSION );
    }
    
    wp_enqueue_script( 'tme-countdown-script', plugin_dir_url( __FILE__ ) . 'styles/js/jquery.custom.js', array( 'jquery' ),tme_COUNT_VERSION, true );
      $tme_countdown_data = tme_countdown_setting();
    wp_localize_script( 'tme-countdown-script', 'tmecountdown_setting', $tme_countdown_data); 
    wp_enqueue_style( 'tme-countdown-style', plugin_dir_url( __FILE__ ).'styles/css/default.css', array(),tme_COUNT_VERSION );

  }

  
add_action( 'wp_enqueue_scripts', 'tmecountdown_enqueue_scripts',100 );
add_action( 'admin_enqueue_scripts', 'tmecountdown_enqueue_scripts',100 );



//add script