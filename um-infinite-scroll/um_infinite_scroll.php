<?php
/*
  Plugin Name: UM Infinite Scroll Member Directory
  Plugin URI: 
  Description: Activate infinite scroll in Ultimate Member directory and get rid of pagination!
  Version: 1.0.0
  Text Domain: umis
  Author: nicolly
  Author URI: 
 */

// Plugin version
define('UMIS_VERSION', '1.0.0');

// i18n domain
define('UMIS_I18N_DOMAIN', 'umis');

function umis_enqueue_scripts()
{
    if (is_admin()) {
        return;
    }
    $src = plugin_dir_url( __FILE__ ) . 'assets/' . 'js/main.js?ver=' . UMIS_VERSION;

    wp_enqueue_script('umis_main', $src, array('jquery'), UMIS_VERSION, true);
}

add_action('wp_enqueue_scripts', 'umis_enqueue_scripts');