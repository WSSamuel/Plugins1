<?php
// Zen Dash uninstall script
// deletes all database options when plugin is removed
// as discussed here: http://codex.wordpress.org/Function_Reference/register_uninstall_hook
// @since 1.0
// 

// Direct calls to this file are Forbidden when core files are not present
// Thanks to Ed from ait-pro.com for this  code 

if ( !function_exists('add_action') ){
header('Status: 403 Forbidden');
header('HTTP/1.1 403 Forbidden');
exit();
}

if ( !current_user_can('manage_options') ){
header('Status: 403 Forbidden');
header('HTTP/1.1 403 Forbidden');
exit();
}

// if uninstall is not called from WordPress then exit
if (!defined('WP_UNINSTALL_PLUGIN')) exit();

    // delete all options
	delete_option ('zendash_widget1');
	delete_option ('zendash_widget2');
	delete_option ('zendash_widget3');
	delete_option ('zendash_widget4');
	delete_option ('zendash_widget5');
	delete_option ('zendash_widget6');
	delete_option ('zendash_widget7');
	delete_option ('zendash_widget8');
	delete_option ('zendash_widget9');
	
	delete_option ('zendash_update1');
	delete_option ('zendash_update2');
	delete_option ('zendash_update3');
	
	delete_option ('zendash_version');
	
	delete_option ('zendash_footer_wordpress');
	delete_option ('zendash_footer_shortcut');
	delete_option ('zendash_footer_version');
	
	// since @1.3
	delete_option ('zendash_menu1');
	delete_option ('zendash_menu2');
	delete_option ('zendash_menu3');
	delete_option ('zendash_menu4');
	delete_option ('zendash_menu5');
	delete_option ('zendash_menu6');
	delete_option ('zendash_menu7');
	delete_option ('zendash_menu8');
	delete_option ('zendash_menu9');
	delete_option ('zendash_menu10');
	delete_option ('zendash_menu11');
	

// Thanks for using Zen Dash
// If you'd like to try again someday check out http://wpguru.co.uk where it lives and grows

?>