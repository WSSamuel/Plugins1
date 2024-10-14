<?php
/*
Plugin Name: Vanilla Bean - Meta Maid
Plugin URI: http://www.velvary.com.au/vanilla-beans/wordpress/meta-maid/
Description: Simple header and footer code injector
Version: 2.1.0
Author: vsmash
Author URI: http://www.velvary.com.au
License: GPLv2
*/

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

if (!defined('VBEANMETAMAID_PLUGIN_DIR')) {
    define('VBEANMETAMAID_PLUGIN_DIR', plugin_dir_path(__FILE__));
}
if (!defined('VBEANMETAMAID_PLUGIN_URL')) {
    define('VBEANMETAMAID_PLUGIN_URL', plugin_dir_url(__FILE__));
}
if (!defined('VBEANMETAMAID_PLUGIN_FILE')) {
    define('VBEANMETAMAID_PLUGIN_FILE', __FILE__);
}
if (!defined('VBEANMETAMAID_PLUGIN_VERSION')) {
define('VBEANMETAMAID_PLUGIN_VERSION','2.1.0');
}

/*===========================================
        Define Includes
===========================================*/
$includes = array(
    'functions.php'
);

$frontend_includes = array(
    'meta-maid.php'
);


$adminincludes = array(
    'settings.php'

);

/*===========================================
        Load Includes
===========================================*/
// Common
foreach ($includes as $include) {
    require_once(dirname(__FILE__) . '/inc/' . $include);
}
if (is_admin()) {
    //load admin part
    foreach ($adminincludes as $admininclude) {
        require_once(dirname(__FILE__) . '/inc/admin/' . $admininclude);
    }
} else {
    //load front part
    foreach ($frontend_includes as $include) {
        require_once(dirname(__FILE__) . '/inc/' . $include);
    }
}


add_action('admin_menu', 'vbean_meta_maid_create_menu');

if (!function_exists('vbean_meta_maid_create_menu')) {


    function vbean_meta_maid_create_menu()
    {


        if (empty ($GLOBALS['admin_page_hooks']['vanillabeans-settings'])) {
            //create new top-level menu
            add_menu_page('Vanilla Beans', 'Vanilla Beans', 'administrator', 'vanillabeans-settings', 'VanillaBeans\LiveSettings', VBEANMETAMAID_PLUGIN_URL . 'vicon.png', 4);
        }
        add_submenu_page('vanillabeans-settings', 'Meta Maid', 'Meta Maid', 'administrator', VBEANMETAMAID_PLUGIN_FILE, 'VanillaBeans\MetaMaid\SettingsPage');


        //call register settings function
        add_action('admin_init', 'VanillaBeans\MetaMaid\RegisterSettings');
    }
}



