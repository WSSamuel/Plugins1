<?php

namespace Vardaam\FilterAnything;

class Shortcode {
	private bool $already_loaded_once = false;

	public function __construct() {
		add_shortcode( 'wfa_filter', array( $this, 'filter_shortcode' ) );
	}

	public function filter_shortcode( $attrs ) {
		// prevent loading shortcode twice on same page
		if ( $this->already_loaded() ) {
			return '';
		}
		$this->mark_as_loaded();

		$array_defaults = [
			'id'         => null,
			'submit_url' => ''
		];

		$args = wp_parse_args( $attrs, $array_defaults );
		ob_start();
		include plugin_dir_path( __FILE__ ) . '../templates/tp-directory-shortcode.php';
		$html = ob_get_contents();
		ob_end_clean();
		$this->enqueue_shortcode_styles_and_scripts( sanitize_text_field( $args['id'] ) );

		return $html;
	}

	private function already_loaded(): bool {
		return $this->already_loaded_once;
	}

	private function mark_as_loaded() {
		$this->already_loaded_once = true;
	}

	private function enqueue_shortcode_styles_and_scripts( $directory_id ) {
		$error_text            = carbon_get_post_meta( $directory_id, 'error_text', );
		$no_results_found_text = carbon_get_post_meta( $directory_id, 'no_result_found_text' );

		GeneralHooks::shortcode_wp_register_scripts();

		wp_enqueue_style( 'wfa-style' );
		wp_enqueue_style( 'wfa-select2-css' );
		wp_enqueue_script( 'wfa-select2-full-js' );
		wp_enqueue_style( 'wfa-flatpickr-css' );
		wp_enqueue_script( 'wfa-flatpickr-js' );
		wp_enqueue_script( 'wfa-script' );
		wp_localize_script( 'wfa-script', 'wfa_ajax', array(
			'url'                   => admin_url( 'admin-ajax.php' ),
			'error_text'            => $error_text ?? __( 'Something went wrong, Please try again later.' ),
			'no_results_found_text' => $no_results_found_text ?? __( 'No results found, Please try changing your search criteria.' ),
			'is_enfold_theme'       => wfa_is_enfold_theme()
		) );
	}
}
