<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://roadmap.space
 * @since      1.0.0
 *
 * @package    Roadmap_Space
 * @subpackage Roadmap_Space/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Roadmap_Space
 * @subpackage Roadmap_Space/admin
 * @author     Roadmap <support@roadmap.space>
 */
class Roadmap_Space_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {}

	/**
	 * Register the settings.
	 *
	 * @since    1.0.0
	 */
	public function register_settings() {

		add_option( "{$this->plugin_name}_roadmap_id");
		register_setting( "{$this->plugin_name}_options_group", "{$this->plugin_name}_roadmap_id" );

		add_option( "{$this->plugin_name}_feedback_widget", "all");
		register_setting( "{$this->plugin_name}_options_group", "{$this->plugin_name}_feedback_widget" );

	}

	/**
	 * Register the options page.
	 *
	 * @since    1.0.0
	 */
	public function register_options_page() {

		add_options_page('Roadmap', 'Roadmap', 'manage_options', $this->plugin_name, array( $this, 'options_page' ) );

	}

	/**
	 * Display the options page.
	 *
	 * @since    1.0.0
	 */
	public function options_page() {

		require plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/roadmap-space-admin-display.php';

	}

}
