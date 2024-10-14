<?php

/**
 * Power Charts custom post type.
 *
 * This class registers the power charts post type and the taxonomy for associated groups.
 *
 * Class name suffix _CPT stands for [C]ustom_[P]ost_[T]ype.
 *
 * @since 0.1.0
 */
class WPGO_Power_Charts_Enqueue_Scripts {

	protected $module_roots;

	/**
	 * Power Charts class constructor.
	 *
	 * @since 0.1.0
	 */
	public function __construct($module_roots) {

		$this->module_roots = $module_roots;

		// Front end scripts for charts
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );

		// Admin scripts for charts
		add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_admin_scripts'), 10, 1 );
	}

	/**
	 * Register front end scripts.
	 *
	 * @since 0.1.0
	 */
	public function enqueue_scripts() {

		// @todo delete this function or leave a note to say front end scripts/styles are added in the shortcode function?

		// @todo Will need to add more scripts to render the chart on the front end (add d3 chart JS as inline code, as well as inline CSS?)
		// @todo Also, need to ONLY enqueue these on pages/posts/widgets that use the chart shortcode.
		//wp_enqueue_style( 'wpgo-power-charts', $this->module_roots['uri'] . '/css/power-charts.css' );
		//wp_enqueue_script( 'wpgo-d3', $this->module_roots['uri'] . '/js/pcd3.js' , array(), '', true );
	}

	/**
	 * Register admin only scripts.
	 *
	 * @since 0.1.0
	 */
	public function enqueue_admin_scripts( $hook ) {

		global $post;

		$id = $post->ID;
		//$js = get_post_meta( $id, '_wpgo_power_charts_cpt_js', true );

		// add chart css inline
		$css = get_post_meta( $id, '_wpgo_power_charts_cpt_css', true );

		//$html = get_post_meta( $id, '_wpgo_power_charts_cpt_html', true );
		//$data = get_post_meta( $id, '_wpgo_power_charts_cpt_data', true );

		if ( 'wpgo_power_charts' === $post->post_type ) {

			// for existing charts only
			if ( $hook == 'post.php' ) {

				// Styles

				// add this to the front end only?
				//wp_enqueue_style( 'wpgo-power-charts', $this->module_roots['uri'] . '/css/power-charts.css' );

				wp_enqueue_style(
					'wpgo-power-charts-admin',
					$this->module_roots['uri'] . '/css/power-charts-admin.css'
				);

				wp_add_inline_style(
					'wpgo-power-charts-admin',
					$css
				);

				// ---

				// Scripts

				wp_enqueue_script(
					'wpgo-d3-generic-chart-builder',
					$this->module_roots['uri'] . '/js/chart-builders/pc-generic-chart-builder.js',
					array( 'wpgo-d3-admin-utility' ),
					'',
					true
				);

				// Load in chart builder code for selected chart type. For new charts this will be loaded via power-charts-new.js.
				// @todo delete this?
				/*$chartType = get_post_meta( $id, '_wpgo_power_charts_cpt_type' );
				if ( ! empty( $chartType ) ) {
					wp_enqueue_script(
						'wpgo-d3-chart-builder',
						$this->module_roots['uri'] . '/js/chart-builders/pc-' . $chartType[0] . '-chart-builder.js',
						array( 'wpgo-d3-generic-chart-builder' ),
						'',
						true
					);
				}*/

				wp_enqueue_script(
					'wpgo-d3-admin',
					$this->module_roots['uri'] . '/js/power-charts-admin.js',
					array( 'wpgo-d3-generic-chart-builder' ),
					'',
					true
				);

			}

			// for new charts only
			if ( $hook == 'post-new.php' ) {
				wp_enqueue_style(
					'wpgo-power-charts-admin',
					$this->module_roots['uri'] . '/css/power-charts-admin-new.css'
				);

				wp_enqueue_script(
					'wpgo-d3-sample-data',
					$this->module_roots['uri'] . '/js/power-charts-sample-data.js',
					array( 'wpgo-d3-admin-utility' ),
					'',
					true
				);
				wp_enqueue_script(
					'wpgo-d3-admin-new',
					$this->module_roots['uri'] . '/js/power-charts-admin-new.js',
					array( 'wpgo-d3-sample-data' ),
					'',
					true
				);
			}

			// for new AND existing charts
			if ( $hook == 'post.php' || $hook == 'post-new.php' ) {
				wp_enqueue_script(
					'wpgo-d3',
					$this->module_roots['uri'] . '/js/pcd3.js',
					array(),
					'',
					true
				);

				wp_enqueue_script(
					'wpgo-d3-admin-utility',
					$this->module_roots['uri'] . '/js/power-charts-admin-utility.js',
					array(
						'jquery',
						'wpgo-d3',
						'wp-api'
					),
					'',
					true
				);

				// RGBA color picker
				wp_enqueue_script(
					'wpgo-pc-alpha-color-picker-js',
					$this->module_roots['uri'] . '/js/alpha-color-picker/alpha-color-picker.js',
					array( 'jquery', 'wp-color-picker' ),
					null,
					true
				);
				wp_enqueue_style(
					'wpgo-pc-alpha-color-picker-css',
					$this->module_roots['uri'] . '/js/alpha-color-picker/alpha-color-picker.css',
					array( 'wp-color-picker' )
				);
			}
		}
	}
}