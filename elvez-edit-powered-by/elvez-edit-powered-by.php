<?php

/**
 * @link              https://elvez.co.jp
 * @since             1.0.0
 * @package           Elvez_Edit_Powered_By
 *
 * @wordpress-plugin
 * Plugin Name:       Elvez Edit Powered By
 * Plugin URI:        https://wordpress.org/plugins/elvez-edit-powered-by
 * Description:       This plugin can hide or replace the 'Powered by' text in footer of the twentytwenty Wordpress theme.
 * Version:           1.0.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Elvez Inc,
 * Author URI:        https://elvez.co.jp
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       elvez-edit-powered-by
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
define( 'ELVEZ_EDIT_POWERED_BY_VERSION', '1.0.3' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-elvez-edit-powered-by-activator.php
 */
function activate_elvez_edit_powered_by() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-elvez-edit-powered-by-activator.php';
	Elvez_Edit_Powered_By_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-elvez-edit-powered-by-deactivator.php
 */
function deactivate_elvez_edit_powered_by() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-elvez-edit-powered-by-deactivator.php';
	Elvez_Edit_Powered_By_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_elvez_edit_powered_by' );
register_deactivation_hook( __FILE__, 'deactivate_elvez_edit_powered_by' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-elvez-edit-powered-by.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_elvez_edit_powered_by() {

	$plugin = new Elvez_Edit_Powered_By();
	$plugin->run();

}
run_elvez_edit_powered_by();
