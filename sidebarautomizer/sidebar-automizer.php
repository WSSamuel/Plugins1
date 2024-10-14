<?php     
	/*
	Plugin Name: Sidebar Automizer 
	Plugin URI: http://wordpress.transformnews.com/plugins/sidebarautomizer-equalize-content-and-sidebar-heights-664
	Description: This little plugin will remove last widget or widgets from sidebar if content area height is smaller than sidebar area height.
	Version: 1.0
	Author: m.r.d.a
	Text domain: sidebar-automizer
	Domain Path: /languages
	License: GPLv2 or later
	*/

// Block direct acess to the file
defined('ABSPATH') or die("Cannot access pages directly.");

// Add plugin admin settings by Otto
class SidebarAutomizerMenuPage
{
/**
* Holds the values to be used in the fields callbacks
*/
    private $options;

/**
* Start up
*/
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'sidebar_automizer_load_transl') );
        add_action( 'admin_init', array( $this, 'page_init' ) );
		add_action( 'admin_init', array( $this, 'sidebar_automizer_default_options' ) );
    }
	
	public function sidebar_automizer_load_transl()
    {
        load_plugin_textdomain('sidebar-automizer', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
    }
	
/**
* Add options page
*/
    public function add_plugin_page()
    {
        // This page will be under "Settings"
		
        add_options_page(
            'Settings Admin', 
            'sidebarAutomizer', 
            'manage_options', 
            'sidebar-automizer-settings', 
            array( $this, 'create_admin_page' )
        );
    }

/**
* Options page callback
*/
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'sidebarautomizer_option_name');
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2><?php _e('sidebarAutomizer Settings', 'sidebar-automizer'); ?></h2>       
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'sidebar_automizer_option_group' );   
                do_settings_sections( 'sidebar-automizer-settings' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }
	
/**
* Register and add settings
*/
    public function page_init()
    {   
		global $id, $title, $callback, $page;     
        register_setting(
            'sidebar_automizer_option_group', // Option group
            'sidebarautomizer_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );
		
		add_settings_field( $id, $title, $callback, $page, $section = 'default', $args = array() );

        add_settings_section(
            'setting_section_id', // ID
			 __("sidebarAutomizer Options", 'sidebar-automizer'), // Title
            array( $this, 'print_section_info' ), // Callback
            'sidebar-automizer-settings' // Page
        );
        add_settings_field(
            'sidebar_automizer_class_selector', // ID
			__("Content Class or ID", 'sidebar-automizer'), // Title 
            array( $this, 'sidebar_automizer_class_selector_callback' ), // Callback
            'sidebar-automizer-settings', // Page
            'setting_section_id' // Section         
        );
        add_settings_field(
            'sidebar_automizer_class_selector2', 
			__("Sidebar Class or ID", 'sidebar-automizer'),
            array( $this, 'sidebar_automizer_class_selector2_callback' ), 
            'sidebar-automizer-settings', 
            'setting_section_id'
        );
		add_settings_field(
            'sidebar_automizer_add_extra', 
			__("Add extra height to Sidebar", 'sidebar-automizer'),
            array( $this, 'sidebar_automizer_add_extra_callback' ), 
            'sidebar-automizer-settings', 
            'setting_section_id'
        );
		add_settings_field(
            'sidebar_automizer_element', 
			__("Define Element to remove", 'sidebar-automizer'),
            array( $this, 'sidebar_automizer_element_callback' ), 
            'sidebar-automizer-settings', 
            'setting_section_id'
        );
    }
	
/**
* Sanitize each setting field as needed
*
* @param array $input Contains all settings fields as array keys
*/
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['sidebar_automizer_class_selector'] ) )
            $new_input['sidebar_automizer_class_selector'] = sanitize_text_field( $input['sidebar_automizer_class_selector'] );

        if( isset( $input['sidebar_automizer_class_selector2'] ) )
            $new_input['sidebar_automizer_class_selector2'] = sanitize_text_field( $input['sidebar_automizer_class_selector2'] );
			
		if( isset( $input['sidebar_automizer_add_extra'] ) )
            $new_input['sidebar_automizer_add_extra'] = sanitize_text_field( $input['sidebar_automizer_add_extra'] );
		
		if( isset( $input['sidebar_automizer_element'] ) )
            $new_input['sidebar_automizer_element'] = sanitize_text_field( $input['sidebar_automizer_element'] );
				 
        return $new_input;
    }
	
/**
* Load Defaults
*/ 	
	public function sidebar_automizer_default_options() {
		
		global $options;
		
		
		$default = array(

				'sidebar_automizer_class_selector' => '.site-main .content-area',
				'sidebar_automizer_class_selector2' => '.site-main .widget-area',
				'sidebar_automizer_add_extra' => '300',
				'sidebar_automizer_element' => 'aside'
				
			);

		if ( get_option('sidebarautomizer_option_name') == false ) {	
			update_option( 'sidebarautomizer_option_name', $default );		
		}

}
	
/** 
* Print the Section text
*/
	public function print_section_info()
	{
		echo __("This little plugin will remove last widget or widgets from sidebar if content area height is smaller than sidebar area height (while sidebar height > content height + extra height => remove last widget). Defaults works in Twentythirteen theme, for other themes you will need to define content and sidebar class or id and define element to remove if different.", 'sidebar-automizer');
    }
	
/** 
* Get the settings option array and print one of its values
*/
	public function sidebar_automizer_class_selector_callback()
	{
		printf(
			'<p class="description"><input type="text" size="20" id="sidebar_automizer_class_selector" name="sidebarautomizer_option_name[sidebar_automizer_class_selector]" value="%s" /> ',  
			isset( $this->options['sidebar_automizer_class_selector'] ) ? esc_attr( $this->options['sidebar_automizer_class_selector']) : '' 
		);
		 echo __("This must be content Class or ID (it will define max height for your sidebar area).", 'sidebar-automizer');
		 echo '</p>';
	}
	
	public function sidebar_automizer_class_selector2_callback()
	{
		printf(
			'<p class="description"><input type="text" size="20" id="sidebar_automizer_class_selector2" name="sidebarautomizer_option_name[sidebar_automizer_class_selector2]" value="%s" />',
			isset( $this->options['sidebar_automizer_class_selector2'] ) ? esc_attr( $this->options['sidebar_automizer_class_selector2']) : ''
		);
		 echo __("Class or ID of the sidebar element that contains widgets.", 'sidebar-automizer');
		 echo '</p>';
	}

	public function sidebar_automizer_add_extra_callback()
	{
		printf(
			'<p class="description"><input type="text" size="5" id="sidebar_automizer_add_extra" name="sidebarautomizer_option_name[sidebar_automizer_add_extra]" value="%s" />' ,
			isset( $this->options['sidebar_automizer_add_extra'] ) ? esc_attr( $this->options['sidebar_automizer_add_extra']) : ''
        );
		echo __("px. In some cases you want your sidebar a bit higher than content. if that's the case add number of pixels here.", 'sidebar-automizer');
		echo '</p>';
    }
	
	public function sidebar_automizer_element_callback()
	{
		printf(
			'<p class="description"><input type="text" size="10" id="sidebar_automizer_element" name="sidebarautomizer_option_name[sidebar_automizer_element]" value="%s" /> ' ,
			isset( $this->options['sidebar_automizer_element'] ) ? esc_attr( $this->options['sidebar_automizer_element']) : ''
        );
		echo __("It can be aside, div, or whatever element that your theme uses to display single widget. Wrong setting can cause unresponsive script behaviour in frontend.", 'sidebar-automizer');
		echo '</p>';
    }
	
}

	if( is_admin() )
    $sidebarautomizer_settings_page = new SidebarAutomizerMenuPage();

// end plugin admin settings

	function sidebarautomizer_script() {
		
		$sidebar_automizer_options = get_option( 'sidebarautomizer_option_name' );
		
		// Register scripts
			wp_register_script('sidebarautomizer', WP_PLUGIN_URL. '/sidebarautomizer/js/sidebar-automizer.js', false,'1.0.0', true);
			wp_enqueue_script( 'sidebarautomizer' );
			wp_enqueue_script( 'jquery' );

		// Localize sidebar-automizer.js script with sidebarAutomizer options
		$mysticky_translation_array = array( 
		    'sidebar_automizer_class_selector_string' => $sidebar_automizer_options['sidebar_automizer_class_selector'] ,
			'sidebar_automizer_class_selector2_string' => $sidebar_automizer_options['sidebar_automizer_class_selector2'],
			'sidebar_automizer_add_extra_string' => $sidebar_automizer_options['sidebar_automizer_add_extra'],
			'sidebar_automizer_element_string' => $sidebar_automizer_options['sidebar_automizer_element']
		);
		
			wp_localize_script( 'sidebarautomizer', 'sidebarautomizer_name', $mysticky_translation_array );
	}

	add_action( 'wp_enqueue_scripts', 'sidebarautomizer_script' );
?>