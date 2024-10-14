<?php
/*
Plugin Name: Zenost Shortcodes
Plugin URI: http://www.imhysoft.com/products
Description: Zenost shortcodes plugin used for shortcodes embedding in your posts, pages and widgets for headings, buttons, accordians, columns, lists and toggles. It is supported by font awesome.  Insert directly or use the WYSIWYG editor to insert anywhere.
Author: Imran Ahmed Khan
Author URI: http://www.imhysoft.com/
Version: 1.0
License: GPLv2 or later
Text Domian: zenost-shortcodes
*/
require_once plugin_dir_path( __FILE__ ) . 'inc/shortcodes.php';
define( 'MX_SHORTCODES_VERSION', '1.0' );


class MX_Shortcodes_TinyMCE_Buttons {
	function __construct() {
    	add_action( 'admin_head', array(&$this,'init') );
		// add_action( 'admin_head', array( &$this, 'localize_script' ) );
    }
    function init() {
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;		

		if ( get_user_option('rich_editing') == 'true' ) {  
			// add_action('admin_enqueue_scripts', array(&$this, 'register_plugin_styles'));

			add_filter( 'mce_external_plugins', array(&$this, 'add_plugin') );  
			add_filter( 'mce_buttons', array(&$this,'register_button') ); 
		}  
    }  
	function localize_script() {
		global $wc_shortcodes_theme_support;

		?>
		<script type="text/javascript">
			var wpc_shortcodes = <?php echo json_encode( $wc_shortcodes_theme_support ); ?>;
		</script>
		<?php
	}
	function add_plugin($plugin_array) {  
		global $wp_version;
		$ver = MX_SHORTCODES_VERSION;

		
			$plugin_array['wpc_shortcodes'] = plugin_dir_url( __FILE__ ).'inc/js/shortcodes-tinymce-4.js?ver=' . $ver;
		
		
		return $plugin_array; 
	}
	function register_button($buttons) {  
		array_push($buttons, "wpc_shortcodes_button");
       
		
		return $buttons; 
	}
}
$wcshortcode = new MX_Shortcodes_TinyMCE_Buttons;
