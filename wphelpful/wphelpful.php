<?php

/**
 * @link              https://wphelpful.com
 * @since             1.0.0
 * @package           WPHelpful
 *
 * @wordpress-plugin
 * Plugin Name:       WPHelpful
 * Description:       A free and simple way to collect ratings and feedback from visitors.
 * Version:           1.2.4
 * Author:            Zack Gilbert and Paul Jarvis
 * Author URI:        https://wphelpful.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       WPHelpful
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

// Fix for 5.3. This variable wasn't added until 5.4.
if ( ! defined( 'JSON_UNESCAPED_UNICODE' ) ) {
  define( 'JSON_UNESCAPED_UNICODE', 256 );
}

// Define some variables we will use throughout the plugin:
define( 'WPHELPFUL_STORE_URL', 'https://wphelpful.com' );
define( 'WPHELPFUL_PRODUCT_NAME', 'WPHelpful' );
define( 'WPHELPFUL_PREFIX', 'wphelpful' );

function wpcomplete_is_installed() {
  return is_plugin_active( '../wpcomplete/wpcomplete.php' );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wphelpful-activator.php
 */
function activate_wphelpful() {
  require_once plugin_dir_path( __FILE__ ) . 'includes/class-wphelpful-activator.php';
  WPHelpful_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wphelpful-deactivator.php
 */
function deactivate_wphelpful() {
  require_once plugin_dir_path( __FILE__ ) . 'includes/class-wphelpful-deactivator.php';
  WPHelpful_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wphelpful' );
register_deactivation_hook( __FILE__, 'deactivate_wphelpful' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wphelpful.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wphelpful() {

  $plugin = new WPHelpful();
  $plugin->run();

}
run_wphelpful();
