<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

delete_option( 'glxtm_sidebars' );

delete_option( 'glxtm_items' );

delete_option( 'glxtm_general' );

delete_option( 'glxtm_welcome_shown' );
delete_option( 'glxtm_rate_time' );
