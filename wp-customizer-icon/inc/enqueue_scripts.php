<?php
/**
 * Enqueue scripts and styles.
 */
class WPCI_Enqueue_Scripts {

	public function __construct() {
		/**
		 * hooking theme's scripts and stylesheet
		 */
		add_action('wp_enqueue_scripts', array($this, 'scripts'));
		add_action('customize_controls_enqueue_scripts', array($this, 'controls_scripts'));
	}

	/**
	 * Function for enqueue all scripts
	 */
	public function scripts() {
		/**
		 * Load All Stylesheet
		 */
		wp_enqueue_style('materialdesignicons', wpci_plugin_url('/assets/css/materialdesignicons.min.css'), array(), null);

	}

	/**
	 * Function for controls enqueue all scripts
	 */
	public function controls_scripts() {
		/**
		 * Load All Stylesheet
		 */
		wp_enqueue_style('materialdesignicons', wpci_plugin_url('/assets/css/materialdesignicons.min.css'), array(), null);
		wp_enqueue_style('wp-customizer-icon-control', wpci_plugin_url('/assets/css/wp-customizer-icon-control.css'), array(), null);

		/**
		 * Load All jQuery Library
		 */
		wp_enqueue_script('customizer-icon-control', wpci_plugin_url('/assets/js/wp-customizer-icon-control.js'), array('jquery'), '', true);

	}

}

new WPCI_Enqueue_Scripts();
