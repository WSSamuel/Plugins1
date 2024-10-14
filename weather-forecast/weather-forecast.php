<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://themeegg.com
 * @since             1.0.0
 * @package           Weather_Forecast
 *
 * @wordpress-plugin
 * Plugin Name:       Weather Forecast
 * Plugin URI:        https://themeegg.com/plugins/weather-forecast
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            ThemeEgg
 * Author URI:        http://themeegg.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       weather-forecast
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-weather-forecast-activator.php
 */
function activate_weather_forecast() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-weather-forecast-activator.php';
	Weather_Forecast_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-weather-forecast-deactivator.php
 */
function deactivate_weather_forecast() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-weather-forecast-deactivator.php';
	Weather_Forecast_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_weather_forecast' );
register_deactivation_hook( __FILE__, 'deactivate_weather_forecast' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-weather-forecast.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_weather_forecast() {

	$plugin = new Weather_Forecast();
	$plugin->run();

}
run_weather_forecast();
