<?php
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'RICAdmin' ) ) :

class RICAdmin
{
    /**
     * Settings object
     */
    private $settings;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->add_actions();
    }

    // ***** ACTIONS
    
    /*
     * Initialize the plugin menu and register settings
     */
    protected function add_actions()
    {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        add_action( 'admin_init', array( $this, 'admin_init' ) );
    }
    
    /*
     * Add the menu item and set callbacks to add scripts and display the page
     */
    public function admin_menu()
    {
        $page_title     = RIC::plugin_name();
        $menu_title     = 'Resp Investment Calculator';
        $capability     = 'manage_options';
        $menu_slug      = RIC::option_name();
        $callback       = 'display_page';
        
        $page = add_options_page( $page_title, $menu_title, $capability, $menu_slug, array( $this, $callback ) );
        
        add_action( 'load-' . $page, array( $this, 'set_inputs' ) );
    }
    
    /*
     * Initialize the admin page
     */
    public function admin_init()
    {
        // Register settings
        include RIC::dir() . 'adm/class-ric-admin-settings.php';
        $this->settings = new RICAdminSettings();
    }
    
    public function set_inputs()
    {
        $this->settings->set_inputs();
    }
    
    /*
     * Display the page
     */
    public function display_page()
    {
        include RIC::dir() . 'adm/partial-settings-page.php';
    }
}   
 
endif;
