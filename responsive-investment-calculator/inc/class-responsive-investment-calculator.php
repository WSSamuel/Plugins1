<?php
/**
 * Initialization class 
 *
 * @package Responsive Investment Calculator
 * @since 1.0.0
 */
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'ResponsiveInvestmentCalculator' ) ) :

class ResponsiveInvestmentCalculator
{
    public function __construct( $version, $paths, $names, $shortcodes )
    {
        $this->set_config( $version, $paths, $names, $shortcodes );
        
        $this->register_activation_hook();
        $this->add_actions();
        $this->add_shortcodes();
    }
    
    
    // ***** CONFIG
    
    /*
     * Set the configuration class. Config options are accessed through static methods.
     */
    private function set_config( $version, $paths, $names, $shortcodes )
    {
        include $paths['dir'] . 'inc/class-ric.php';
        RIC::init( $version, $paths, $names, $shortcodes );
    }
    
    // ***** ACTIVATION
    
    /*
     * Register activation method
     */
    private function register_activation_hook()
    {
        register_activation_hook( RIC::plugin_file(), array( $this, 'activate' ) );
    }
    
    /*
     * Insert default options in the database
     */
    static public function activate()
    {
        $defaults = include RIC::dir() . 'inc/array-default-options.php';
        add_option( RIC::option_name(), $defaults );
    }
    
    // ***** ACTIONS
    
    /*
     * Register actions and set up the admin or front end files
     */
    protected function add_actions()
    {
        // Global
        add_action( 'plugins_loaded', array( $this, 'load_text_domain' ) );
        add_action( 'widgets_init', array( $this, 'widgets_init' ) );
        
        // Admin only
        if ( is_admin() ) {
            include RIC::dir() . 'adm/class-ric-admin.php';
            $admin = new RICAdmin();
        }
        // Front end only
        else {
            
            // Calculator Controller file
            include_once RIC::dir() . 'inc/class-ric-calculator-controller.php';
            $calculator = RICCalculatorController::get_instance();
            
            // Load scripts and styles to the front end
            $calculator->init();
        }
    }
    
    /**
     * Text domain
     */
    public function load_text_domain() {
    	load_plugin_textdomain( RIC::text_domain(), false, RIC::dir() . 'languages' );
    }
    
    /*
     * Include and initialize the widget
     */
    public function widgets_init()
    {
        include_once RIC::dir() . 'inc/class-ric-widget.php';
        register_widget( 'RICWidget' );
    }
    
    // ***** SHORTCODES
    
    /*
     * Register shortcodes
     */
    protected function add_shortcodes()
    {
        $shortcodes = RIC::shortcodes();
        foreach ( $shortcodes as $s ) {
            add_shortcode( $s, array( $this, 'do_shortcode' ) );
        }
    }
    
    static public function do_shortcode( $attributes, $content = '' )
    {
        $calculator = RICCalculatorController::get_instance();
        return $calculator->do_shortcode( $attributes, $content );
    }
    
}   
 
endif;
