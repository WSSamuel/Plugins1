<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wp-locomotive.com/plugins/tookapic/
 * @since      0.1.0
 *
 * @package    photo-feed-tookapic
 * @subpackage photo-feed-tookapic/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.1.0
 * @package    photo-feed-tookapic
 * @subpackage photo-feed-tookapic/includes
 * @author     Rafał Osiński <hello@wp-locomotive.com>
 */
class PhotoFeedTookapic {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      PhotoFeedTookapic_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      string    $photo_feed_tookapic    The string used to uniquely identify this plugin.
	 */
	protected $photo_feed_tookapic;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function __construct() {
		if ( defined( 'PHOTO_FEED_TOOKAPIC_VERSION' ) ) {
			$this->version = PHOTO_FEED_TOOKAPIC_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->photo_feed_tookapic = 'photo_feed_tookapic';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_public_hooks();
		$this->define_api_connections();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - PhotoFeedTookapic_Loader. Orchestrates the hooks of the plugin.
	 * - PhotoFeedTookapic_i18n. Defines internationalization functionality.
	 * - PhotoFeedTookapic_Admin. Defines all hooks for the admin area.
	 * - PhotoFeedTookapic_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-photo-feed-tookapic-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-photo-feed-tookapic-i18n.php';

		/**
		 * The class responsible for implementation plugin widget
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-photo-feed-tookapic-widget.php';

		/**
		 * The class responsible for defining all actions for Tookapic API
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-photo-feed-tookapic-api.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-photo-feed-tookapic-public.php';

		$this->loader = new PhotoFeedTookapic_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the PhotoFeedTookapic_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new PhotoFeedTookapic_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the PhotoFeedTookapic_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function define_api_connections() {

		new PhotoFeedTookapic_Api();

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new PhotoFeedTookapic_Public( $this->get_photo_feed_tookapic(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.1.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_photo_feed_tookapic() {
		return $this->photo_feed_tookapic;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    PhotoFeedTookapic_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
