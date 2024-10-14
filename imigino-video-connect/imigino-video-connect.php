<?php
    /**
     * Imigino Video Connect
     *
     * @link              https://www.publisherstoolbox.com/imigino/
     * @since             1.0.0
     * @package           ImiginoVideo
     *
     * @wordpress-plugin
     * Plugin Name: Imigino Video Connect
     * Plugin URI: https://wordpress.org/plugins/imigino-video-connect/
     * Description: Imigino video player integration, embed your fully customisable Imigino video player into your WordPress content.
     *
     * Version: 1.1.8
     * Author: Publishers Toolbox
     * Author URI: https://www.publisherstoolbox.com/
     * License: GPL-2.0+
     * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
     * Text Domain: imigino-video-connect
     * Domain Path: /languages
     */
    
    use PTI\ptx\ptxImiginoVideoActivate;
    use PTI\ptx\ptxImiginoVideoCore;
    use PTI\ptx\ptxImiginoVideoDeActivate;
    
    /**
     * If this file is called directly, abort.
     */
    if (!defined('WPINC')) {
        die;
    }
    
    /**
     * Plugin version.
     * Start at version 1.0.0 and use SemVer - https://semver.org
     */
    define('PTX_IMIGINO_VIDEO_VERSION', '1.1.8');
    
    /**
     * Plugin global name.
     */
    define('PTX_IMIGINO_VIDEO_NAME', 'imigino-video-connect');
    
    /**
     * SPL autoloader for Publishers Toolbox plugins.
     *
     * This function loads all the classes for the plugin dynamically.
     *
     * @param $className
     */
    function PtxImiginoVideoAutoLoader(string $className) {
        /**
         * If the class being requested does not start with our prefix, we know it's not available in our project.
         */
        if (0 !== strpos($className, 'PTI')) {
            return;
        }
        
        $className = ltrim($className, '\\');
        $fileName  = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = plugin_dir_path(__FILE__) . '/' . substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
            $fileName  = str_replace('//PTI', '', $fileName);
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        
        if (file_exists($fileName)) {
            require $fileName;
        }
    }
    
    try {
        spl_autoload_register('PtxImiginoVideoAutoLoader');
    } catch (Exception $e) {
        throw new InvalidArgumentException('Could not register PtxImiginoVideoAutoLoader.');
    }
    
    /**
     * The code that runs during plugin activation.
     * This action is documented in includes/class-plugin-name-activator.php
     */
    function activateImiginoVideoPtx() {
        ptxImiginoVideoActivate::activate();
    }
    
    register_activation_hook(__FILE__, 'activateImiginoVideoPtx');
    
    /**
     * The code that runs during plugin deactivation.
     * This action is documented in includes/class-plugin-name-deactivator.php
     */
    function deactivateImiginoVideoPtx() {
        ptxImiginoVideoDeActivate::deactivate();
    }
    
    register_deactivation_hook(__FILE__, 'deactivateImiginoVideoPtx');
    
    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * @since    1.0.0
     */
    function runImiginoVideoPtx() {
        (new ptxImiginoVideoCore())->run();
    }
    
    runImiginoVideoPtx();
