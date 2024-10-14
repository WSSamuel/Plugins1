<?php
if ( !function_exists('VABFWC_autoload_Class')) {
	function VABFWC_autoload_Class( $name ) {
		$FileS  = VABFWC_PLUGIN_DIR . '/includes/VABFWC_CLASS/' . $name . '.php';
		if ( file_exists( $FileS ) ) {
			include_once $FileS;
		}
	}
	spl_autoload_register( "VABFWC_autoload_Class" );
}