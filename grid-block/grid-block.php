<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://digitalapps.co
 * @since             1.0.0
 * @package           Grid_Block
 *
 * @wordpress-plugin
 * Plugin Name:       Grid Block
 * Plugin URI:        https://digitalapps.co/wordpress-plugins/grid-block/
 * Description:       Responsive grid block based on the twelve column system for Gutenberg.
 * Version:           1.0.6
 * Author:            Digital Apps
 * Author URI:        https://digitalapps.co
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       grid-block
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
define( 'DAGB_VERSION', '1.0.6' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-grid-block-activator.php
 */
function activate_grid_block() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-grid-block-activator.php';
    Grid_Block_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-grid-block-deactivator.php
 */
function deactivate_grid_block() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-grid-block-deactivator.php';
    Grid_Block_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_grid_block' );
register_deactivation_hook( __FILE__, 'deactivate_grid_block' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-grid-block.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_grid_block() {

    $plugin = new Grid_Block();
    $plugin->run();

}
run_grid_block();
