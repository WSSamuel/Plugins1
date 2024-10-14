<?php
// Make sure we don't expose any info if called directly
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

/* @wordpress-plugin
 * Plugin Name:       OneClick WP Hello
 * Plugin URI:        https://www.seniberpikir.com/oneclick-whatsapp-hello-wordpress/
 * Description:       OneClick WP Hello will make it easier for your readers to contact you directly through WhatsApp with a single click using a custom shortcode or a floating button. Get connected with your audience is easier than ever!
 * Version:           0.1.0
 * Author:            Walter Pinem
 * Author URI:        https://walterpinem.me/
 * Developer: 		  Walter Pinem | Seni Berpikir
 * Developer URI: 	  https://www.seniberpikir.com/
 * Text Domain:       oneclick-whatsapp-hello
 * Domain Path:       /languages
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 * 
 * Requires at least: 4.1
 * Tested up to: 5.3.1
 * 
 * Copyright: © 2019 Walter Pinem.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if (!defined('OCWAHELLO_PLUGIN_DIR')) {
    define('OCWAHELLO_PLUGIN_DIR', plugin_dir_url(__FILE__));
    define ('OCWAHELLO_PLUGIN_VERSION', get_file_data(__FILE__, array('Version' => 'Version'), false)['Version'] );
}

add_action( 'plugins_loaded', 'OCWAHELLO_plugin_init', 0 );
function OCWAHELLO_plugin_init() {

// Start calling main css
function OCWAHELLO_include_plugin_css () {
    wp_register_style( 'wa_hello_style',  plugin_dir_url( __FILE__ ) . 'assets/css/main-style.css' );
    wp_register_style( 'wa_hello_fa_brands',  plugin_dir_url( __FILE__ ) . 'assets/css/brands.min.css' );
    wp_register_style( 'wa_hello_fa_solid',  plugin_dir_url( __FILE__ ) . 'assets/css/solid.min.css' );
    wp_enqueue_style( 'wa_hello_style' );
    wp_enqueue_style( 'wa_hello_fa_brands' );
    wp_enqueue_style( 'wa_hello_fa_solid' );
}
add_action( 'wp_enqueue_scripts', 'OCWAHELLO_include_plugin_css' );

// Start calling admin css
function OCWAHELLO_include_admin_css () {
    wp_register_style( 'wa_hello_style_admin',  plugin_dir_url( __FILE__ ) . 'assets/css/admin-style.css' );
    wp_enqueue_style( 'wa_hello_style_admin' );
}
add_action( 'admin_enqueue_scripts', 'OCWAHELLO_include_admin_css' );

// Start calling main files
require_once dirname(__FILE__).'/admin/wa-hello-admin.php';
require_once dirname(__FILE__).'/includes/whatsapp-hello-button.php';
require_once dirname(__FILE__).'/includes/whatsapp-hello-gdpr.php';

// Localize this plugin
function OCWAHELLO_languages_init() {
	$plugin_dir = basename(dirname(__FILE__));
	load_plugin_textdomain( 'oneclick-whatsapp-hello', false, $plugin_dir . '/languages' );
}
add_action('plugins_loaded', 'OCWAHELLO_languages_init');
}

// Add setting link plugin page
function OCWAHELLO_settings_link( $links_array, $plugin_file_name ){
  if( strpos( $plugin_file_name, basename(__FILE__) ) ) {
    array_unshift( $links_array, '<a href="admin.php?page=whatsapp-hello">Settings</a>' );
    }
  return $links_array;
}
add_filter( 'plugin_action_links', 'OCWAHELLO_settings_link', 10, 2 );
