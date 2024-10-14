<?php

/**
 * Plugin Name: Side By Side
 * Plugin URI: https://www.facebook.com/damiarita
 * Description: This plugin allows you to put two images next to each other. When you move your mouse over them, the line that separates them will move with it! It's perfect to compare "before" and "now" images. Use this schema to start [sidebyside][sidebyside-left][/sidebyside-left][sidebyside-right][/sidebyside-right][/sidebyside]. You have to paste your content between [sidebyside-left] and [/sidebyside-left] and between [sidebyside-right] and [/sidebyside-right]
 * Version: 1.0.2
 * Author: Damià Rita
 * Author URI: https://www.facebook.com/damiarita
 */

add_action( 'wp_enqueue_scripts', 'enqueue_sidebyside_scripts' );
function enqueue_sidebyside_scripts (){

	$extension='.min.js';
	if( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) {
		$extension='.js';
	}
   wp_enqueue_script( 'sideBySide-js', plugins_url( 'script'.$extension, __FILE__ ), array('jquery'), '1.0.2', true);
   wp_enqueue_style( 'sideBySide-css', plugins_url( 'style.css', __FILE__ ), '', '1.0.2', 'all');
}
 
add_shortcode('sidebyside', 'sidebyside');
add_shortcode('sidebyside-left', 'sidebyside_left');
add_shortcode('sidebyside-right', 'sidebyside_right');
 function sidebyside($atts, $content = ""){

   
   $skewed_box_class='skewed-boxes';
   
   $return_string = "<div class='".$skewed_box_class."'>";
   $return_string .= do_shortcode($content);
   $return_string .= "</div>";
   
   return $return_string;
}

function sidebyside_left($atts, $content = ""){
  $return_string = "<div class='left-skewed-box'><div class='left-content-box'>";
  $return_string .= do_shortcode($content);
  $return_string .= "</div></div>";
  
  return $return_string;
  
}

function sidebyside_right($atts, $content = ""){
  $return_string = "<div class='right-box'>";
  $return_string .= do_shortcode($content);
  $return_string .= "</div>";
  
  return $return_string;
}

 ?>