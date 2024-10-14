<?php
function wppw_cttabox_box_shortcode_out_put( $atts ) {
	$atts = shortcode_atts(
		array(
			'id' => 'no id',
		), $atts, 'wppw_cta_box' );
	ob_start();
	$cta_box_template_id = get_post_meta($atts['id'], 'cta_box_template_id', true);
	if($cta_box_template_id == "template_one"){
	require ('box_display_template.php');
	}
	if($cta_box_template_id == "template_two"){
	require ('box_display_wid_template.php');
	}
	if($cta_box_template_id == "template_three"){
	require ('box_display_orng_template.php');
	}
	
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode( 'wppw_cta_box', 'wppw_cttabox_box_shortcode_out_put' );