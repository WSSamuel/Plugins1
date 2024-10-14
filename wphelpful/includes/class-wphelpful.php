<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://wphelpful.com
 * @since      1.0.0
 *
 * @package    WPHelpful
 * @subpackage wphelpful/includes
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
 * @since      1.0.0
 * @package    WPHelpful
 * @subpackage wphelpful/includes
 * @author     Zack Gilbert <zack@zackgilbert.com>
 */
class WPHelpful {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WPHelpful_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
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
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = WPHELPFUL_PREFIX;
		$this->version = '1.2.4';
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
	 * - WPHelpful_Loader. Orchestrates the hooks of the plugin.
	 * - WPHelpful_i18n. Defines internationalization functionality.
	 * - WPHelpful_Admin. Defines all hooks for the admin area.
	 * - WPHelpful_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wphelpful-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wphelpful-i18n.php';

		/**
		 * The class responsible for defining actions that are used in both admin and public sections
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wphelpful-common.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wphelpful-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wphelpful-public.php';

		$this->loader = new WPHelpful_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the WPHelpful_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new WPHelpful_i18n();

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

		$plugin_admin = new WPHelpful_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		// adding settings page and metaboxes
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_options_page' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_settings' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'add_feedback_metabox' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'save_feedback' );
		// adding bulk actions
		$this->loader->add_action( 'admin_footer-edit.php', $plugin_admin, 'add_bulk_actions' );
		$this->loader->add_action( 'load-edit.php', $plugin_admin, 'save_bulk_completable' );
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'show_bulk_action_notice' );
		// adding custom edit column + quick edit
		$this->loader->add_action( 'manage_pages_columns', $plugin_admin, 'add_custom_column_header' );
		$this->loader->add_action( 'manage_posts_columns', $plugin_admin, 'add_custom_column_header' );
		$this->loader->add_action( 'manage_pages_custom_column', $plugin_admin, 'add_custom_column_value', 10, 2 );
		$this->loader->add_action( 'manage_posts_custom_column', $plugin_admin, 'add_custom_column_value', 10, 2 );
		$this->loader->add_action( 'quick_edit_custom_box', $plugin_admin, 'add_custom_quick_edit', 10, 2 );
		// adding custom completion column for users
		$this->loader->add_action( 'manage_users_columns', $plugin_admin, 'add_user_column_header' );
		$this->loader->add_action( 'manage_users_custom_column', $plugin_admin, 'add_user_column_value', 11, 3 );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_post_feedback_page' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_user_feedback_page' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_site_feedback_page' );

		// allow users to delete buttons:
		$this->loader->add_action( 'wp_ajax_wph_delete_feedback', $plugin_admin, 'delete_feedback' );
		$this->loader->add_action( 'wp_ajax_nopriv_wph_delete_feedback', $plugin_admin, 'delete_feedback' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new WPHelpful_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_filter( 'script_loader_tag', $plugin_public, 'append_script_defer', 10, 2);
		
		$this->loader->add_filter( 'the_content', $plugin_public, 'append_completion_code', 1 );

		// Custom ajax functions:
		$this->loader->add_action( 'admin_post_wphelpful_save_feedback', $plugin_public , 'save_feedback' );
		$this->loader->add_action( 'wp_ajax_wphelpful_save_feedback', $plugin_public , 'save_feedback' );
    $this->loader->add_action( 'wp_ajax_nopriv_wphelpful_save_feedback', $plugin_public , 'save_feedback' );
		
		// Add shortcodes:
		$this->loader->add_shortcode( 'wphelpful', $plugin_public, 'shortcode_wphelpful_cb' );

		add_filter( 'widget_text', 'do_shortcode' ); // allow text widgets to render shortcodes
    $this->loader->add_action( 'wp_head', $plugin_public, 'append_custom_styles' );
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
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WPHelpful_Loader    Orchestrates the hooks of the plugin.
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
