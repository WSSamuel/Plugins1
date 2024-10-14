<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://themeegg.com
 * @since      1.0.0
 *
 * @package    Weather_Forecast
 * @subpackage Weather_Forecast/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Weather_Forecast
 * @subpackage Weather_Forecast/includes
 * @author     ThemeEgg Team <themeeggofficial@gmail.com>
 */
class Weather_Forecast_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'weather-forecast',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . 'i18n/languages/'
		);

	}



}
