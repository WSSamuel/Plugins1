<?php
    
    namespace PTI\ptx;
    
    use PTI\admin\ptxImiginoVideoAdmin;
    use PTI\frontend\ptxImiginoVideoFrontend;
    
    if (!defined('ABSPATH')) {
        exit();
    }
    
    /**
     * The core plugin class.
     *
     * This is used to define internationalization, admin-specific hooks, and
     * public-facing site hooks.
     *
     * Also maintains the unique identifier of this plugin as well as the current
     * version of the plugin.
     *
     * @since      1.0.0
     * @package    PublishersToolboxImiginoVideo
     * @subpackage PublishersToolboxImiginoVideo/ptx
     * @author     Johan Pretorius <johan.pretorius@afrozaar.com>
     */
    class ptxImiginoVideoCore {
        
        /**
         * The loader that's responsible for maintaining and registering all hooks that power
         * the plugin.
         *
         * @since 1.0.0
         * @access protected
         * @var ptxImiginoVideoLoader $loader Maintains and registers all hooks for the plugin.
         */
        protected $loader;
        
        /**
         * The unique identifier of this plugin.
         *
         * @since 1.0.0
         * @access protected
         * @var string $pluginName The string used to uniquely identify this plugin.
         */
        protected $pluginName;
        
        /**
         * The current version of the plugin.
         *
         * @since 1.0.0
         * @access protected
         * @var string $pluginVersion The current version of the plugin.
         */
        protected $pluginVersion;
        
        /**
         * Define the core functionality of the plugin.
         *
         * Set the plugin name and the plugin version that can be used throughout the plugin.
         * Load the dependencies, define the locale, and set the hooks for the admin area and
         * the public-facing side of the site.
         *
         * @since 1.0.0
         */
        public function __construct() {
            $this->pluginVersion = PTX_IMIGINO_VIDEO_VERSION;
            $this->pluginName    = PTX_IMIGINO_VIDEO_NAME;
            
            $this->loadDependencies();
            $this->defineGlobalHooks();
            $this->defineShortCodesHooks();
            $this->setLocale();
            if (is_admin()) {
                $this->defineAdminHooks();
            } else {
                $this->defineFrontendHooks();
            }
        }
        
        /**
         * Load the required dependencies for this plugin.
         *
         * Include the following files that make up the plugin:
         *
         * - ptxPluginLoader. Orchestrates the hooks of the plugin.
         * - ptxPluginI18n. Defines internationalization functionality.
         * - ptxPluginAdmin. Defines all hooks for the admin area.
         * - ptxPluginFrontend. Defines all hooks for the public side of the site.
         *
         * Create an instance of the loader which will be used to register the hooks with WordPress.
         *
         * @access private
         *
         * @since 1.0.0
         */
        private function loadDependencies(): void {
            $this->loader = new ptxImiginoVideoLoader();
        }
        
        /**
         * Define the locale for this plugin for internationalization.
         *
         * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook with WordPress.
         *
         * @access private
         *
         * @since 1.0.0
         */
        private function setLocale(): void {
            $pluginI18n = new ptxImiginoVideoI18N();
            $this->loader->addAction('plugins_loaded', $pluginI18n, 'loadPluginTextDomain');
        }
        
        /**
         * Define the global hooks for usage on frontend and backend.
         *
         * @access private
         *
         * @since 1.0.0
         */
        private function defineGlobalHooks(): void {
            $pluginGlobal = new ptxImiginoVideoGlobal($this->getPluginName(), $this->getPluginVersion());
            /**
             * Add notice if no settings have been saved.
             */
            $ptxOptions = (new ptxImiginoVideoGlobal($this->pluginName, $this->pluginVersion))->getPluginOptions();
            if (!$ptxOptions['settings']['base_url'] || !$ptxOptions['settings']['cid']) {
                $this->loader->addAction('admin_notices', $pluginGlobal, 'adminNoticeSetup');
            }
        }
        
        /**
         * Define the shortcodes.
         *
         * @access private
         *
         * @since 1.0.8
         */
        private function defineShortCodesHooks(): void {
            $pluginShortcodes = new ptxImiginoVideoShortcodes($this->getPluginName(), $this->getPluginVersion());
            
            /**
             * Load shortcodes.
             */
            $this->loader->addShortcode('imigino_video', $pluginShortcodes, 'ptxImiginoVideo');
            $this->loader->addShortcode('baobab_video', $pluginShortcodes, 'ptxImiginoVideo');
            $this->loader->addShortcode('imigino_video_live_auth', $pluginShortcodes, 'ptxImiginoVideoLive');
            $this->loader->addShortcode('imigino_carousel', $pluginShortcodes, 'ptxImiginoVideoCarousel');
        }
        
        /**
         * Register all of the hooks related to the admin area functionality of the plugin.
         *
         * @access private
         *
         * @since 1.0.0
         */
        private function defineAdminHooks(): void {
            $pluginAdmin = new ptxImiginoVideoAdmin($this->getPluginName(), $this->getPluginVersion());
            
            /**
             * Scripts to load on plugin init.
             */
            if (isset($_GET['page']) && ($_GET['page'] === $this->pluginName)) {
                $this->loader->addAction('admin_enqueue_scripts', $pluginAdmin, 'enqueueStyles');
                $this->loader->addAction('admin_enqueue_scripts', $pluginAdmin, 'enqueueScripts');
            }
            
            /**
             * Add admin menu.
             */
            $this->loader->addAction('admin_menu', $pluginAdmin, 'ptxAddImiginoVideoAdminMenu');
            
            /**
             * Add action link.
             */
            $pluginBasename = plugin_basename(plugin_dir_path(__DIR__) . $this->pluginName . '.php');
            $this->loader->addFilter('plugin_action_links_' . $pluginBasename, $pluginAdmin, 'ptxAddActionLinks');
            
            /**
             * Global ptx plugin ajax call.
             */
            $this->loader->addAction('wp_ajax_ptx_imigino_admin', $pluginAdmin, 'ptxAjaxAdmin');
        }
        
        /**
         * Register all of the hooks related to the public-facing functionality of the plugin.
         *
         * @access private
         *
         * @since 1.0.8
         */
        private function defineFrontendHooks(): void {
            $pluginPublic = new ptxImiginoVideoFrontend($this->pluginName, $this->pluginVersion);
            
            /**
             * Do a check and then include the scripts.
             */
            $this->loader->addAction('template_redirect', $pluginPublic, 'doShortCodeCheck', 10);
            $this->loader->addAction('init', $pluginPublic, 'doWidgetShortcode', 10);
            
            /**
             * Scripts to load on plugin init.
             */
            //$this->loader->addAction('wp_enqueue_scripts', $pluginPublic, 'enqueueStyles');
            //$this->loader->addAction('wp_enqueue_scripts', $pluginPublic, 'enqueueScripts');
        }
        
        /**
         * Run the loader to execute all of the hooks with WordPress.
         *
         * @since 1.0.0
         */
        public function run(): void {
            $this->loader->run();
        }
        
        /**
         * The name of the plugin used to uniquely identify it within the context of
         * WordPress and to define internationalization functionality.
         *
         * @return string The name of the plugin.
         *
         * @since 1.0.0
         */
        public function getPluginName(): string {
            return $this->pluginName;
        }
        
        /**
         * Retrieve the version number of the plugin.
         *
         * @return string The version number of the plugin.
         *
         * @since 1.0.0
         */
        public function getPluginVersion(): string {
            return $this->pluginVersion;
        }
        
    }
