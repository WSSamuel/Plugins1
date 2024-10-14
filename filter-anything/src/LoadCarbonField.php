<?php

namespace Vardaam\FilterAnything;

use Carbon_Fields\Carbon_Fields;

class LoadCarbonField {
	public function __construct() {
		if ( ! function_exists( 'carbon_fields_boot_plugin' ) ) {
			add_action( 'after_setup_theme', array( $this, 'crb_load' ) );
		}
	}

	public function crb_load() {
		Carbon_Fields::boot();
	}
}
