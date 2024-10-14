<?php
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Convertix_Pixel
 * @subpackage Convertix_Pixel/includes
 */

define( 'CONVERTIX_PIXEL_BASENAME', 'convertix-pixel' );
define( 'CONVERTIX_PIXEL_TRANSLATION_DOMAIN', 'convertix-pixel' );
define( 'CONVERTIX_PIXEL_COOKIE_NAME', '_gtm_ssc' );

define( 'CONVERTIX_PIXEL_ADMIN_SLUG', 'convertix-pixel-admin-settings' );
define( 'CONVERTIX_PIXEL_ADMIN_OPTIONS', 'convertix-pixel-admin-options' );

define( 'CONVERTIX_PIXEL_ADMIN_GROUP', 'convertix-pixel-admin-group' );
define( 'CONVERTIX_PIXEL_ADMIN_GROUP_GENERAL', 'convertix-pixel-admin-group-general' );

define( 'CONVERTIX_PIXEL_META_PIXEL_ID_1 ', 'convertix-pixel-fb_pixel1' );
define( 'CONVERTIX_PIXEL_META_PIXEL_TOKEN_API_1 ', 'convertix-pixel-fb_pixel_api1' );
define( 'CONVERTIX_PIXEL_META_PIXEL_TESTID_1 ', 'convertix-pixel-fb_pixel_testid1' );
define( 'CONVERTIX_PIXEL_META_PIXEL_ID_2 ', 'convertix-pixel-fb_pixel2' );
define( 'CONVERTIX_PIXEL_META_PIXEL_TOKEN_API_2 ', 'convertix-pixel-fb_pixel_api2' );
define( 'CONVERTIX_PIXEL_META_PIXEL_TESTID_2 ', 'convertix-pixel-fb_pixel_testid2' );

define( 'CONVERTIX_PIXEL_GOOGLE_UNIVERSAL_ANALYTICS_1 ', 'convertix-pixel-ga_pixel1' );
define( 'CONVERTIX_PIXEL_GOOGLE_ANALYTICS4_1 ', 'convertix-pixel-ga4_pixel1' );
define( 'CONVERTIX_PIXEL_GOOGLE_ADWORDS_ID_1 ', 'convertix-pixel-gads_conversionID1' );
define( 'CONVERTIX_PIXEL_GOOGLE_OPTIMIZE_1 ', 'convertix-pixel-ggOptimize' );
define( 'CONVERTIX_PIXEL_GOOGLE_ANTIFLICKERING_1 ', 'convertix-pixel-optimizeAntiFlickering' );

define( 'CONVERTIX_PIXEL_TIKTOK_PIXEL_1 ', 'convertix-pixel-ttk_pixel1' );
define( 'CONVERTIX_PIXEL_TIKTOK_PIXEL_TOKEN_API_1 ', 'convertix-pixel-ttk_pixel_api1' );
define( 'CONVERTIX_PIXEL_TIKTOK_PIXEL_TESTID_1 ', 'convertix-pixel-ttk_pixel_testid1' );

define( 'CONVERTIX_PIXEL_LINKEDIN_INSIGHT_TAG_1 ', 'convertix-pixel-in_pixel1' );

define( 'CONVERTIX_PIXEL_ACTIVECAMPAIGN_PIXEL_1 ', 'convertix-pixel-activecampaign_pixel' );
define( 'CONVERTIX_PIXEL_ACTIVECAMPAIGN_EVENTKEY_1 ', 'convertix-pixel-activecampaign_eventKey' );

define( 'CONVERTIX_PIXEL_SERVER_CONTAINER_URL ', 'convertix-pixel-transportURLServer' );
define( 'CONVERTIX_PIXEL_CLIENT_EVENT ', 'convertix-pixel-cli_GTMevent' );
define( 'CONVERTIX_PIXEL_CLIENT_VARIABLE ', 'convertix-pixel-cli_GTMVariable' );
define( 'CONVERTIX_PIXEL_CLIENT_TOKEN ', 'convertix-pixel-convertix_token' );

define( 'CONVERTIX_PIXEL_WEB_CONTAINER_ID ', 'convertix-pixel-gtm_cli_container' );


define( 'CONVERTIX_PIXEL_WEB_CONTAINER_PLACEMENT', 'convertix-pixel-placement' );
define( 'CONVERTIX_PIXEL_WEB_CONTAINER_PLACEMENT_ON', 'convertix-pixel-placement-on' );
define( 'CONVERTIX_PIXEL_WEB_CONTAINER_PLACEMENT_OFF', 'convertix-pixel-placement-off' );

/**
 * The core plugin class.
 */
class Convertix_Pixel {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Convertix_Pixel_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $convertix_pixel The string used to uniquely identify this plugin.
	 */
	protected $convertix_pixel;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * The Convertix Container.
	 *
	 * @since    1.4.0
	 * @access   protected
	 * @var      string Convertix Container's Name.
	 */
	protected $convertix_container;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'CONVERTIX_PIXEL_VERSION' ) ) {
			$this->version = CONVERTIX_PIXEL_VERSION;
		} else {
			$this->version = '1.0.1';
		}
		$this->convertix_pixel = 'convertix-pixel';
		$this->convertix_container = 'GTM-TBC3PNT';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Convertix_Pixel_Loader. Orchestrates the hooks of the plugin.
	 * - Convertix_Pixel_I18n. Defines internationalization functionality.
	 * - Convertix_Pixel_Admin. Defines all hooks for the admin area.
	 * - Convertix_Pixel_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-convertix-pixel-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-convertix-pixel-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-convertix-pixel-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-convertix-pixel-public.php';

		$this->loader = new Convertix_Pixel_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Convertix_Pixel_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Convertix_Pixel_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Convertix_Pixel_Admin();

		$this->loader->add_action( 'admin_init', $plugin_admin, 'admin_init' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'display_admin_page' );
		$this->loader->add_filter( 'plugin_action_links', $plugin_admin, 'add_plugin_action_links', 10, 2 );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Convertix_Pixel_Public( $this->get_convertix_pixel(), $this->get_version(), $this->get_convertix_container() );

		$this->loader->add_action( 'wp_head', $plugin_public, 'ctx_head' );

		$this->loader->add_action( 'body_open', $plugin_public, 'ctx_body' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 * @since     1.0.0
	 */
	public function get_convertix_pixel() {
		return $this->convertix_pixel;
	}

	/**
	 * The Container's name used to identify it within the context of Convertix
	 * and to define which environment the user is on (testing, development or live).
	 *
	 * @return    string    The Convertix container's name.
	 * @since     1.4.0
	 */
	public function get_convertix_container() {
		return $this->convertix_container;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Convertix_Pixel_Loader    Orchestrates the hooks of the plugin.
	 * @since     1.0.0
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     1.0.0
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Get attr option.
	 *
	 * @param string $id The option ID.
	 *
	 * @return string
	 */
	protected function get_option( $id ) {
		return isset( get_option( CONVERTIX_PIXEL_ADMIN_OPTIONS )[ $id ] ) ? get_option( CONVERTIX_PIXEL_ADMIN_OPTIONS )[ $id ] : '';
	}
}
