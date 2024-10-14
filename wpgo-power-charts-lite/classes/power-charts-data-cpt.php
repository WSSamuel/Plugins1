<?php

/**
 * Power Charts data custom post type.
 *
 * This class registers the power charts data post type to store chart data only.
 *
 * Class name suffix _CPT stands for [C]ustom_[P]ost_[T]ype.
 *
 * @since 0.1.0
 */
class WPGO_Power_Charts_Data_CPT {

	protected $module_roots;

	/**
	 * Power Charts class constructor.
	 *
	 * Contains hooks that point to class methods to initialise the custom post type etc.
	 *
	 * @since 0.1.0
	 */
	public function __construct($module_roots) {

		$this->module_roots = $module_roots;
	}

	// Register custom route and endpoints to get chart data
	public function register_custom_route() {

		register_rest_route( 'wpgo-power-charts/v1', '/charts', array(
			'methods'  => WP_REST_Server::READABLE,
			'callback' => array( $this, 'add_charts_endpoint' )
		) );

		register_rest_route( 'wpgo-power-charts/v1', '/charts/(?P<id>\d+)', array(
			'methods'  => WP_REST_Server::READABLE,
			'callback' => array( $this, 'add_chart_endpoint' )
		) );

		register_rest_route( 'wpgo-power-charts/v1', '/chart-data/(?P<id>\d+)', array(
			'methods'  => WP_REST_Server::READABLE,
			'callback' => array( $this, 'add_chart_data_endpoint' )
		) );

		register_rest_route( 'wpgo-power-charts/v1', '/sample-chart-data/bar-chart', array(
			'methods'  => WP_REST_Server::READABLE,
			'callback' => array( $this, 'sample_bar_chart_data_endpoint' )
		) );
	}

	// @todo add all sample data to separate class. or just add these callbacks to the class
	// Add custom endpoint to get chart data
	public function sample_bar_chart_data_endpoint($request) {

		//$file = 'report.csv';
		//header( "Content-Type: ;charset=utf-8" );
		//header( "Content-Disposition: attachment;filename=\"$file\"" );
		//header( "Pragma: no-cache" );
		//header( "Expires: 0" );

		//$csv = fopen('php://output', 'w');

		$csv_meta = trim(get_post_meta('5653', '_wpgo_power_charts_cpt_data', true));
		return $csv_meta;
		//print_r($csv_meta);

		//$arr = explode('\r\n', $csv_meta);
		//print_r($arr);
		//exit();
		//$txt = "";
		//foreach($arr as $ar) {
		//	$ar = trim($ar, "\r\n");

		//	$txt = $txt . $ar;
		//}

		//$csv = $csv_meta;

		// Download it
		//fclose( $csv );
		//exit();


		//print_r($text);
		//$json = json_encode($csv_meta);
		//$csv_meta_arr = explode('\r\n', $csv_meta);

		//ob_start();

		//foreach($csv_meta_arr as $meta) {
		//	echo $meta;
		//}

		//$csv = ob_get_contents();

		//ob_end_clean();
		//echo "Hello";
		//exit();
		//return $txt;
	}

	// Add custom endpoint to get chart data
	public function add_chart_data_endpoint($request) {

		// Here we are grabbing the 'id' path variable from the $request object. WP_REST_Request implements ArrayAccess, which allows us to grab properties as though it is an array.
		$id = (string) $request['id'];

		$post_meta = get_post_meta( $id, '_wpgo_power_charts_cpt_data', true );

		if( empty( $post_meta ) ) {
			return new WP_Error( 'rest_chart_data_invalid', 'The chart data does not exist.', array( 'status' => 404 ) );
		}

		return rest_ensure_response($post_meta);
	}

	// Add custom endpoint to get chart data
	public function add_chart_endpoint($request) {

		// Here we are grabbing the 'id' path variable from the $request object. WP_REST_Request implements ArrayAccess, which allows us to grab properties as though it is an array.
		$id = (string) $request['id'];

		$post = get_post( $id );

		if( empty( $post ) ) {
			return new WP_Error( 'rest_chart_invalid', 'The chart does not exist.', array( 'status' => 404 ) );
		}

		return rest_ensure_response($post);
	}

	// Add custom endpoint to get chart data
	public function add_charts_endpoint($data) {

		$args = [
			'numberposts' => -1,
			'post_type' => 'wpgo_power_charts'
		];
		$posts = get_posts( $args );

		if( empty( $posts ) ) {
			return null;
		}

		return rest_ensure_response($posts);
	}
}