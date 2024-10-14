<?php

    namespace PTI\frontend;

    if (!defined('ABSPATH')) {
        exit();
    }

    /**
     * The public-facing functionality of the plugin.
     *
     * Defines the plugin name, version, and two examples hooks for how to
     * enqueue the public-facing stylesheet and JavaScript.
     *
     *
     * @package    PublishersToolboxPlugin
     * @subpackage PublishersToolboxPlugin/frontend
     * @author     Johan Pretorius <johan.pretorius@afrozaar.com>
     */
    class ptxImiginoVideoFrontend {

        /**
         * The ID of this plugin.
         *
         * @since 1.0.0
         * @access private
         * @var string $pluginName The ID of this plugin.
         */
        private $pluginName;

        /**
         * The version of this plugin.
         *
         * @since 1.0.0
         * @access private
         * @var string $pluginVersion The current version of this plugin.
         */
        private $pluginVersion;

        /**
         * Initialize the class and set its properties.
         *
         * @param string $pluginName The name of the plugin.
         * @param string $pluginVersion The version of this plugin.
         *
         * @since 1.0.0
         */
        public function __construct(string $pluginName, string $pluginVersion) {
            $this->pluginName    = $pluginName;
            $this->pluginVersion = $pluginVersion;
        }

        /**
         * Only include scripts if the shortcode exists.
         */
        public function doShortCodeCheck(): void {
            global $post;
            if (has_shortcode($post->post_content, 'imigino_carousel')) {
                add_action('wp_enqueue_scripts', [$this, 'enqueueStyles'], 10);
                add_action('wp_enqueue_scripts', [$this, 'enqueueScripts'], 10);
            }
        }

        /**
         * Include scripts if a widget was used.
         */
        public function doWidgetShortcode(): void {
            if (is_active_widget('', '', 'text')) {
                add_action('wp_enqueue_scripts', [$this, 'enqueueStyles'], 10);
                add_action('wp_enqueue_scripts', [$this, 'enqueueScripts'], 10);
            }
        }

        /**
         * Register the stylesheets for the public-facing side of the site.
         *
         * @since 1.0.0
         */
        public function enqueueStyles(): void {
            wp_enqueue_style($this->pluginName, plugin_dir_url(__FILE__) . 'css/ptx-frontend-style.min.css', [], $this->pluginVersion, 'all');
            wp_enqueue_style($this->pluginName . '-slick', plugin_dir_url(__FILE__) . 'assets/lib/slick.min.css', [], $this->pluginVersion, 'all');
        }

        /**
         * Register the JavaScript for the public-facing side of the site.
         *
         * @since 1.0.0
         */
        public function enqueueScripts(): void {
            wp_enqueue_script($this->pluginName . '-slick', plugins_url('assets/lib/slick.min.js', __FILE__), [], $this->pluginVersion, true);
            wp_enqueue_script($this->pluginName . '-bigpicture', plugins_url('assets/lib/bigpicture.min.js', __FILE__), [], $this->pluginVersion, true);
            wp_enqueue_script($this->pluginName, plugins_url('js/ptx-frontend-script.min.js', __FILE__), [], $this->pluginVersion, true);
        }
    }
