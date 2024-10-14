<?php
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'RICCalculatorController' ) ) :

class RICCalculatorController
{
    static private $instance;
    
    private function __construct() {}
    private function __clone() {}
        
    static public function get_instance()
    {
        if ( ! self::$instance ) {
            self::$instance = new RICCalculatorController;
            
            self::include_files();
        }
        
        return self::$instance;
    }
    
    static private function include_files()
    {
        include RIC::dir() . 'inc/class-ric-options.php';
        include RIC::dir() . 'inc/class-ric-form.php';
    }
    
    public function init()
    {
        add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts_and_styles' ) );
    }
    
    public function register_scripts_and_styles()
    {
        // Register script
        wp_register_script( RIC::text_domain(), RIC::url() . 'js/responsive-investment-calculator.js', 'jquery', RIC::version(), true );
        
        // Register style
        wp_register_style( RIC::text_domain(), RIC::url() . 'css/responsive-investment-calculator.css', '', RIC::version() );
        
        // Detect the plugin
        if ( $this->plugin_detected() ) {
            $this->load_scripts();
            $this->load_styles();
        }
    }
    
    private function plugin_detected()
    {
        // Look for widget
        if ( is_active_widget( false, false, RIC::widget_id(), true ) ) {
            return true;
        }
        
        // Look for shortcode
        GLOBAL $post;
        $detected = false;
        $shortcodes = RIC::shortcodes();
        foreach ( $shortcodes as $shortcode ) {
            $pattern = '/\[' . $shortcode . '.*?\]/i';
            if ( preg_match( $pattern, $post->post_content ) ) return true;
        }
        
        return false;
    }
    
    private function load_scripts()
    {
        wp_enqueue_script( RIC::text_domain() );
        
        // Localization
        include RIC::dir() . 'inc/function-ric-get-localization.php';
        $localization = ric_get_localization();
        wp_localize_script( RIC::text_domain(), 'lidd_ric_script_vars', $localization );
    }
    
    private function load_styles()
    {
        $options = RICOptions::get_instance();
        if ( $options->get( 'css' ) ) {
            wp_enqueue_style( RIC::text_domain() );
            
            if ( $options->get( 'css_select_adjust') ) {
                $css = ".ric_select:after {
                    top: " . $options->get( 'css_select_adjust' ) . ";
                }";
                
                wp_add_inline_style( RIC::text_domain(), $css );
            }
        }
    }
    
    public function do_shortcode()
    {
        $form = new RICForm();
        return $form->get_form();
    }
    
}   
 
endif;
