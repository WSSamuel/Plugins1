<?php
/**
 * author_avatar
 *
 * @package   author-avatar
 * @author    Guillaume Kanoufi <guillaume@lostwebdesigns.com>
 * @license   GPL-2.0+
 * @link      http://lostwebdesigns.com
 * @copyright 12-16-2013 Company Name
 */

/**
 * author_avatar class.
 *
 * @package authorAvatar
 * @author  Guillaume Kanoufi <guillaume@lostwebdesigns.com>
 */
class authorAvatar{
	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $version = "1.0.2";

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = "author-avatar";

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action("init", array($this, "load_plugin_textdomain"));

		// Load admin JavaScript.
		add_action("admin_enqueue_scripts", array($this, "enqueue_admin_scripts"));

		//Add the fileds to the user page
		add_action( 'show_user_profile', array($this, "display_plugin_admin_page"));
		add_action( 'edit_user_profile', array($this, "display_plugin_admin_page"));

		// Save the new options to the user db
		add_action( 'personal_options_update', array($this, "save_additional_user_meta"));
		add_action( 'edit_user_profile_update', array($this, "save_additional_user_meta"));


	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn"t been set, set it now.
		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate($network_wide) {
		// TODO: Define activation functionality here
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate($network_wide) {
		// TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters("plugin_locale", get_locale(), $domain);

		load_textdomain($domain, WP_LANG_DIR . "/" . $domain . "/" . $domain . "-" . $locale . ".mo");
		load_plugin_textdomain($domain, false, dirname(plugin_basename(__FILE__)) . "/lang/");
	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {
		wp_enqueue_media();

		$screen = get_current_screen();
		wp_enqueue_script($this->plugin_slug . "-admin-script", plugins_url("js/author-avatar-admin.js", __FILE__), array("jquery"), $this->version);

	}


	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page($user) {
		echo $this->plugin_slug;

		include_once("views/admin.php");

	}

	/**
	 * Save this new field if the user has capabilities
	 *
	 * @since    1.0.1 updated update_usermeta to update_user_meta
	 */
	public function save_additional_user_meta($user) {

	    // only saves if the current user can edit user profiles
	    if ( !current_user_can( 'edit_user', $user ) )
			return false;

		update_user_meta( $user, 'user_meta_image', $_POST['user_meta_image'] );

	}

	/**
	 * NOTE:  Filters are points of execution in which WordPress modifies data
	 *        before saving it or sending it to the browser.
	 *
	 *        WordPress Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *        Filter Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 * @since    1.0.0
	 */
	public function filter_method_name() {
		// TODO: Define your filter hook callback here
	}

}
