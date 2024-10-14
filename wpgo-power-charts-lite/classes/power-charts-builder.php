<?php

/**
 * Power Charts builder class.
 *
 * Utility class to help build the chart HTML.
 *
 * @since 0.1.0
 */
class WPGO_Power_Charts_Builder {

	public function __construct() {
//		add_filter( 'wp_insert_post_data', array( &$this, 'insert_default_chart_data' ), 10, 2 );
	}

	public function insert_default_chart_data( $data, $postarr ) {

		if($data['post_type'] == 'wpgo_power_charts') {
			//echo "<pre>";
			//print_r($data);
			//echo "</pre>";
			//echo "<pre>";
			//print_r($postarr);
			//echo "</pre>";
			$data['post_title'] = 'Bar Chart';
		}

		return $data;
	}

//	public function insert_default_chart_data( $data, $postarr ) {

//		$post_type = 'wpgo_power_charts';
//		if ($data['post_status'] !== 'auto-draft') { return $data; }

//		if ($data['post_type']==$post_type) {

//			$data['post_title'] = 'fudger';

			//echo get_post($post['ID'])->post_status;

			//echo "<pre>";
			//print_r($data);
			//echo "</pre>";

			//die();

//		}
		//die();
//		return $data;
//	}

	/**
	 * Build preview chart HTML.
	 *
	 * @since 0.1.0
	 */
	public static function render_chart($id) {
		echo '<div class="pc-' . $id . ' wpgo-power-charts"></div>';
	}
}
new WPGO_Power_Charts_Builder();