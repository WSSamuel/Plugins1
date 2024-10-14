<?php
    /*
    Plugin Name: Simple Login SC
    Plugin URI: http://www.pointzeronord.com
    Description: Add a simple login form via a shortcode and does not add any extraneous code to slowdown your website. It just uses the core functions of WordPress.
    Author: PointZeroNord, Ghyslain Drolet
    Version: 0.8
    Author URI: http://www.pointzeronord.com
    License: Copyright(c) PointZeroNord. All Rights Reserved.
     *
	 * Released under the GPL license
	 * http://www.opensource.org/licenses/gpl-license.php
	 *
	 * This is an add-on for WordPress
	 * http://wordpress.org/
	 *
	 * **********************************************************************
	 * This program is free software; you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published by
	 * the Free Software Foundation; either version 2 of the License, or
	 * (at your option) any later version.
	 *
	 * This program is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	 * GNU General Public License for more details.
	 * **********************************************************************
	*/
	
/* function -  Builds login form and displays it */

	function slsc_form( $atts ) {

		global $current_user;
     	get_currentuserinfo();
		
/* Retrieve custom text for login form */

		extract( shortcode_atts( array(
		'username_label' => __('Username'),
		'password_label' => __('Password'),
		'button_text' => __('Log In'),
		'welcome_text' => __('Welcome','slsc'),
		'logouttext' => __('Log out'),
		), $atts ) );
		
		update_option('slsc_logouttext', $logouttext);
		update_option('slsc_username', $username_label);
		update_option('slsc_password', $password_label);
		update_option('slsc_button_text', $button_text);
		update_option('slsc_welcome_text', $welcome_text);

/* Display form based on context login or logout*/

		if (is_user_logged_in())
			return get_option('slsc_welcome_text').', ' .$current_user->display_name. '<br />' . wp_loginout_slsc('',false);
		return wp_login_form(array(
		'label_username' => get_option('slsc_username'),
		'label_password' => get_option('slsc_password'),
		'label_log_in' => get_option('slsc_button_text'),
		'remember' => false,
		'echo' => false));
	}
	
/* function -  Registering plugin page in tools menu */

	function slsc_menu () {
		add_management_page( 'Simple Login SC', 'Simple Login SC', 'manage_options', 'simple_login_sc', 'simple_login_sc_usage' );
	}
	
/* function -  Builds plugin page */

	function simple_login_sc_usage(){
	?>

	<h1>Simple Login SC</h1>
	<br />
	
	<h2><?php echo __('Simple Login SC does just what it means',slsc);?></h2>
	<p><?php echo __('Simple Login SC does not mess with other plugins because it does just login or logout a user. Nothing more. Nothing less.<br />It uses the core functions of WordPress thus not slowing down your site. No fancy stuff or hard settings. This is just a login plugin!',slsc);?></p>
	
	<h2><?php echo __('Using Simple Login SC is absolutely easy',slsc);?></h2>
	<p><?php echo __('Just type the shortcode where you want a login form to show.',slsc);?></p>
	<p><?php echo __('Use [sl_shortcode] shortcode to add a login form to a page, post or in a text/html widget.',slsc);?></p>
	<p><?php echo __('You can optionally set the labels for "username", "password", the submit button and/or the welcome message, the logout text. Just by adding text to the shortcode.<br />',slsc);?></p>
	<h3><?php echo __('Usage',slsc);?></h3>
	<p><strong><?php echo __('Example: [sl_shortcode username_label="What is your name?" password_label="Password Please!" button_text="Let me in!" welcome_text="Hello" logouttext="Let\'s go outside!"]',slsc);?></strong></p>
	<img src="<?php echo plugins_url('screenshot-1.jpg', __FILE__ ); ?>" /><br />
	<img src="<?php echo plugins_url('screenshot-2.jpg', __FILE__ ); ?>" />
	<p><?php echo __('This is very useful if the language pack is not available in your language or if you have a multilangual site running WPML.',slsc);?></p>
	<p><?php echo __('If you do not set one or all of the optional text, the default text of WordPress and the plugin will be used.',slsc);?></p>

	<h2><?php echo __('Need more?',slsc);?></h2>
	<h3><?php echo __('Redirection',slsc);?></h3>
	<p><?php echo __('Has said before, Simple Login SC is just a login plugin. But if you need to redirect users on login, we suggest you use <a href="https://wordpress.org/plugins/peters-login-redirect/" target="_blank">Peter\'s Login Redirect</a> which has redirection base on user, roles...<br />And Simple Login SC does not conflict with Peter\'s Login Redirect. Great simple plugins that work together!',slsc);?></p>
	<h3><?php echo __('Styling',slsc);?></h3>
	<p><?php echo __('If your theme does not style the login CSS class of WordPress or does not have a Custom CSS option, you can use a plugin like <a href="https://wordpress.org/plugins/simple-custom-css/" target="_blank">Simple Custom CSS</a>.',slsc);?></p>
	<p><?php echo __('The CSS class you can customize are:',slsc);?> </p>
	<ul>
		<li>.login-username</li>
		<li>.login-username label</li>
		<li>.login-username .input</li>
		<li>.login-password</li>
		<li>.login-password label</li>
		<li>.login-password .input </li>
		<li>.login-submit</li>
		<li>.login-submit .button-primary</li>
	</ul>
	
	<p><?php echo __('Have a login fun!',slsc);?></p>
	
<?php

	}

/* function -  Registering language file folder */

	function simple_login_sc_text_domain(){
		load_plugin_textdomain('slsc', FALSE, basename( dirname( __FILE__ ) ) .'/languages');
	}
	
/* function -  Builds logout link */

	function wp_loginout_slsc($redirect = '', $echo = true) {
		$link = '<a href="' . esc_url( wp_logout_url($redirect) ) . '">' . get_option('slsc_logouttext') . '</a>';

		if ( $echo ) {
			echo apply_filters( 'loginout', $link );
		} else {
			return apply_filters( 'loginout', $link );
		}
	}

/* function -  Registering plugin and shortcode */

	add_action( 'plugins_loaded',  'simple_login_sc_text_domain' );
	add_action( 'admin_menu' , 'slsc_menu' );
	add_shortcode('sl_shortcode','slsc_form');
	add_filter( 'widget_text', 'do_shortcode');

?>
