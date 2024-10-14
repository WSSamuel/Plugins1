<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://wp-locomotive.com/plugins/tookapic/
 * @since      0.1.0
 *
 * @package    photo-feed-tookapic
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'widget_photo_feed_tookapic_widget' );
delete_option( 'widget_photos_feed_tookapic_data' );
