<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://elvez.co.jp
 * @since      1.0.0
 *
 * @package    Elvez_Edit_Powered_By
 * @subpackage Elvez_Edit_Powered_By/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Elvez_Edit_Powered_By
 * @subpackage Elvez_Edit_Powered_By/includes
 * @author     Elvez, Inc. <info@elvez.co.jp>
 */
class Elvez_Edit_Powered_By_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.1
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'elvez-edit-powered-by',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
