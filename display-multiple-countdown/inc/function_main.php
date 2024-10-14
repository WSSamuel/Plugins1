<?php if (!defined('ABSPATH')) {
	exit; // Exit if directly accessed
}
/**
 * Fired during plugin activation
 */
if (!class_exists('JCDCountDownClass')) {
	class JCDCountDownClass {
		public function __construct() {
			/*Menu hook*/
			add_action('admin_menu', array($this, 'register_JCD_menu'));
			/*Register WP Admin Styling Scripts*/
			add_action('admin_enqueue_scripts', array($this, 'JCD_admin_enqueue'));
			/*Register Styling Scripts*/
			add_action('wp_enqueue_scripts', array($this, 'JCD_wp_enqueue'));
		}

		public function register_JCD_menu() {
			if (is_admin()) {
			 add_submenu_page('tools.php','Multi CountDown','Multi CountDown','administrator','JCDC_add_menu_page',array($this, 'JCD_settings_template')); }
			}

		public function JCD_wp_enqueue() {
			 wp_enqueue_script('JCDC-count',JCDC_URL."assets/js/count.js","","",true);
		}
		
		public function JCD_admin_enqueue($hook) {
			if (isset($_GET["page"]) && $_GET["page"] == "JCDC_add_menu_page") {
			wp_enqueue_style('JCDC-global-css', JCDC_URL . '/assets/css/global.css');
			 wp_enqueue_script('JCDC-count',JCDC_URL."assets/js/count.js","","",true);

			}
		}

		public function JCD_settings_template() {

			if (is_admin() && current_user_can('manage_options')) {
				require JCDC_PATH.'/templates/shortcodeDetail.php';
			} else {
				_e('Denied ! Only admin can see this.', 'multi-countDown');
			}

		}
		public function JCD_validator_function($field) {
			if (empty($field)) {
				return;
			}
			$field = sanitize_text_field($field);
			$field = trim($field);
			$field = stripslashes($field);
			$field = htmlspecialchars($field);
			return $field;
		}
	}
	new JCDCountDownClass();
}
