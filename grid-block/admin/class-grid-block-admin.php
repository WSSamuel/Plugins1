<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://digitalapps.co
 * @since      1.0.0
 *
 * @package    Grid_Block
 * @subpackage Grid_Block/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Grid_Block
 * @subpackage Grid_Block/admin
 * @author     Digital Apps <support@digitalapps.co>
 */
class Grid_Block_Admin {

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
     * Register custom gutenberg category
     *
     * https://wordpress.org/gutenberg/handbook/extensibility/extending-blocks/#managing-block-categories
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function define_block_category( $categories, $post ) {

        if ( $post->post_type !== 'post' ) {
            return $categories;
        }
        return array_merge(
            $categories,
            array(
                array(
                    'slug'  => 'grid-block',
                    'title' => __( 'Grid Block', 'grid-block' ),
                ),
            )
        );

    }

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    public function localize_script() {

        $default_variant = [];
        $js_deps = array(
            'jquery',
            'wp-editor',
            'wp-blocks',
            'wp-i18n',
            'wp-element',
            'wp-edit-post',
            'wp-compose'
        );

        wp_register_script(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'blocks/index.min.js',
            $js_deps,
            $this->version
        );

        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'blocks/index.min.js',
            $js_deps,
            $this->version,
            false
        );
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Grid_Block_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Grid_Block_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style( $this->plugin_name . '-blocks', plugin_dir_url( __FILE__ ) . 'css/grid-block-admin.css', array(), $this->version, 'all' );

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Grid_Block_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Grid_Block_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

         $js_deps = array(
             'jquery',
             'wp-editor',
             'wp-blocks',
             'wp-i18n',
             'wp-element',
             'wp-edit-post',
             'wp-compose'
         );

         wp_enqueue_script(
             $this->plugin_name,
             plugin_dir_url( __FILE__ ) . 'blocks/index.min.js',
             $js_deps,
             $this->version,
             false
         );

    }
}
