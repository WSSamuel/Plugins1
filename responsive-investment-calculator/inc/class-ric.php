<?php
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'RIC' ) ) :

class RIC
{
    static private $version;
    static private $paths;
    static private $names;
    static private $shortcodes;
    
    private function __construct() {}
    private function __clone() {}
        
    static public function init( $version, $paths, $names, $shortcodes )
    {
        // Prevent reinitialization
        if ( self::$version ) {
            return;
        }
        
        self::$version      = $version;
        self::$paths        = $paths;
        self::$names        = $names;
        self::$shortcodes   = $shortcodes;
    }
    
    static private function setSSL()
    {
        if ( is_ssl() )
            self::$paths['url'] = str_replace( 'http://', 'https://', self::$paths['url'] );
    }
    
    // ***** VERSION
    
    static public function version()
    {
        return self::$version;
    }
    
    // ***** PATHS
    
    static public function dir()
    {
        return self::$paths['dir'];
    }
    static public function url()
    {
        return self::$paths['url'];
    }
    static public function plugin_file()
    {
        return self::$paths['plugin_file'];
    }
    
    // ***** NAMES
    
    static public function plugin_name()
    {
        return self::$names['plugin_name'];
    }
    static public function text_domain()
    {
        return self::$names['text_domain'];
    }
    static public function option_name()
    {
        return self::$names['option_name'];
    }
    static public function admin_page()
    {
        return self::$names['option_name'];
    }
    static public function widget_id()
    {
        return self::$names['widget_id'];
    }
    
    // ***** NAMES

    static public function shortcodes()
    {
        return self::$shortcodes;
    }
}   
 
endif;
