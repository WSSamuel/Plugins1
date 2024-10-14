<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://jonmendoza.ph
 * @since             1.0.0
 * @package           Insert_Image_Alt_Text
 *
 * @wordpress-plugin
 * Plugin Name:       Insert Image Alt Text
 * Plugin URI:        https://wppb.me/
 * Description:       Tired of inserting alternative text in all images in your WordPress media? Insert Image Alt Text will automatically add alt text on them.

 * Version:           1.0.0
 * Author:            Jon Vincent Mendoza
 * Author URI:        https://jonmendoza.ph
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       insert-image-alt-text
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'INSERT_IMAGE_ALT_TEXT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-insert-image-alt-text-activator.php
 */
function activate_insert_image_alt_text() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-insert-image-alt-text-activator.php';
	Insert_Image_Alt_Text_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-insert-image-alt-text-deactivator.php
 */
function deactivate_insert_image_alt_text() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-insert-image-alt-text-deactivator.php';
	Insert_Image_Alt_Text_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_insert_image_alt_text' );
register_deactivation_hook( __FILE__, 'deactivate_insert_image_alt_text' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-insert-image-alt-text.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_insert_image_alt_text() {

	$plugin = new Insert_Image_Alt_Text();
	$plugin->run();

}
run_insert_image_alt_text();
