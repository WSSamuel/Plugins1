<?php
    
    namespace PTI\admin;
    
    use PTI\ptx\ptxImiginoVideoFields;
    use PTI\ptx\ptxImiginoVideoGlobal;
    
    if (!defined('ABSPATH')) {
        exit();
    }
    
    /**
     * The admin-specific functionality of the plugin.
     *
     * Defines the plugin name, version, and two examples hooks for how to
     * enqueue the admin-specific stylesheet and JavaScript.
     *
     * @package    PublishersToolboxImiginoVideo
     * @subpackage PublishersToolboxImiginoVideo/admin
     * @author     Johan Pretorius <johan.pretorius@afrozaar.com>
     */
    class ptxImiginoVideoAdmin {
        
        /**
         * The ID of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string $pluginName The ID of this plugin.
         */
        private $pluginName;
        
        /**
         * The version of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string $pluginVersion The current version of this plugin.
         */
        private $pluginVersion;
        
        /**
         * Initialize the class and set its properties.
         *
         * @param string $pluginName The name of this plugin.
         * @param string $pluginVersion The version of this plugin.
         *
         * @since    1.0.0
         */
        public function __construct($pluginName, $pluginVersion) {
            $this->pluginName    = $pluginName;
            $this->pluginVersion = $pluginVersion;
        }
        
        /**
         * Register the stylesheets for the admin area.
         *
         * @since    1.0.0
         */
        public function enqueueStyles() {
            wp_enqueue_style($this->pluginName, plugin_dir_url(__FILE__) . 'css/ptx-admin-style.min.css', [], $this->pluginVersion, 'all');
            wp_enqueue_style($this->pluginName . '-iziToast', plugin_dir_url(__FILE__) . 'assets/lib/iziToast.min.css', [], $this->pluginVersion, 'all');
            wp_enqueue_style($this->pluginName . '-minicolors', plugin_dir_url(__FILE__) . 'assets/lib/minicolors.min.css', [], $this->pluginVersion, 'all');
            wp_enqueue_style($this->pluginName . '-tooltip', plugin_dir_url(__FILE__) . 'assets/lib/tooltip.min.css', [], $this->pluginVersion, 'all');
        }
        
        /**
         * Register the JavaScript for the admin area.
         *
         * @since    1.0.0
         */
        public function enqueueScripts() {
            
            /**
             * Use media element.
             */
            wp_enqueue_media();
            
            /**
             * Libraries
             */
            wp_enqueue_script($this->pluginName . '-iziToast', plugins_url('assets/lib/iziToast.min.js', __FILE__), [], $this->pluginVersion, true);
            wp_enqueue_script($this->pluginName . '-dialog', plugins_url('assets/lib/dialog.min.js', __FILE__), [], $this->pluginVersion, true);
            wp_enqueue_script($this->pluginName . '-minicolors', plugins_url('assets/lib/minicolors.min.js', __FILE__), [], $this->pluginVersion, true);
            wp_enqueue_script($this->pluginName . '-tooltip', plugins_url('assets/lib/tooltip.min.js', __FILE__), [], $this->pluginVersion, true);
            
            wp_enqueue_script($this->pluginName, plugin_dir_url(__FILE__) . 'js/ptx-admin-script.min.js', [
                'jquery',
                'jquery-ui-slider',
                'wp-plugins',
                'wp-edit-post',
                'wp-element',
                'wp-components',
            ], $this->pluginVersion, false);
            
            /**
             * Ajax Libraries
             */
            wp_localize_script($this->pluginName, 'ptxOptionsObject', [
                'ajax_url' => admin_url('admin-ajax.php'),
                '_nonce'   => wp_create_nonce($this->pluginName),
            ]);
        }
        
        /**
         * Register the administration menu for this
         * plugin into the WordPress Dashboard menu.
         *
         * @since 1.0.0
         */
        public function ptxAddImiginoVideoAdminMenu() {
            /**
             * Add a settings page for this plugin to the Settings menu.
             *
             * Alternative menu locations are available via WordPress administration menu functions.
             *
             * Administration Menus: http://codex.wordpress.org/Administration_Menus
             */
            add_menu_page(__('Imigino Video Connect', $this->pluginName), __('Imigino Video Connect', $this->pluginName), 'manage_options', $this->pluginName, [
                $this,
                'ptxDisplayPluginSetupPage',
            ], plugin_dir_url(__FILE__) . 'assets/img/menu-icon.png');
        }
        
        /**
         * Add settings action link to the plugins page.
         *
         * Documentation :
         * https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
         *
         * @param $links
         *
         * @return array
         *
         * @since 1.0.0
         */
        public function ptxAddActionLinks($links) {
            $settingsLink[] = (new ptxImiginoVideoGlobal($this->pluginName, $this->pluginVersion))->getSettingsLink();
            
            return array_merge($settingsLink, $links);
        }
        
        /**
         * Render the settings page for this plugin.
         *
         * @since 1.0.0
         */
        public function ptxDisplayPluginSetupPage() {
            /**
             * Get setup options.
             */
            $ptxOptions = (new ptxImiginoVideoGlobal($this->pluginName, $this->pluginVersion))->getPluginOptions();
            
            /**
             * Load the fields object.
             */
            $ptxFields = new ptxImiginoVideoFields($this->pluginName, $this->pluginVersion);
            
            /**
             * Include the admin page
             */
            include_once 'partials/ptx-admin-display.php';
        }
        
        /**
         * Saves the settings for the plugin.
         *
         * @throws \JsonException
         * @since 1.0.0
         */
        public function ptxAjaxAdmin() {
            /**
             * Do security check first.
             */
            if (wp_verify_nonce($_REQUEST['security'], $this->pluginName) === false) {
                wp_send_json_error();
                wp_die('Invalid Request!');
            }
            
            /**
             * Parse the ajax string with data.
             */
            parse_str($_REQUEST['data']['content'], $outputOptions);
            
            switch ($_REQUEST['data']['action']) {
                case 'save':
                    if ($this->ptxUpdatePluginOptions($outputOptions)) {
                        /**
                         * Get previously saved data.
                         */
                        $themeOptions = (new ptxImiginoVideoGlobal($this->pluginName, $this->pluginVersion))->getPluginOptions();
                        
                        /**
                         * Set the changed option to true.
                         *
                         * If this is true, you can perform once off tasks
                         * like flushing rewrite rules.
                         */
                        update_option($this->pluginName . '-changed', ['changed' => true]);
                        
                        /**
                         * Return json response
                         */
                        wp_send_json_success(['active' => array_key_exists('active', $outputOptions)]);
                    } else {
                        wp_send_json_error();
                    }
                    break;
                case 'check':
                    $postOptions = (new ptxImiginoVideoGlobal($this->pluginName, $this->pluginVersion))->ptxTestUrl($outputOptions);
                    if ($postOptions == '200') {
                        wp_send_json_success($postOptions);
                    } else {
                        if (!empty($postOptions['request'])) {
                            wp_send_json_error('Check Base URL: ' . $postOptions['request']);
                        }
                        if (!empty($postOptions['code'])) {
                            wp_send_json_error('Check CID: ' . $postOptions['code'] . ' - ' . $postOptions['message']);
                        }
                    }
                    break;
                default:
                    wp_send_json_error();
                    wp_die();
            }
            
            wp_die();
        }
        
        /**
         * Update the options.
         *
         * @param $inputOption array
         *
         * @return bool
         *
         * @since 1.0.0
         */
        private function ptxUpdatePluginOptions($inputOption = []) {
            return update_option($this->pluginName, $inputOption);
        }
    }
