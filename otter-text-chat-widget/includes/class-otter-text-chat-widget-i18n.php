<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://ottertext.com
 * @since      1.0.0
 *
 * @package    otter_text_chat_widget
 * @subpackage otter_text_chat_widget/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    otter_text_chat_widget
 * @subpackage otter_text_chat_widget/includes
 * @author     Otter Text <info@ottertext.com>
 */
class Otter_Text_Chat_Widget_I18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'otter_text_chat_widget',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
