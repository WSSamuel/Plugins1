<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://elvez.co.jp
 * @since      1.0.0
 *
 * @package    Elvez_Edit_Powered_By
 * @subpackage Elvez_Edit_Powered_By/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Elvez_Edit_Powered_By
 * @subpackage Elvez_Edit_Powered_By/admin
 * @author     Elvez, Inc. <info@elvez.co.jp>
 */
class Elvez_Edit_Powered_By_Admin {
	/**
	 * 翻訳ファイルのドメイン
	 */
	const TEXT_DOMAIN = 'elvez-edit-powered-by';

	/**
	 * トップレベルメニューのスラグ
	 * @since 1.0.1
	 */
	const ELVEZ_TOP_LEVEL_ADMIN_MENU = 'elvez_admin';

	/**
	 * 設定メニューの権限
	 */
	const CAPABILITY = 'manage_options';

	/**
	 * 設定ページのURLスラグ
	 */
	const MENU_SLUG = 'elvez-edit-powered-by';

	/**
	 * 設定メニューのアイコン
	 * https://developer.wordpress.org/resource/dashicons/
	 */
	const ICON_URL = 'dashicons-edit-large';

	/**
	 * 設定メニューの表示位置
	 */
	const POSITION = 99;

	/**
	 * オプションのグループ名
	 */
	const OPTION_GROUP = 'elvez-edit-powered-by';

	/**
	 * オプションフィールド名のプレフィックス
	 */
	const OPTION_PREFIX = 'elvez_edit_powered_by_';

	/**
	 * PowerdByテキストのフィールド名
	 */
	const OPTION_POWERED_BY_TEXT = self::OPTION_PREFIX . Elvez_Edit_Powered_By::PARAMS_POWERED_BY_TEXT;

	/**
	 * PowerdByリンクURLのフィールド名
	 */
	const OPTION_POWERED_BY_URL = self::OPTION_PREFIX . Elvez_Edit_Powered_By::PARAMS_POWERED_BY_URL;

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
	 * Get options array.
	 *
	 * @since    1.0.0
	 */
	public static function get_options() {
		$options = array(
                        Elvez_Edit_Powered_By::PARAMS_POWERED_BY_TEXT => get_option(self::OPTION_POWERED_BY_TEXT),
                        Elvez_Edit_Powered_By::PARAMS_POWERED_BY_URL => get_option(self::OPTION_POWERED_BY_URL)
                );
		return $options;
	}

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

		add_action('admin_init', [$this, 'register_settings']);
		add_action('admin_menu', [$this, 'set_menu_page']);

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Elvez_Edit_Powered_By_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Elvez_Edit_Powered_By_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/elvez-edit-powered-by-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Elvez_Edit_Powered_By_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Elvez_Edit_Powered_By_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/elvez-edit-powered-by-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register setting fields.
	 *
	 * @since    1.0.0
	 */
	public function register_settings() {
		add_option(self::OPTION_POWERED_BY_TEXT, '');
		add_option(self::OPTION_POWERED_BY_URL, '');

		register_setting( self::OPTION_GROUP, self::OPTION_POWERED_BY_TEXT);
		register_setting( self::OPTION_GROUP, self::OPTION_POWERED_BY_URL);
	}

	/**
	 * Register top-level menu.
	 *
	 * @since    1.0.1
	 */
	public function register_top_level_menu() {
		global $menu;
		if ( !isset($menu[self::ELVEZ_TOP_LEVEL_ADMIN_MENU]) ) {
			// FIXME: Use icon image.
			// $icon = plugin_dir_url( __FILE__ ) . 'img/menu_icon.svg';

			add_menu_page(
				__( 'Elvez', self::TEXT_DOMAIN ),  // Page title
				__( 'Elvez', self::TEXT_DOMAIN ),  // Menu title
				self::CAPABILITY,
				self::ELVEZ_TOP_LEVEL_ADMIN_MENU,
				[$this, 'render_menu_page'], // Display first submenu page
				self::ICON_URL,
				self::POSITION
			);
		}
	}
	/**
	 * Set menu page.
	 *
	 * @since   1.0.0
	 * @since	1.0.1	Add menu as submenu
	 */
	public function set_menu_page() {
		$this->register_top_level_menu();

		add_submenu_page(
			self::ELVEZ_TOP_LEVEL_ADMIN_MENU,
			__( 'Edit Powerd-by', self::TEXT_DOMAIN ),  // Page title
			__( 'Edit Powerd-by', self::TEXT_DOMAIN ),  // Menu title
			self::CAPABILITY,
			self::MENU_SLUG,
			[$this, 'render_menu_page'],  // Callback functions to render menu page
		);
		remove_submenu_page(self::ELVEZ_TOP_LEVEL_ADMIN_MENU, self::ELVEZ_TOP_LEVEL_ADMIN_MENU);
	}

	/**
	 * Re render menu page html.
	 *
	 * @since    1.0.0
	 */
	public function render_menu_page() {
        	?>
		<div class="wrap">
    			<h1 class=""><?php esc_html_e( 'Settings for Elvez Edit Powered By' , self::TEXT_DOMAIN ); ?></h1>

    			<form method="post" action="options.php">
		        	<?php settings_fields(self::OPTION_GROUP); ?>
        			<?php do_settings_sections(self::OPTION_GROUP); ?>

				<table class="form-table">
        				<tr valign="top">
        					<th scope="row"><?php esc_html_e( 'Powered By Text', self::TEXT_DOMAIN ); ?></th>
        					<td><input type="text"
							name="<?php echo esc_attr( self::OPTION_POWERED_BY_TEXT ); ?>"
							value="<?php echo esc_attr( get_option(self::OPTION_POWERED_BY_TEXT) ); ?>" /></td>
        				</tr>
        
     					<tr valign="top">
        					<th scope="row"><?php esc_html_e( 'Powered By URL', self::TEXT_DOMAIN ); ?></th>
        					<td><input type="text"
							name="<?php echo esc_attr( self::OPTION_POWERED_BY_URL ); ?>"
							value="<?php echo esc_attr( get_option(self::OPTION_POWERED_BY_URL) ); ?>" /></td>
        				</tr>
    				</table>

        			<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}

}
