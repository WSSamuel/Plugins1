<?php
/*
Plugin Name: EU Cookie Law Notification
Plugin URI: http://www.designscents.co.uk/plugins/eu-cookie-law-otification/
Description: EU Cookie Law Notification displays a notification to users to ask the first time visitors for their consent using cookies to comply the EU cookie law, which applies to how you use cookies and similar technologies for storing information on a user’s equipment such as their computer or mobile device. It creates a detail page on the first activation.
Version: 1.0.2
Author: Junnie
Author URI: http://www.designscents.co.uk
License: GPLv2
*/

define( 'OPTION_NAME', 'cookie_notification_jc_options' );

define( 'OPTION_KEY_NOTIFICATION_TEXT', 'notification_text' );
define( 'OPTION_KEY_ACCEPT_TEXT', 'accept_text' );
define( 'OPTION_KEY_LINK_TO_DETAILS', 'link_text_to_details' );
define( 'OPTION_KEY_DETAILS_PAGE_ID', 'details_page_id' );
define( 'OPTION_KEY_NOTIFICATION_WIDTH', 'notification_width' );
define( 'OPTION_KEY_POSITION', 'position' );
define( 'OPTION_KEY_NOTIFICATION_OPACITY', 'background_opacity' );




register_activation_hook( __FILE__, 'cookie_notification_jc_activation' );
register_deactivation_hook( __FILE__, 'cookie_notification_jc_deactivation' );
register_uninstall_hook( __FILE__, 'cookie_notification_jc_uninstall' );

function cookie_notification_jc_activation()
{
	if( !get_option( OPTION_NAME ) )
	{
		// Create a detail page on activation
		$init_content_text = 'Cookies are small, harmless files of letters and numbers that are placed on the hard drive of your computer, smartphone or other device, or in your browser memory if you agree.';
		$init_page_title = 'Cookie Policy';
		
		$details_page = array(
			'comment_status' => 'closed',
			'ping_status'    => 'closed',
			'post_content'   => $init_content_text,
			'post_status'    => 'publish',
			'post_title'     => $init_page_title,
			'post_type'      => 'page'
		);
		
		$page_id = wp_insert_post( $details_page );
		
		// Create a default option array and update it to the database
		$cookie_notification_jc_options_arr = array(
			OPTION_KEY_NOTIFICATION_TEXT => 'We use cookies to ensure that we give you the best experience on our website. By continuing to browse this site you give consent for cookies to be used.',
			OPTION_KEY_ACCEPT_TEXT => 'Continue',
			OPTION_KEY_LINK_TO_DETAILS => 'Find out more »',
			OPTION_KEY_DETAILS_PAGE_ID => $page_id,
			OPTION_KEY_NOTIFICATION_WIDTH => '95%',
			OPTION_KEY_POSITION => 'bottom',
			OPTION_KEY_NOTIFICATION_OPACITY => '75'
		);
		
		update_option( OPTION_NAME, $cookie_notification_jc_options_arr );
	}
	else
	{
		// If it was deactivated, the policy deatil page had been unpublished
		// When it is re activated, check if the page exists
		// if it does, publish the page back
		// if it doesn't, create one
		$cookie_notification_jc_options_arr = get_option( OPTION_NAME );
		$details_page_id = $cookie_notification_jc_options_arr[ OPTION_KEY_DETAILS_PAGE_ID ];
		
		if( get_page( $details_page_id ) )
		{
			$detail_page = array();
			$detail_page[ 'ID' ] = $details_page_id;
			$detail_page[ 'post_status' ] = 'publish';
			
			wp_update_post( $detail_page );
		}
		else
		{
			$new_details_page = array(
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
				'post_content'   => $cookie_notification_jc_options_arr[ 'post_content' ],
				'post_status'    => 'publish',
				'post_title'     => 'Cookie Policy',
				'post_type'      => 'page'
			);
			
			$new_page_id = wp_insert_post( $new_details_page );
			
			// Update the option with new page ID
			$options = get_option( OPTION_NAME );
			$cookie_notification_jc_options_arr = array(
				OPTION_KEY_NOTIFICATION_TEXT => $options[ OPTION_KEY_NOTIFICATION_TEXT ],
				OPTION_KEY_ACCEPT_TEXT => $options[ OPTION_KEY_ACCEPT_TEXT ],
				OPTION_KEY_LINK_TO_DETAILS => $options[ OPTION_KEY_LINK_TO_DETAILS ],
				OPTION_KEY_DETAILS_PAGE_ID => $new_page_id,
				OPTION_KEY_NOTIFICATION_WIDTH => $options[ OPTION_KEY_NOTIFICATION_WIDTH ],
				OPTION_KEY_POSITION => $options[ OPTION_KEY_POSITION ],
				OPTION_KEY_NOTIFICATION_OPACITY => $options[ OPTION_KEY_NOTIFICATION_OPACITY ]
			);
			
			update_option( OPTION_NAME, $cookie_notification_jc_options_arr );
		}
	}
}

function cookie_notification_jc_deactivation()
{		
	// Unpublish the policy page
	$cookie_notification_jc_options_arr = get_option( OPTION_NAME );
	$details_page_id = $cookie_notification_jc_options_arr[ OPTION_KEY_DETAILS_PAGE_ID ];
	
	if( get_page( $details_page_id ) )
	{
		$detail_page = array();
		$detail_page[ 'ID' ] = $details_page_id;
		$detail_page[ 'post_status' ] = 'pending';
		
		wp_update_post( $detail_page );
	}
	
	
	//delete_option( OPTION_NAME );
}

function cookie_notification_jc_uninstall()
{
	//if uninstall not called from WordPress exit
	//if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
		//exit ();
	
	// Delete this plugin options
	delete_option( OPTION_NAME );
}

	






/*
 *
 * ####################
 * ADMIN SETTING
 * ####################
 *
 */

add_action( 'admin_init', 'cookie_notification_jc_admin_init' );

add_action( 'admin_menu', 'cookie_notification_jc_setting_menu' );





function cookie_notification_jc_admin_init()
{
	// Register the plugin option group
	register_setting( 'cookie-notification-jc-option-group', OPTION_NAME, 'cookie_notification_jc_sanitize_options' );
	
	// Load a javascript for the plugin that depends on jQuery
	wp_enqueue_script( 'cookie-notification-jc-admin-javascript-main', plugins_url( 'js/admin-main.js', __FILE__ ), array( 'jquery', 'jquery-ui-core',  'jquery-ui-slider' ) );
	
	// Register a CSS for the admin area
	wp_register_style( 'cookie-notification-jc-admin-css-main', plugins_url( 'css/admin_main.css', __FILE__ ) );
}

function cookie_notification_jc_sanitize_options( $options )
{
	//update_option( OPTION_NAME, $options );
	
	$options[ OPTION_KEY_NOTIFICATION_TEXT ] = ( !empty( $options[ OPTION_KEY_NOTIFICATION_TEXT ] ) ) ? sanitize_text_field( $options[ OPTION_KEY_NOTIFICATION_TEXT ] ) : '';
	
	$options[ OPTION_KEY_NOTIFICATION_WIDTH ] = ( !empty( $options[ OPTION_KEY_NOTIFICATION_WIDTH ] ) ) ? $options[ OPTION_KEY_NOTIFICATION_WIDTH ] : '100%';
	
	return $options;
}

function cookie_notification_jc_setting_menu()
{
	$page = add_options_page( __( 'Cookie Notification Setting Menu', 'cookie-notification-jc' ), __( 'Cookie Notification Setting', 'cookie-notification-jc' ), 'manage_options', 'cookie-notification-jc-setting', 'cookie_notification_jc_setting_page' );
	
	/* Using registered $page handle to hook stylesheet loading */
    add_action( 'admin_print_styles-' . $page, 'cookie_notification_jc_styles' );
}

function cookie_notification_jc_styles()
{
	wp_enqueue_style( 'cookie-notification-jc-admin-css-main' );
}

// Build the plugin settings page
function cookie_notification_jc_setting_page()
{
	// include the setting form
	$setting_form = 'include/include_setting_form.php';
	include( $setting_form );
}





/*
 *
 * ####################
 * FRONT END
 * ####################
 *
 */
 
// Check if the cookie exists. Set one if not and insert the notification
add_action( 'send_headers', 'cookie_notification_jc_send_headers' );
 
// Link a plugin javascript that depends on jQuery
// Register and Load a CSS for the plugin
add_action( 'wp_enqueue_scripts', 'cookie_notification_jc_javascript_css_main' );



function cookie_notification_jc_send_headers()
{		
	$cookie_name = 'cookie-notification-jc';
	$cookie_value = 'cookie-notification-jc-cookie-consent-given';
	
	if( !isset( $_COOKIE[ $cookie_name ] ) )
	{	
		setcookie( $cookie_name, $cookie_value, mktime(0, 0, 0, 12, 31, 2020) );
		
		// Insert the notification html
		add_action( 'wp_footer', 'cookie_notification_jc_toggle_notification' );
	}
}

function cookie_notification_jc_javascript_css_main()
{
	wp_enqueue_script( 'cookie-notification-jc-javascript-main', plugins_url( 'js/main.js', __FILE__ ), array( 'jquery', 'jquery-effects-slide' ) );
	
	wp_register_style( 'cookie-notification-jc-css-main', plugins_url( 'css/main.css', __FILE__ ) );
	wp_enqueue_style( 'cookie-notification-jc-css-main' );
}

function cookie_notification_jc_toggle_notification()
{
	$options = get_option( OPTION_NAME );
	
	$notification_text = $options[ OPTION_KEY_NOTIFICATION_TEXT ];
	$accept_text = $options[ OPTION_KEY_ACCEPT_TEXT ];
	$link_text_to_details = $options[ OPTION_KEY_LINK_TO_DETAILS ];
	$details_page_id = $options[ OPTION_KEY_DETAILS_PAGE_ID ];
	$notification_width = $options[ OPTION_KEY_NOTIFICATION_WIDTH ];
	$position = $options[ OPTION_KEY_POSITION ];
	$background_opacity = ( $options[ OPTION_KEY_NOTIFICATION_OPACITY ] ) * 0.01;
		
	$notification = 'include/include_notification.php';
	include( $notification );
}