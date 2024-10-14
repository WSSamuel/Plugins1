<?php
/**
 *	Uninstall script
 *
 * @package Responsive Investment Calculator
 * @since 1.0.0
 */

// Make sure this file is called from within Wordpress.
defined( 'WP_UNINSTALL_PLUGIN' ) or exit();

// Delete single site options.
delete_option( 'ric_options' );
	
// Delete options in multi-site installation.
delete_site_option( 'ric_options' );