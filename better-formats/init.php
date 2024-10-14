<?php
/*
Plugin Name: Better Formats
Plugin URI: http://plugins.mattvanandel.com/betterformats
Description: Improves the UI for WordPress's built-in post formats.
Version: 0.2
Author: Matt Van Andel
Author URI: http://mattvanandel.com/
License: GPLv2 or later
*/

//Initialize the plugin
NV_Better_Formats::init();

class NV_Better_Formats {

    public static function init() {
        // Enable improved post format feature (hook used is hacky, but don't think there's a better hook)
        add_action('dbx_post_sidebar' , array('NV_Better_Formats', 'require_meta_box') );

        // Enqueues scripts for the admin
        add_action('admin_enqueue_scripts' , array('NV_Better_Formats', 'enqueue_assets') );

        // Register settings sections
        add_action( 'admin_init' , array('NV_Better_Formats', 'settings') );

        // i18n
        add_action('plugins_loaded', array('NV_Better_Formats', 'languages') );

    }

    /**
     * Load i18n files, if available.
     */
    public static function languages() {
        $langs = sprintf( '%s/languages/', dirname( plugin_basename(__FILE__) ) );
        load_plugin_textdomain( 'betterformats', false, $langs );
    }

    /**
     * This loads the override code for WordPress's default format meta box.
     * Note that this is NOT a traditional meta box declaration, but injects
     * new code which is manipulated by JavaScript.
     *
     * @see add_action('dbx_post_sidebar', ... );
     */
    public static function require_meta_box() {
        require 'templates/meta-box.php';
    }

    /**
     * Allows for scripts and styles to be enqueued
     */
    public static function enqueue_assets() {
        wp_enqueue_script('nv-bf-admin', plugin_dir_url(__FILE__) . 'assets/admin.min.js', array('jquery'), false, false);
        wp_enqueue_style('nv-bf-admin', plugin_dir_url(__FILE__) . 'assets/admin.css');
    }

    /**
     * Register a new section for BF
     */
    public static function settings() {

        // Register the setting
        register_setting(
            'writing',          // The default writing group
            'bf-hide-verbose',  // The setting id
            array('NV_Better_Formats', 'setting_hide_verbose_validate')
        );

        // Add settings section to the writing settings page
//        add_settings_section(
//            'bf-settings',                      // Section id
//            __('Post Formats','betterformats'), // Title
//            array('NV_Better_Formats', 'settings_section_text'), // Callback
//            'writing'                           // Slug of settings page
//        );

        // Add the setting field
        add_settings_field(
            'bf-hide-verbose',                  // Setting id
            __('Post Formats','betterformats'), // Visible title
            array('NV_Better_Formats', 'setting_hide_verbose'), // Callback to echo input
            'writing',                          // Show on writing page
            'default'                           // Which section do we add this to?
        );
    }

    /**
     * Render the form field.
     */
    public static function setting_hide_verbose() {
        echo sprintf(
            '<label for="bf-hide-verbose"><input type="checkbox" name="bf-hide-verbose" id="bf-hide-verbose"  %s /> %s</label>',
            checked(true, get_option('bf-hide-verbose'), false),
            __('Hide descriptions in the Post Format box','betterformats')
        );
    }

    /**
     * Validate input of the 'bf-hide-verbose' setting.
     */
    public static function setting_hide_verbose_validate( $input = 0 ) {
        if ( ! empty( $input ) ) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Allows help text to be added to admin
     *
     * @see add_action('admin_head', ... )
     * @global WP_Screen $current_screen Information about the current admin screen
     */
    public static function help() {
        global $wp_meta_boxes;
        $current_screen = get_current_screen();

        //Add new help text
        switch ( $current_screen->id ) {

            default: break;

        }
    }

}