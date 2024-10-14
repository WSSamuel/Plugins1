<?php defined( 'ABSPATH' ) or die( 'No direct script access!' );
/**
* Plugin Name: Daily Proverb
* Plugin URI: http://www.joshuawieczorek.com/wp/plugins/daily-proverb-light
* Description: Display a Daily Proverb in your language.
* Version: 2.0.3
* Author: Joshua Wieczorek
* Author URI: http://www.joshuawieczorek.com
* License: GPL2+
* Text Domain: daily-proverb
* Domain Path: /languages/
*/

###################################
# Load init file
###################################
include 'init.php';

###################################
# Initiate plugin
###################################
add_action( 'init' , 'jwdpv0001_init' );

###################################
## Install plugin
###################################
register_activation_hook( __FILE__ , 'jwdpv0001_install' );

###################################
## Uninstall plugin
###################################
register_deactivation_hook( __FILE__ , 'jwdpv0001_uninstall' );

###################################
# Load Trnaslation Files
###################################
add_action( 'plugins_loaded' , function() {
    load_plugin_textdomain( 'daily-proverb' , false , plugin_basename( dirname( __FILE__ ) ) . '/languages'  );
} );