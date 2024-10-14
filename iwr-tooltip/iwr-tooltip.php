<?php
/*
Plugin Name: iWR Tooltip
Plugin URI: http://www.iwebrays.com/iwr-tooltip/
Description: Simple Tooltip Shortcode.
Version: 1.0
Author: Vinay Sharma
Author URI: http://www.iwebrays.com/
*/
?>
<?php define('IWRTOOLTIP_URL', WP_PLUGIN_URL.'/iwr-tooltip');?>
<?php 
//Load javascripts and css files
if(!is_admin()){
	add_action('wp_print_scripts', 'iwrtooltip_load_js');
	function iwrtooltip_load_js(){
		wp_enqueue_script('jquery');
		wp_enqueue_script('iWRTooltipJs', IWRTOOLTIP_URL.'/js/jquery.atooltip.min.js');
	}

	add_action('wp_print_styles', 'iwrtooltip_load_css');
	function iwrtooltip_load_css(){
		wp_enqueue_style('iWRTooltipCss', IWRTOOLTIP_URL.'/css/atooltip.css');
	}

	add_action('wp_head', 'iwrtooltip_head_code');
	function iwrtooltip_head_code(){
		$out = "<script type='text/javascript'>
					jQuery(document).ready(function(){
						jQuery('a.normalTip').aToolTip();  
					});
				</script>";
				echo $out;
	}
}

function iwr_tooltip( $atts, $content = null ) {  
	extract( shortcode_atts( array(
		'title' => '',
	), $atts ) );
	return '<a href="#" class="normalTip" title="'.$title.'">'.$content.'</a>';  
}  
     add_shortcode("iwrtooltip", "iwr_tooltip");  
	 /* Wrie on you page like this:- [iwrtooltip title="hi sexxy!!"]blog[/iwrtooltip]
	 it will output hi sexxy as tooltip, while the pointer will hover on the blog*/