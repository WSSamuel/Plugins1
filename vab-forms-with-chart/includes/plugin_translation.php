<?php
add_action( 'plugins_loaded', 'vabfwc_load_textdomain' );
if ( !function_exists( 'vabfwc_load_textdomain' ) ) {
	function vabfwc_load_textdomain() {
		load_plugin_textdomain( 'VABFWC', false, VABFWC_PLUGIN_NAME . '/languages/' );
	}
}