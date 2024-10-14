<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://wp-locomotive.com/plugins/tookapic/
 * @since      0.1.0
 *
 * @package    photo-feed-tookapic
 * @subpackage photo-feed-tookapic/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.1.0
 * @package    photo-feed-tookapic
 * @subpackage photo-feed-tookapic/includes
 * @author     Rafał Osiński <hello@wp-locomotive.com>
 */
class PhotoFeedTookapic_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.1.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'photo_feed_tookapic',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
