<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://elvez.co.jp
 * @since      1.0.0
 *
 * @package    Elvez_Edit_Powered_By
 * @subpackage Elvez_Edit_Powered_By/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Elvez_Edit_Powered_By
 * @subpackage Elvez_Edit_Powered_By/public
 * @author     Elvez, Inc. <info@elvez.co.jp>
 */
class Elvez_Edit_Powered_By_Public {
	/**
	 * PowerdBy表示有無のパラメータ名
	 */
	const PARAMS_POWERED_BY_IS_SHOW = 'powered_by_is_show';

	/**
	 * PowerdByテキストのパラメータ名
	 */
	const PARAMS_POWERED_BY_TEXT = 'powered_by_text';

	/**
	 * PowerdByリンクURLのパラメータ名
	 */
	const PARAMS_POWERED_BY_URL = 'powered_by_url';

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action( 'init', [$this, 'register_dependencies'] );

	}

	/**
	 * Get registered version of script or style.
	 * 指定キーのスクリプトまたはスタイルが登録されていたらそのバージョン番号を返す
	 * 登録されていない場合は '0' を返す
	 *
	 * @since     1.0.2
	 * @param	$key	string
	 * @param	$type	string	'scripts' | 'styles'
	 * @return	$ver	string	Version string
	 */
	public static function get_registered_version( $key, $type='scripts') {

		$not_registerd_ver = '0';

		if ( $type == 'scripts' ) {
			$dependencies = wp_scripts();
		} else if ( $type == 'styles' ) {
			$dependencies = wp_styles();
		} else {
			return $not_registerd_ver;
		}

		if ( isset( $dependencies->registered[$key] ) ) {
			$registerd = $dependencies->registered[$key];
			return $registerd->ver;
		} else {
			return $not_registerd_ver;
		}

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.2
	 */
	public function register_dependencies() {

		$elvez_style_version = '1.1.7';
		$style_registered_ver = $this->get_registered_version( 'elvez-style', 'styles' );
		if ( version_compare( $elvez_style_version, $style_registered_ver, '>' ) ) {
			wp_styles()->remove( 'elvez-style' );
			wp_register_style( 'elvez-style', plugin_dir_url( __FILE__ ) . 'css/elvez-style.css', array(), $elvez_style_version, 'all' );

		}

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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
		wp_enqueue_style( 'elvez-style' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/elvez-edit-powered-by-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/elvez-edit-powered-by-public.js', array( 'jquery' ), $this->version, false );

		$this->set_params();

	}

	/**
	 * Set params to js object.
	 *
	 * @since    1.0.0
	 */
	public function set_params() {
		$object_name = 'elvez_edit_powered_by';
		$params = Elvez_Edit_Powered_By_Admin::get_options();
		wp_localize_script( $this->plugin_name, $object_name, $params );
	}
}
