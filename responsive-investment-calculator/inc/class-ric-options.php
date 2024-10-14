<?php
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'RICOptions' ) ) :

class RICOptions
{
    static private $instance;
    
    static private $options;
    static private $defaults;
    
    private function __construct() {}
    private function __clone() {}
        
    static public function get_instance()
    {
        if ( ! self::$instance ) {
            self::$instance = new RICOptions();
            self::init();
        }
        
        return self::$instance;
    }
    
    static private function init()
    {
        self::$defaults = include RIC::dir() . 'inc/array-default-options.php';
        self::$options = get_option( RIC::option_name() );
    }
    
    public function get( $key )
    {
        if ( isset( self::$options[$key] ) ) {
            return self::$options[$key];
        }

        if ( isset( self::$defaults[$key] ) ) {
            return self::$defaults[$key];
        }
        
        return null;
    }
    
    public function get_default( $key )
    {
        if ( isset( self::$defaults[$key] ) ) {
            return self::$defaults[$key];
        }
        
        return null;
    }
}   
 
endif;
