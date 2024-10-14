<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wp-locomotive.com/plugins/tookapic/
 * @since      0.1.0
 *
 * @package    photo-feed-tookapic
 * @subpackage photo-feed-tookapic/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    photo-feed-tookapic
 * @subpackage photo-feed-tookapic/public
 * @author     Rafał Osiński <hello@wp-locomotive.com>
 */
class PhotoFeedTookapic_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $photo_feed_tookapic    The ID of this plugin.
	 */
	private $photo_feed_tookapic;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @param      string    $photo_feed_tookapic       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $photo_feed_tookapic, $version ) {

		$this->photo_feed_tookapic = $photo_feed_tookapic;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in PhotoFeedTookapic_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The PhotoFeedTookapic_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->photo_feed_tookapic, plugin_dir_url( __FILE__ ) . 'css/photo-feed-tookapic-public.css', array(), $this->version, 'all' );

	}
}
