<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://jonmendoza.ph
 * @since      1.0.0
 *
 * @package    Insert_Image_Alt_Text
 * @subpackage Insert_Image_Alt_Text/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Insert_Image_Alt_Text
 * @subpackage Insert_Image_Alt_Text/includes
 * @author     Jon Vincent Mendoza <jonazodnem26@gmail.com>
 */
class Insert_Image_Alt_Text_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'insert-image-alt-text',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
