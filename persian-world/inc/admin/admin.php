<?php

// plugin folder url
if(!defined('RC_SCD_PLUGIN_URL')) {
	define('RC_SCD_PLUGIN_URL', plugin_dir_url( __FILE__ ));
}


class rc_sweet_custom_dashboard {
 
	function __construct() {
	
		add_action('admin_menu', array( &$this,'rc_scd_register_menu') ); 
	} 
 
	
	
	
	function rc_scd_register_menu() {
		add_menu_page( 'جهان فارسی', 'جهان فارسی', 8,'persian-world', array( &$this,'rc_scd_create_dashboard') ,  plugins_url( 'images/logo.png' , __FILE__ ) );
		add_submenu_page('persian-world', 'افزودن حلقه‌ ترجمه', 'افزودن حلقه‌ ترجمه', 8, 'persian-world-add', array( &$this,'rc_scd_create_add'));
		add_submenu_page('persian-world', 'ویرایش حلقه', 'ویرایش حلقه', 8, 'persian-world-edit', array( &$this,'rc_scd_create_edit'));

	}
	
	function rc_scd_create_dashboard() {
		include_once( 'pw-about.php'  );
	}
	function rc_scd_create_edit() {
		include_once( 'zegersot.php'  );
		zegersot_list_page();
	}
	function rc_scd_create_add() {
		include_once( 'zegersot_add.php'  );
		zegersot_add_list_page();
	}

 
}

$GLOBALS['sweet_custom_dashboard'] = new rc_sweet_custom_dashboard();

?>