<?php
/**
 * Plugin Name:				Forms with chart from VAB
 * Description:				Simple Plugin for creating forms, inquirer and questionnaires with the ability to display the results in the form of charts.
 * Plugin URI:				https://it-vab.ru/vab-forms-with-chart
 * Author URI:				https://it-vab.ru/
 * Author:     				Vladimir Anatol`evich Brumer
 * License:						GPLv2
 * Version:     			1.2.3
 *
 * Text Domain:				VABFWC
 * Domain Path:				/languages
 * Requires at least:	5.5.1
 * Requires PHP:			5.6.20 - 8.3.6
 */
/* Define */
if ( ! defined( 'ABSPATH' ) )  {
	exit;
}
global $wp_version;
if ( ! defined( 'VABFWC_WP_VERSION' ) ) {
	define( 'VABFWC_WP_VERSION', $wp_version );
}
if ( ! defined( 'VABFWC_WP_VERSION_CHECK' ) ) {
	$last_version = mb_strstr( VABFWC_WP_VERSION, '-', true ) !== false ? mb_strstr( VABFWC_WP_VERSION, '-', true ) : VABFWC_WP_VERSION;
	define( 'VABFWC_WP_VERSION_CHECK', str_pad( str_replace( '.', '', $last_version ), 3, '0', STR_PAD_RIGHT ) );
}
if ( VABFWC_WP_VERSION_CHECK < 551 ) {
	return;
}
if ( ! defined( 'VABFWC_VERSION' ) ) {
	define( 'VABFWC_VERSION', '1.2.3' );
}
if ( ! defined( 'VABFWCGSU' ) ) {
	define( "VABFWCGSU", get_site_url() );
}
if ( ! defined( 'VABFWC_PLUGIN' ) ) {
	define( 'VABFWC_PLUGIN', __FILE__ );
}
if ( ! defined( 'VABFWC_PLUGIN_BASENAME' ) )  {
	define ( 'VABFWC_PLUGIN_BASENAME', plugin_basename( VABFWC_PLUGIN ) );
}
if ( ! defined( 'VABFWC_PLUGIN_NAME' ) ) {
	define( 'VABFWC_PLUGIN_NAME', trim( dirname( VABFWC_PLUGIN_BASENAME ), '/' ) );
}
if ( ! defined('VABFWC_PLUGIN_DIR') ) {
	define( 'VABFWC_PLUGIN_DIR', untrailingslashit( dirname( VABFWC_PLUGIN ) ) );
}
if ( ! defined( 'VABFWC_PLUGIN_URL' ) ) {
	define( 'VABFWC_PLUGIN_URL', plugins_url( VABFWC_PLUGIN_NAME ) );
}
$VABFWC_UPLOAD = wp_upload_dir();
if ( ! defined( 'VABFWC_UPLOAD_DIR' ) ) {
	define( 'VABFWC_UPLOAD_DIR', $VABFWC_UPLOAD['basedir'] );
}
if ( ! defined( 'VABFWC_UPLOAD_URL' ) ) {
	define( 'VABFWC_UPLOAD_URL', $VABFWC_UPLOAD['baseurl'] );
}
/**
 * plugin translation
 */
	require_once VABFWC_PLUGIN_DIR . '/includes/plugin_translation.php';
/**
 * IP address for statistics
 */
	require_once VABFWC_PLUGIN_DIR . '/includes/ip_address.php';
/**
 * autoload for classes
 */
	require_once VABFWC_PLUGIN_DIR . '/includes/autoload_classes.php';
/**
 * deleting file directory
 */
	require_once VABFWC_PLUGIN_DIR . '/includes/del_dir.php';
/* Admin panel functionality */
if ( is_admin() ) {
	require_once VABFWC_PLUGIN_DIR . '/admin/admin.php';
}
/* Additional filtering of form fields */
	require_once VABFWC_PLUGIN_DIR . '/includes/validation-functions.php';
/**
 * Registers main scripts and styles.
 */
	require_once VABFWC_PLUGIN_DIR . '/includes/controller.php';
/*************************************
****CREATE SHORTCODE AND FORM HANDLER
*************************************/
	require_once VABFWC_PLUGIN_DIR . '/includes/SHORTCODE.php';