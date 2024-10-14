<?php

/**
 * Power Charts shortcodes class.
 *
 * @since 0.1.0
 */
class WPGO_Power_Charts_Shortcodes {

	// @todo load the other PC shortcode CSS file if shortcode used on the page. ATM it is always loaded!
	private $_success;
	//private $_d3_cdn = 'https://d3js.org/d3.v4.js';
	protected $module_roots;

	/**
	 * Registers the framework shortcodes, and allows them to be used in widgets.
	 *
	 * @since 0.1.0
	 */
	public function __construct($module_roots) {

		$this->module_roots = $module_roots;

	    // Initialize class properties.
		$this->_success = array();

		// Register [pc] shortcode
		add_shortcode( 'pc', array( &$this, 'pc_shortcode' ) );
		add_shortcode( 'power-charts', array( &$this, 'pc_shortcode' ) );
	}

	/**
	 * [pc] Power Charts shortcode function.
	 *
	 * Example usage: [pc id="123"]
	 *
	 * Where id is a single power charts id.
	 *
	 */
	public function pc_shortcode( $atts ) {

		/* Get power charts attributes from the shortcode. */
		extract( shortcode_atts( array(
			'id'    => '',
			/*'group' => '',
			'num'   => '-1',
			'rnd'   => false,
			'no_excerpt' => '0',
			'no_company' => '0',
			'no_name' => '0',
			'no_image' => '0',
			'no_link' => '0',
			'render' => '',
			'template' => '',*/
		), $atts ) );

		$data = get_post_meta( $id, '_wpgo_power_charts_cpt_data', true );
		$chart_fixed_js = get_post_meta( $id, '_wpgo_power_charts_cpt_js', true );
		$chart_config_js = get_post_meta( $id, '_wpgo_power_charts_cpt_config_js', true );

		$css = get_post_meta( $id, '_wpgo_power_charts_cpt_css', true );
		$html = '<div class="pc-' . $id . ' wpgo-power-charts"></div>';
		$chart_js = "(function (){" . $chart_config_js . $chart_fixed_js;

		//echo "<pre>";
		//echo $chart_js;
		//echo "</pre>";

		// Only add chart scripts/styles to pages shortcode is used on
		wp_enqueue_script( 'wpgo-d3', $this->module_roots['uri'] . '/js/pcd3.js' , array(), '', true );
		wp_localize_script( 'wpgo-d3', 'pc_data_' . $id, $data );
		wp_add_inline_script( 'wpgo-d3', $chart_js );

		wp_enqueue_style( 'wpgo-power-charts', $this->module_roots['uri'] . '/css/power-charts.css' );
		wp_add_inline_style( 'wpgo-power-charts', $css );

		return html_entity_decode($html);
	}
}