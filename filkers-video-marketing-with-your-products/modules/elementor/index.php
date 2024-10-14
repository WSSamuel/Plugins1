<?php

defined( 'ABSPATH' ) || exit;


final class Filkers_Elementor_Extension {


    const VERSION = '1.1.0';
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
    const MINIMUM_PHP_VERSION = '7.0';

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

    public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'on_plugins_loaded' ] );
	}

	public function i18n() {
  		load_plugin_textdomain( 'filkers-wordpress-blocks' );
   	}

	public function on_plugins_loaded() {
        if ( $this->is_compatible() ) {
            add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_assets' ] );
            add_action( 'elementor/init', [ $this, 'init' ] );
        }
    }

    public function is_compatible() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			return false;
		}

		// Check for required Elementor version
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
            return false;
        }
        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
            return false;
        }

		return true;
	}

	public function admin_notice_minimum_elementor_version() {

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.'),
            '<strong>' . esc_html__( 'Filkers Elementor Extension') . '</strong>',
            '<strong>' . esc_html__( 'Elementor') . '</strong>',
             self::MINIMUM_ELEMENTOR_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }

    public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.'),
			'<strong>' . esc_html__( 'Filkers Elementor Extension') . '</strong>',
			'<strong>' . esc_html__( 'PHP' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

    public function init() {


		$this->i18n();
        $this->includes();

        // Register categories
        add_action( 'elementor/elements/categories_registered', [ $this, 'register_categories' ] );

        // Register Widget Styles
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'register_widget_styles' ] );

		// Register Widget scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'register_widget_scripts' ] );

		// Register widgets
  		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );

		// Register controls
  		add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );
	}


	public function register_widget_scripts() {
        wp_register_script('filkers-taglib','https://widgets.filkers.com/js/filkers-taglib.umd.js');
   	}

	public function register_widget_styles() {
        wp_register_style('filkers-widgets', plugins_url( 'src/assets/filkers-widgets.css', __FILE__ ) );
        wp_register_style('filkers-products-grid', plugins_url( 'src/assets/filkers-products-grid.css', __FILE__ ) );
   	}

    public function enqueue_editor_assets() {
        wp_register_style('filkers-icons', plugins_url( 'src/assets/filkers-icons.css', __FILE__ ) );
        wp_enqueue_style('filkers-icons');
    }

    public function includes() {
    	require_once( __DIR__ . '/src/widgets/filkers-folder-player.php' );
    	require_once( __DIR__ . '/src/widgets/filkers-related-products.php' );
    	require_once( __DIR__ . '/src/widgets/filkers-featured-products.php' );
    	require_once( __DIR__ . '/src/widgets/filkers-newest-products.php' );
    	require_once( __DIR__ . '/src/widgets/filkers-onsale-products.php' );
    	require_once( __DIR__ . '/src/controls/filkers-design-uid-control.php' );
	}

    public function register_widgets() {
        $widgets_manager = \Elementor\Plugin::instance()->widgets_manager;
    	$widgets_manager->register_widget_type( new Filkers_Folder_Player_Widget() );
   		$widgets_manager->register_widget_type( new Filkers_Related_Products_Widget() );
   		$widgets_manager->register_widget_type( new Filkers_Featured_Products_Widget() );
   		$widgets_manager->register_widget_type( new Filkers_Newest_Products_Widget() );
   		$widgets_manager->register_widget_type( new Filkers_OnSale_Products_Widget() );
	}

    public function register_controls() {
        $controls_manager = \Elementor\Plugin::$instance->controls_manager;
        $controls_manager->register_control( Filkers_Design_Uid_Control::TYPE, new Filkers_Design_Uid_Control() );

	}

	public function register_categories($elements_manager) {
	    $elements_manager->add_category(
    		'filkers',
    		[
    			'title' => __( 'Filkers'),
    			'icon' => 'fa fa-plug',
    		]
    	);
	}
}

Filkers_Elementor_Extension::instance();

