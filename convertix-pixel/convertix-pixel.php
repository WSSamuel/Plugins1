<?php
/**
 * Main plugin file.
 *
 * @link              https://convertix.digital
 * @since             1.0.0
 * @package           Convertix_Pixel
 *
 * @wordpress-plugin
 * Plugin Name:       Convertix Pixel
 * Plugin URI:        https://convertix.digital/wp-plugin/
 * Description:       Convertix Pixel Integration
 * Version:           1.4.1
 * Author:            Convertix
 * Author URI:        https://convertix.digital
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       convertix_pixel
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'CONVERTIX_PIXEL_VERSION', '1.4.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-convertix_pixel-activator.php
 */
function activate_convertix_pixel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-convertix-pixel-activator.php';
	Convertix_Pixel_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-convertix_pixel-deactivator.php
 */
function deactivate_convertix_pixel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-convertix-pixel-deactivator.php';
	Convertix_Pixel_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_convertix_pixel' );
register_deactivation_hook( __FILE__, 'deactivate_convertix_pixel' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-convertix-pixel.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_convertix_pixel() {

	$plugin = new Convertix_Pixel();
	$plugin->run();

}

run_convertix_pixel();
