<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.moradam.com
 * @since      1.0.0
 *
 * @package    Moradam_Seo
 * @subpackage Moradam_Seo/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Moradam_Seo
 * @subpackage Moradam_Seo/admin
 * @author     Moradam SEO <company@moradam.com>
 */
class Moradam_Seo_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */


    private $response;

    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Moradam_Seo_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Moradam_Seo_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/moradam-seo-admin.css', array(), $this->version, 'all');

        wp_enqueue_style('moradam-seo-fontawesome', 'https://use.fontawesome.com/releases/v5.7.1/css/all.css', array(), $this->version, false);

        wp_enqueue_style('moradam-seo-daterangepicker', plugin_dir_url(__FILE__) . 'css/libs/daterangepicker.css', array(), $this->version, false);

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Moradam_Seo_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Moradam_Seo_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script('moradam-seo-date-fns', plugin_dir_url(__FILE__) . 'js/libs/date-fns.js', array('jquery'), $this->version, false);

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/moradam-seo-admin.js', array('jquery'), $this->version, false);

        wp_enqueue_script('moradam-seo-chart-js', plugin_dir_url(__FILE__) . 'js/libs/chart.min.js', array('moment') );

        wp_enqueue_script('moradam-seo-daterangepicker', plugin_dir_url(__FILE__) . 'js/libs/daterangepicker.min.js', array('jquery'), $this->version, false);

        if (isset($_GET['page']) && ($_GET['page'] == 'moradam-seo')) {
            wp_enqueue_script('moradam-seo-ajax-kw', plugin_dir_url(__FILE__) . 'js/moradam-seo-ajax-kw-on-top.js', array('jquery'), $this->version, false);
            wp_localize_script('moradam-seo-ajax-kw', 'moradam_ajax_kw_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'offset'=> 40) );
        }

        if (isset($_GET['page']) && ($_GET['page'] == 'competitors')) {
            wp_enqueue_script('moradam-seo-competitors', plugin_dir_url(__FILE__) . 'js/moradam-seo-competitors.js', array('jquery'), $this->version, false);
            wp_localize_script('moradam-seo-competitors', 'moradam_competitors_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'offset'=> 40) );
        }

        if (isset($_GET['page']) && ($_GET['page'] == 'best-pages')) {
            wp_enqueue_script('moradam-seo-best-pages', plugin_dir_url(__FILE__) . 'js/moradam-seo-best-pages.js', array('jquery'), $this->version, false);
            wp_localize_script('moradam-seo-best-pages', 'moradam_best_pages_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'offset'=> 40) );
        }

        wp_enqueue_script('moradam-seo-main-js', plugin_dir_url(__FILE__) . 'js/moradam-seo-main.js', array('jquery'), $this->version, false);
    }

    public function moradam_setup_menu()
    {
        add_menu_page('Moradam SEO', 'Moradam SEO', 'manage_options', 'moradam-seo', array($this, 'keywords_on_top_page'), plugin_dir_url(__FILE__) . 'img/favicon-moradam.ico', "25.22");
    }
    // Menüler
    public function moradam_setup_submenu()
    {
        add_submenu_page('moradam-seo', 'Keywords on TOP - Moradam SEO', 'En İyi Anahtar Kelimeler', 'manage_options', 'moradam-seo', array($this, 'keywords_on_top_page'));
        add_submenu_page('moradam-seo', 'Best Pages - Moradam SEO', 'En İyi Sayfalar', 'manage_options', 'best-pages', array($this, 'best_pages_page'));
        add_submenu_page('moradam-seo', 'Competitors - Moradam SEO', 'Rakipler', 'manage_options', 'competitors', array($this, 'competitors_page'));
    }

    public function keywords_on_top_page()
    {
        if (!current_user_can('manage_options'))
        {
            wp_die( __('You do not have sufficient permissions to access this page.') );
        }
        require_once plugin_dir_path( __FILE__ ) . 'pages/moradam-seo-keywords-on-top.php';
    }

    public function best_pages_page()
    {
        if (!current_user_can('manage_options'))
        {
            wp_die( __('You do not have sufficient permissions to access this page.') );
        }
        require_once plugin_dir_path( __FILE__ ) . 'pages/moradam-seo-best-pages.php';
    }

    public function competitors_page()
    {
        if (!current_user_can('manage_options'))
        {
            wp_die( __('You do not have sufficient permissions to access this page.') );
        }
        require_once plugin_dir_path( __FILE__ ) . 'pages/moradam-seo-competitors.php';
    }
}
