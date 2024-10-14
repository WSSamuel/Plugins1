<?php

/*
Plugin Name: Display Multiple Countdown 
Plugin URI:
Description: Add Condown any post, Add Condown any Pages, Add Multipal CountDown in One Page Or Post By Using ShortCode,
Version: 1.0
Author: Blitz Mobile Apps
License: GPLv2
Author URI: https://blitzmobileapps.com/
Requires at least: 5.5
Tested up to:5.8
Text Domain: multi-countdown
 */


define('JCDC_PATH', dirname(__FILE__));
$plugin = plugin_basename(__FILE__);
define('JCDC_URL', plugin_dir_url($plugin));

require JCDC_PATH.'/inc/function_main.php';
require JCDC_PATH.'/inc/create_shortcode.php';
?>