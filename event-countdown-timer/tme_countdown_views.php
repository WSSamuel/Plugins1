<?php
	function tme_add_countdown($data_arr = array()) {
    global $default_setting;
    $data_arr = shortcode_atts( $default_setting, $data_arr );
    $data = 'data_title="'.esc_html($data_arr['title']).'" ';
    $data .= 'data_img_link="'.esc_html($data_arr['img_link']).'" ';
    $data .= 'data_background_color="'.esc_html($data_arr['background_color']).'" ';
    $data .= 'data_time_box_color="'.esc_html($data_arr['time_box_color']).'" ';
    $data .= 'data_time_text_color="'.esc_html($data_arr['time_text_color']).'" ';
    $data .= 'data_time_title_color="'.esc_html($data_arr['time_title_color']).'" ';
	if($data_arr['countdown_date'] != ""){
    $data .= 'data_countdown_date="'.esc_html($data_arr['countdown_date']).'" ';
		
	}else if($data_arr['countdown_datetime'] != ""){
		$data .= 'data_countdown_date="'.esc_html(date_format(date_create($data_arr['countdown_datetime'],timezone_open($data_arr['countdown_timezone'])),"Y/m/d H:iP")).'" ';
	}else{
		return;
	}
    
    return '<div id="tme-countdown" class="tme-countdown" '.$data.'></div>';
	}

 
?>