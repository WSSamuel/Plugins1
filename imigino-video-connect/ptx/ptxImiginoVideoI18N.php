<?php
    
    namespace PTI\ptx;
    
    if (!defined('ABSPATH')) {
        exit();
    }
    
    /**
     * Define the internationalization functionality.
     *
     * Loads and defines the internationalization files for this plugin
     * so that it is ready for translation.
     *
     * @since      1.0.0
     * @package    PublishersToolboxImiginoVideo
     * @subpackage PublishersToolboxImiginoVideo/ptx
     * @author     Johan Pretorius <johan.pretorius@afrozaar.com>
     */
    class ptxImiginoVideoI18N {
        
        /**
         * Load the plugin text domain for translation.
         *
         * @since    1.0.0
         */
        public function loadPluginTextDomain(): void {
            load_plugin_textdomain(PTX_IMIGINO_VIDEO_NAME, false, dirname(plugin_basename(__FILE__), 2) . '/languages/');
        }
    }
