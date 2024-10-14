<?php

// twitter shortcode default data vale
$CFWP_settings = array();
$CFWP_settings = array(
    'ETWP_user_name' => 'nike',
    'ETWP_twitter_theme' => 'dark',
	'ETWP_url_link_color' => '#0B0080',
    'ETWP_theme_border_color' => '#f2f2f2'
   
	
    );

$default_settings  = wp_parse_args(get_option('ETWP_settings'),$CFWP_settings);
update_option('ETWP_settings',$default_settings);



// twitter stick box default data vale
$CFWP_sticky_settings = array();
$CFWP_sticky_settings = array(
	'ETWP_sticky_enable_setting' => 'yes',
    'ETWP_user_name' => 'nike',
    'ETWP_twitter_theme' => 'light',
	'ETWP_url_link_color' => '#0B0080',
    'ETWP_theme_border_color' => '#f2f2f2'
	
    );

$default_sticky_settings  = wp_parse_args(get_option('ETWP_twitter_sticky_settings'),$CFWP_sticky_settings);
update_option('ETWP_twitter_sticky_settings',$default_sticky_settings);


?>