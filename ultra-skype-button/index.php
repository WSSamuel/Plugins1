<?php
/*
	Plugin Name: Ultra Skype Button
	Plugin URI: http://www.themeultra.com/plugins/ultra-skype-button/
	Description: It's a awesome Skype button Plugin. You can make your own Skype call or chat button for your website. by this plugin you can customize button as you like. You can place button everywhere in your website by using Shortcode.
	Author: Khurshid Alam Mojumder
	Version: 1.0
	Author URI: http://www.themeultra.com/khurshid-alam-mojumder
*/



/* Enqueue Java Script */
function ultra_skype_button_jquery_main_js() {
	wp_enqueue_script('jquery');;
}
add_action('init','ultra_skype_button_jquery_main_js');


/* Enqueue Java Script */
function ultra_skype_main_js() {
	wp_enqueue_script( 'ultra-skype-js', plugins_url( '/js/skype-uri.js', __FILE__ ), array('jquery'), false);;
}
add_action('init','ultra_skype_main_js');


function ultra_skype_markup_test($atts){
	extract( shortcode_atts( array(
		'btn_id' => '1',
		'user' => 'theme.ultra',
		'color' => '',
		'btn_type' => 'dropdown',
		'btn_size' => '24',
	), $atts, 'skype' ) );		
	
		
	$list = '<div class="ultra_skype_button">';
		$list .= '
			<div id="SkypeButton_Call_'.$btn_id.'">
				
			  <script type="text/javascript">
				Skype.ui({
				  "name": "'.$btn_type.'",
				  "element": "SkypeButton_Call_'.$btn_id.'",
				  "participants": ["'.$user.'"],
				  "imageColor": "'.$color.'",
				  "imageSize": '.$btn_size.'
				});
			  </script>
			</div>
		';     
	$list.= '</div>';
	return $list;
}
add_shortcode('ultra_skype', 'ultra_skype_markup_test');




?>