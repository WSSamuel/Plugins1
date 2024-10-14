<?php
/*
 * Plugin Name: WP Maintenance Switch
 * Plugin URI: https://wordpress.org/plugins/wp-maintenance-switch/
 * Description: A light-weight tool to turn on maintenance mode with just one click.
 * Version: 1.0.1
 * Author: Mitch
 * Author URI: https://profiles.wordpress.org/lowest
 * Text Domain: wpmaintenanceswitch
 * Domain Path:
 * Network:
 * License: GPL-2.0+
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

if ( ! defined( 'ABSPATH' ) )	{ exit; }
if ( ! defined( 'WPMS_FILE' ) )	{ define( 'WPMS_FILE', __FILE__ ); }

function wpmaintenanceswitch_adminbar( $wp_admin_bar ) {
	if( ! current_user_can( 'manage_options' ) ){
		return;
	}

	$class = get_option( 'wpmaintenanceswitch' ) ? ' active' : '';
	$textclass = is_admin() ? 'ab-label' : 'screen-reader-text';
	$smallclass = is_admin() ? '' : ' small';

	$wp_admin_bar->add_menu( array(
		'id'		=> 'wpmaintenanceswitch',
		'parent'	=> 'top-secondary',
		'title'		=> '<span class="ab-icon dashicons-admin-tools' . $smallclass . '"></span><span class="' . $textclass . '">' . __( 'Maintenance' ) . '</span>',
		'href'		=> '#',
		'meta'		=> array(
			'class' => 'wpmaintenanceswitch-toggler' . $class
		),
	) );
}
add_action('admin_bar_menu', 'wpmaintenanceswitch_adminbar', 9999);

function wpmaintenanceswitch_scripts() {
	if( ! current_user_can( 'manage_options' ) ){
		return;
	}

	wp_enqueue_style( "wpmaintenanceswitch-admin", plugins_url( 'assets/css/admin.css', WPMS_FILE ) );
	wp_enqueue_script( "wpmaintenanceswitch-ajax", plugins_url( 'assets/js/ajax.js', WPMS_FILE ), array( 'jquery' ) );
	wp_localize_script( 'wpmaintenanceswitch-ajax', 'wpmaintenanceswitch', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action('wp_enqueue_scripts', 'wpmaintenanceswitch_scripts');
add_action('admin_enqueue_scripts', 'wpmaintenanceswitch_scripts');

function wpmaintenanceswitch_process() {
	if( ! current_user_can( 'manage_options' ) ){
		return;
	}
	
	$wpmaintenanceswitch = 1;

	if( 1 == get_option( 'wpmaintenanceswitch' ) ){
		$wpmaintenanceswitch = 0;
	}

	update_option( 'wpmaintenanceswitch', $wpmaintenanceswitch );
	$result = array( 'wpmaintenanceswitch' => $wpmaintenanceswitch );

	exit( json_encode( $result ) );
}
add_action( 'wp_ajax_wpmaintenanceswitch', 'wpmaintenanceswitch_process' );

function wpmaintenanceswitch_maintenancepage() {
	if(get_option('wpmaintenanceswitch') && !is_admin() && !current_user_can('manage_options') && !in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))) {

		if ( file_exists( WP_CONTENT_DIR . '/maintenance.php' ) ) {
			require_once( WP_CONTENT_DIR . '/maintenance.php' );
			exit;
		}

		$protocol = wp_get_server_protocol();
		header( "$protocol 503 Service Unavailable", true, 503 );
		header( 'Content-Type: text/html; charset=utf-8' );
		header( 'Retry-After: 3600' );
		?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); if ( is_rtl() ) echo ' dir="rtl"'; ?>>
	<head>
		<meta name="viewport" content="width=device-width" />
		<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php echo get_option( 'blog_charset' ); ?>" />
		<meta name="robots" content="noindex,nofollow" />
		<title><?php printf( __('%s Maintenance', 'wpmaintenanceswitch'), bloginfo('name') . ' &rsaquo;' ); ?></title>
		<style type="text/css">
		html {
			background: #f1f1f1;
		}
		body {
			background: #fff;
			color: #444;
			font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
			margin: 2em auto;
			padding: 1em 2em;
			max-width: 700px;
			-webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.13);
			box-shadow: 0 1px 3px rgba(0,0,0,0.13);
		}
		h1 {
			border-bottom: 1px solid #dadada;
			clear: both;
			color: #666;
			font-size: 24px;
			margin: 20px 0 0 0;
			padding: 0;
			padding-bottom: 7px;
			font-weight: 400;
		}
		#error-page {
			margin-top: 50px;
		}
		#error-page p {
			font-size: 14px;
			line-height: 1.5;
			margin: 25px 0 20px;
		}
		#error-page code {
			font-family: Consolas, Monaco, monospace;
		}
		ul li {
			margin-bottom: 10px;
			font-size: 14px ;
		}
		a {
			color: #0073aa;
		}
		a:hover,
		a:active {
			color: #00a0d2;
		}
		a:focus {
			color: #124964;
			-webkit-box-shadow:
		0 0 0 1px #5b9dd9,
		0 0 2px 1px rgba(30, 140, 190, .8);
			box-shadow:
		0 0 0 1px #5b9dd9,
		0 0 2px 1px rgba(30, 140, 190, .8);
			outline: none;
		}
		.button {
			background: #f7f7f7;
			border: 1px solid #ccc;
			color: #555;
			display: inline-block;
			text-decoration: none;
			font-size: 13px;
			line-height: 26px;
			height: 28px;
			margin: 0;
			padding: 0 10px 1px;
			cursor: pointer;
			-webkit-border-radius: 3px;
			-webkit-appearance: none;
			border-radius: 3px;
			white-space: nowrap;
			-webkit-box-sizing: border-box;
			-moz-box-sizing:    border-box;
			box-sizing:         border-box;

			-webkit-box-shadow: 0 1px 0 #ccc;
			box-shadow: 0 1px 0 #ccc;
			vertical-align: top;
		}
		.button.button-large {
			height: 30px;
			line-height: 28px;
			padding: 0 12px 2px;
		}
		.button:hover,
		.button:focus {
			background: #fafafa;
			border-color: #999;
			color: #23282d;
		}
		.button:focus  {
			border-color: #5b9dd9;
			-webkit-box-shadow: 0 0 3px rgba( 0, 115, 170, .8 );
			box-shadow: 0 0 3px rgba( 0, 115, 170, .8 );
			outline: none;
		}
		.button:active {
			background: #eee;
			border-color: #999;
			-webkit-box-shadow: inset 0 2px 5px -3px rgba( 0, 0, 0, 0.5 );
			box-shadow: inset 0 2px 5px -3px rgba( 0, 0, 0, 0.5 );
			-webkit-transform: translateY(1px);
			-ms-transform: translateY(1px);
			transform: translateY(1px);
		}
		</style>
	</head>
	<body id="error-page">
		<h1><?php _e( 'Maintenance' ); ?></h1>
		<p><?php _e( 'Briefly unavailable for scheduled maintenance. Check back in a minute.' ); ?></p>
	</body>
</html>
		<?php
		exit;
	}
}
add_action('init', 'wpmaintenanceswitch_maintenancepage');

function wpmaintenanceswitch_links( $link ) {
	return array_merge( $link, array('<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2VYPRGME8QELC" target="_blank" rel="noopener noreferrer">' . __('Donate') . '</a>') );
}
add_filter( 'plugin_action_links_' . plugin_basename( WPMS_FILE ), 'wpmaintenanceswitch_links');