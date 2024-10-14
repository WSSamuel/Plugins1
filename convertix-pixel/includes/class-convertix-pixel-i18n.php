<?php
/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Convertix_Pixel
 * @subpackage Convertix_Pixel/includes
 * @file       class-convertix-pixel-i18n.php
 */

/**
 * Define the internationalization functionality.
 */
class Convertix_Pixel_I18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'convertix-pixel',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}


}
