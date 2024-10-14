<?php
/**
* Plugin Name: Copyright notice
* Plugin URI: https://wordtune.me
* Description: Use the shortcode [cn] on any page ore post and your Site will auto update after new year.
* Author: WordTune
* Author URI: https://wordtune.me
* Version:           1.0
* License:           GPL-2.0+
* License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
**/

function copyright_notice() {
$Year = date("Y");
echo esc_attr (get_bloginfo( $show, 'display' )),"&#32©"," $Year";}
add_shortcode( 'cn','copyright_notice' );
?>
