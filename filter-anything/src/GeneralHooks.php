<?php

namespace Vardaam\FilterAnything;

class GeneralHooks {
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'shortcode_wp_register_scripts' ) );
	}

	public static function shortcode_wp_register_scripts() {
		if ( ! wp_style_is( 'wfa-style', 'registered' ) ) {
			wp_register_style(
				'wfa-style',
				plugins_url( '/assets/style.css', dirname( __FILE__ ) ),
				array(),
				'1.0.0'
			);
		}

		/* SELECT 2 JS */
		if ( ! wp_style_is( 'wfa-select2-css', 'registered' ) ) {
			wp_register_style(
				'wfa-select2-css',
				plugins_url( '/assets/plugins/select2/select2.min.css', dirname( __FILE__ ) ),
				array(),
				'1.0.0'
			);
		}
		if ( ! wp_script_is( 'wfa-select2-full-js', 'registered' ) ) {
			wp_register_script(
				'wfa-select2-full-js',
				plugins_url( '/assets/plugins/select2/select2.full.min.js', dirname( __FILE__ ) ),
				array( 'jquery' ),
				'1.0.0',
				true
			);
		}

		/* FLATPICKR JS */
		if ( ! wp_style_is( 'wfa-flatpickr-css', 'registered' ) ) {
			wp_register_style(
				'wfa-flatpickr-css',
				plugins_url( '/assets/plugins/flatpickr/flatpickr.min.css', dirname( __FILE__ ) ),
				array(),
				'1.0.0'
			);
		}
		if ( ! wp_script_is( 'wfa-flatpickr-js', 'registered' ) ) {
			wp_register_script(
				'wfa-flatpickr-js',
				plugins_url( '/assets/plugins/flatpickr/flatpickr.min.js', dirname( __FILE__ ) ),
				array( 'jquery' ),
				'1.0.0',
				true
			);
		}

		if ( ! wp_script_is( 'wfa-script', 'registered' ) ) {
			wp_register_script(
				'wfa-script',
				plugins_url( '/assets/script.js', dirname( __FILE__ ) ),
				array( 'wfa-select2-full-js' ),
				'1.0.0',
				true
			);
		}
	}
}
