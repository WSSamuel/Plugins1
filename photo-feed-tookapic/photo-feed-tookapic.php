<?php

/**
 * @link              https://wp-locomotive.com/plugins/tookapic/
 * @package           photo_feed_tookapic
 *
 * @wordpress-plugin
 * Plugin Name:       Photo Feed - Tookapic
 * Plugin URI:        https://wp-locomotive.com/plugins/tookapic/
 * Description:       Tookapic Photos Feed Plugin is a widget for Tookapic Users who wants to share their photos on own WordPress blog or website.
 * Version:           0.2.2
 * Author:            WP Foxly
 * Author URI:        https://wpfoxly.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       photo_feed_tookapic
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'PHOTO_FEED_TOOKAPIC_VERSION', '0.2.2' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-photo-feed-tookapic-activator.php
 */
function activate_photo_feed_tookapic() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-photo-feed-tookapic-activator.php';
	PhotoFeedTookapic_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-photo-feed-tookapic-deactivator.php
 */
function deactivate_photo_feed_tookapic() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-photo-feed-tookapic-deactivator.php';
	PhotoFeedTookapic_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_photo_feed_tookapic' );
register_deactivation_hook( __FILE__, 'deactivate_photo_feed_tookapic' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-photo-feed-tookapic.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1.0
 */
function run_photo_feed_tookapic() {

	$plugin = new PhotoFeedTookapic();
	$plugin->run();

}
run_photo_feed_tookapic();
