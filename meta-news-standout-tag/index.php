<?php
/**
* Plugin Name: Meta News & Standout tag
* Text Domain: meta-news-standout-tag-text
* Domain Path: /languages
* Plugin URI: http://twitter.com/DavidCondence
* Description: seo google news plugin
* Version: 1.4.1
* Author: Condence
* Author URI: http://twitter.com/DavidCondence
* License: GNU General Public License v2.0
* License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
define ( 'PLUGIN_CONDENCE_PATH', plugin_dir_path( __FILE__ )); 
if(is_admin()) {      
    include_once plugin_dir_path(__FILE__) . '/inc/condence-metabox.php';
    include_once plugin_dir_path(__FILE__) . '/inc/condence-adminlist.php';
 } 
include_once plugin_dir_path(__FILE__) . '/inc/condence-post.php';

function Condence_text_lenguages() {
	load_plugin_textdomain( 'meta-news-standout-tag-text', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'Condence_text_lenguages' );

?>
