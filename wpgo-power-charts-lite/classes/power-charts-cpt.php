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
class WPGO_Power_Charts_CPT {

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

		// Register custom endpoint to get chart data:
		// e.g. http://www.yoursite.dev/wp-json/power-charts/v1
		//add_action( 'rest_api_init', array( &$this, 'register_custom_endpoint' ) );

		/* Register CPT and associated taxonomy. */
		add_action( 'init', array( &$this, 'register_post_type' ) );
		add_action( 'init', array( &$this, 'register_taxonomy' ) );

		/* Customize CPT columns on overview page. */
		add_filter( 'manage_wpgo_power_charts_posts_columns', array( &$this, 'change_overview_columns' ) ); /* Which columns are displayed. */
		add_action( 'manage_wpgo_power_charts_posts_custom_column', array( &$this, 'custom_column_content' ), 10, 2 ); /* The html output for each column. */
		add_filter( 'manage_edit-wpgo_power_charts_sortable_columns', array( &$this, 'sort_custom_columns' ) ); /* Specify which columns are sortable. */

		/* Customize the CPT messages. */
		add_filter( 'post_updated_messages', array( &$this, 'update_cpt_messages' ) );
		add_filter( 'enter_title_here', array( &$this, 'update_title_message' ) );

		// Add an ID column to Power Charts group admin page
		add_action( "manage_edit-wpgo_power_charts_group_columns", array( &$this, 'add_id_column' ) );
		add_filter( "manage_edit-wpgo_power_charts_group_sortable_columns", array( &$this, 'add_id_column' ) );
		add_filter( "manage_wpgo_power_charts_group_custom_column", array( &$this, 'show_id_column' ), 10, 3 );
		add_action( 'admin_print_styles-edit-tags.php', array( &$this, 'style_id_column' ) );

		add_action( 'admin_bar_menu', array( &$this, 'remove_view_toolbar_link'), 999 );

		/* Add meta boxes to power charts custom post type. */
		add_action( 'admin_init', array( &$this, 'power_charts_cpt_meta_boxes_init' ) );

		register_activation_hook( $this->module_roots['__FILE__'], array( &$this, 'flush_rewrites' ) );

		/* Add dropdown filter on wpgo_power_charts CPT edit.php to sort by taxonomy. */
		// These work OK but until I can figure out how to get the default taxonomy term to be associated
		// automatically with new CPT items then I will leave this feature out as the show all option doesn't
		// work properly.
		// add_action( 'restrict_manage_posts', array( &$this, 'taxonomy_filter_restrict_manage_posts' ) );
		// add_filter( 'parse_query', array( &$this, 'taxonomy_filter_post_type_request' ) );
	}

	public function flush_rewrites() {
		// call CPT/taxonomy registration functions here (it should also be hooked into 'init')
		$this->register_post_type();
		$this->register_taxonomy();
		flush_rewrite_rules();
	}

	// Register custom endpoint to get chart data
	public function register_custom_endpoint() {

		register_rest_route(
			'power-charts/v1',
			'/charts',
			[
				'methods' => 'GET',
				'callback' => array( $this, 'add_custom_endpoint' )
			]
		);
	}

	// Add custom endpoint to get chart data
	public function add_custom_endpoint($data) {

		$args = [
			'numberposts' => -1,
			'post_type' => 'wpgo_power_charts'
		];
		$posts = get_posts( $args );

		if( empty( $posts ) ) {
			return null;
		}

		return $posts;
	}

	// Remove the 'View Chart' admin toolbar link
	public function remove_view_toolbar_link( $wp_admin_bar ) {

		global $post;

		if(isset($post)) {
			// @todo: this also seems to fire when on the Power Charts main CPT index page in the admin which we don't really want
			if($post->post_type == 'wpgo_power_charts') {
				$wp_admin_bar->remove_node( 'view' );
			}
		}
	}

	public function add_id_column( $columns ) {
		return $columns + array ( 'tax_id' => 'ID' );
	}

	public function style_id_column() {
		echo "<style>#tax_id{width:4em}</style>";
	}

	public function show_id_column( $v, $name, $id ) {
		return 'tax_id' === $name ? $id : $v;
	}

	/**
	 * Register Power Charts post type.
	 *
	 * @since 0.1.0
	 */
	public function register_post_type() {

		/* Post type arguments. */
		$args = array(
			'public'              => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'query_var'           => true,
			'rewrite'             => false,
			'capability_type'     => 'page',
			'hierarchical'        => false,
			'menu_icon'           => 'dashicons-chart-bar',
			'supports'            => array(
				'title', 'author' //, 'thumbnail'
			),
			'labels'              => array(
				'name'               => __( 'Power Charts', 'power-charts' ),
				'all_items'          => __( 'All Charts', 'power-charts' ),
				'singular_name'      => __( 'Chart', 'power-charts' ),
				'add_new'            => __( 'Add New Chart', 'power-charts' ),
				'add_new_item'       => __( 'Add New Chart', 'power-charts' ),
				'edit_item'          => __( 'Edit Chart', 'power-charts' ),
				'new_item'           => __( 'New Chart', 'power-charts' ),
				'view_item'          => __( 'View Chart', 'power-charts' ),
				'search_items'       => __( 'Search Charts', 'power-charts' ),
				'not_found'          => __( 'No Charts Found', 'power-charts' ),
				'not_found_in_trash' => __( 'No Charts Found In Trash', 'power-charts' ),
				'attributes'         => __( 'Chart Attributes', 'power-charts' ),
			)
		);

		/* Register post type. */
		register_post_type( 'wpgo_power_charts', $args );
	}

	/**
	 * Register Power Charts taxonomy.
	 *
	 * @since 0.1.0
	 */
	public function register_taxonomy() {

		/* Power Charts taxonomy arguments. */
		$args = array(
			'hierarchical'  => true,
			'query_var'     => true,
			'show_tagcloud' => false,
			'sort'          => true,
			'rewrite'       => false,
			'labels'        => array(
				'name'              => __( 'Chart Groups', 'power-charts' ),
				'singular_name'     => __( 'Chart Group', 'power-charts' ),
				'edit_item'         => __( 'Edit Chart Group', 'power-charts' ),
				'update_item'       => __( 'Update Chart Group', 'power-charts' ),
				'add_new_item'      => __( 'Add New Group', 'power-charts' ),
				'new_item_name'     => __( 'New Chart Name', 'power-charts' ),
				'all_items'         => __( 'All Charts', 'power-charts' ),
				'search_items'      => __( 'Search Charts', 'power-charts' ),
				'parent_item'       => __( 'Parent Chart', 'power-charts' ),
				'parent_item_colon' => __( 'Parent Chart:', 'power-charts' )
			)
		);

		/* Register the power charts taxonomy. */
		//register_taxonomy( 'wpgo_power_charts_group', array( 'wpgo_power_charts' ), $args );
	}

	/**
	 * Change the columns on the custom post types overview page.
	 *
	 * @since 0.1.0
	 */
	public function change_overview_columns( $cols ) {

		$cols = array(
			'cb'            => '<input type="checkbox">',
			'title'         => __( 'Chart Name', 'power-charts' ),
			//'image'         => __( 'Image', 'power-charts' ),
			//'group'         => __( 'Group', 'power-charts' ),
			'type'         => __( 'Chart Type', 'power-charts' ),
			'id'            => __( 'Chart ID', 'power-charts' ),
			'date'          => __( 'Date Created', 'power-charts' )
		);

		return $cols;
	}

	/**
	 * Add some content to the custom columns from the custom post type.
	 *
	 * @since 0.1.0
	 */
	public function custom_column_content( $column, $post_id ) {

		switch ( $column ) {
			case "title":
				echo 'title';
				break;
			//case "image":
				/* If no featured image set, use gravatar if specified. */
			/*	if ( ! ( $image = get_the_post_thumbnail( $post_id, array( 32, 32 ) ) ) ) {
					$image = get_post_meta( $post_id, '_wpgo_power_charts_cpt_image', true );
					if ( trim( $image ) == '' ) {
						$image = '<em>' . __( 'No image', 'power-charts' ) . '</em>';
					} else {
						$image = get_avatar( $image, $size = '32' );
					}
				}
				echo $image;
				break;*/
			/*case "group":
				$taxonomy  = 'wpgo_power_charts_group';
				$post_type = get_post_type( $post_id );
				$terms     = get_the_terms( $post_id, $taxonomy );
/*
				/* get_the_terms() only returns an array on success so need check for valid array. */
/*				if ( is_array( $terms ) ) {
					$str = "";
					foreach ( $terms as $term ) {
						$str .= "<a href='edit.php?post_type={$post_type}&{$taxonomy}={$term->slug}'> " . esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'group', 'edit' ) ) . "</a>, ";
					}
					echo rtrim( $str, ", " );
				} else {
					echo '<em>' . __( 'Not in any groups', 'power-charts' ) . '</em>';
				}
				break;*/
			case "type":
				$power_charts_cpt_type = get_post_meta( $post_id, '_wpgo_power_charts_cpt_type', true );
				echo $this->chart_type_display_name($power_charts_cpt_type);
				break;
			case "id":
				echo $post_id;
				break;
		}
	}

	/**
	 * Make custom columns sortable.
	 *
	 * @since 0.1.0
	 */
	function sort_custom_columns() {

		return array(
			'title'   => 'title',
			//'type' => 'type',
			'date'    => 'date',
			'id'      => 'id'
		);
	}

	/**
	 * Initialise custom post type meta boxes.
	 *
	 * @since 0.1.0
	 */
	public function power_charts_cpt_meta_boxes_init() {

		/* Add meta boxes to Power Charts CPT editor. */

		add_meta_box( 'wpgo-power-charts-preview', __( 'Chart Preview', 'power-charts' ), array( &$this, 'meta_box_preview' ), 'wpgo_power_charts', 'normal', 'high' );

		add_meta_box( 'wpgo-power-charts-labels', __( 'Chart Labels', 'power-charts' ), array( &$this, 'meta_box_labels' ), 'wpgo_power_charts', 'side', 'default' );

		add_meta_box( 'wpgo-power-charts-layout', __( 'Chart Layout', 'power-charts' ), array( &$this, 'meta_box_layout' ), 'wpgo_power_charts', 'side', 'default' );

		add_meta_box( 'wpgo-power-charts-legend', __( 'Chart Legend', 'power-charts' ), array( &$this, 'meta_box_legend' ), 'wpgo_power_charts', 'side', 'default' );

		add_meta_box( 'wpgo-power-charts-series-colors', __( 'Data Series Colors', 'power-charts' ), array( &$this, 'meta_box_series_colors' ), 'wpgo_power_charts', 'side', 'default' );

		add_meta_box( 'wpgo-power-charts-colors', __( 'Chart Colors', 'power-charts' ), array( &$this, 'meta_box_colors' ), 'wpgo_power_charts', 'side', 'default' );

		add_meta_box( 'wpgo-power-charts-type', __( 'Please Select Chart Type...', 'power-charts' ), array( &$this, 'meta_box_chart_type' ), 'wpgo_power_charts', 'normal', 'high' );

		add_meta_box( 'wpgo-power-charts-js', __( 'Chart Code (JavaScript)', 'power-charts' ), array( &$this, 'meta_box_js' ), 'wpgo_power_charts', 'normal', 'high' );

		add_meta_box( 'wpgo-power-charts-config-js', __( 'Chart Config (JavaScript)', 'power-charts' ), array( &$this, 'meta_box_config_js' ), 'wpgo_power_charts', 'normal', 'high' );

		add_meta_box( 'wpgo-power-charts-css', __( 'Chart Styles', 'power-charts' ), array( &$this, 'meta_box_css' ), 'wpgo_power_charts', 'normal', 'high' );

		add_meta_box( 'wpgo-power-charts-html', __( 'Chart Markup (HTML)', 'power-charts' ), array( &$this, 'meta_box_html' ), 'wpgo_power_charts', 'normal', 'high' );

		add_meta_box( 'wpgo-power-charts-data', __( 'Chart Data', 'power-charts' ), array( &$this, 'meta_box_data' ), 'wpgo_power_charts', 'normal', 'high' );

		add_meta_box( 'wpgo-power-charts-cpt_sc', __( 'Chart Shortcode', 'power-charts' ), array( &$this, 'meta_box_shortcode' ), 'wpgo_power_charts', 'normal', 'high' );

		/* Hook to save our meta box data when the post is saved. */
		add_action( 'save_post', array( &$this, 'save_meta_box_data' ) );
	}

	/**
	 * Display the Power Charts labels meta box.
	 *
	 * @since 0.1.0
	 */
	public function meta_box_labels( $post, $args ) {

		/* Retrieve our custom meta box values */
		$power_charts_x_axis_label = get_post_meta( $post->ID, '_wpgo_power_charts_x_axis_label', true );
		$power_charts_y_axis_label = get_post_meta( $post->ID, '_wpgo_power_charts_y_axis_label', true );
		$power_charts_title_label = get_post_meta( $post->ID, '_wpgo_power_charts_title_label', true );
		?>

		<table width="100%">
			<tbody>
			<tr>
				<td colspan="2">
					<div class="pc-control-container">
					<label for="wpgo_power_charts_title_label">Chart Title</label>
					<input type="text" id="wpgo_power_charts_title_label" name="wpgo_power_charts_title_label" value="<?php echo $power_charts_title_label; ?>" />
					</div>

					<div class="pc-control-container">
					<label for="wpgo_power_charts_x_axis_label">X-Axis</label>
					<input type="text" id="wpgo_power_charts_x_axis_label" name="wpgo_power_charts_x_axis_label" value="<?php echo $power_charts_x_axis_label; ?>" />
					</div>

					<div class="pc-control-container">
					<label for="wpgo_power_charts_y_axis_label">Y-Axis</label>
					<input type="text" id="wpgo_power_charts_y_axis_label" name="wpgo_power_charts_y_axis_label" value="<?php echo $power_charts_y_axis_label; ?>" />
					</div>
				</td>
			</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Display the Power Charts series color pickers meta box.
	 *
	 * @since 0.1.0
	 */
	public function meta_box_series_colors( $post, $args ) {

		// rather than saving the color pickers in the usual way, we're storing them all in a single array due to the number of controls
		$num_series_color_pickers = 20;

		/* Retrieve our custom meta box values */
		//$power_charts_series_color_1 = get_post_meta( $post->ID, '_wpgo_power_charts_series_color_1', true );
		//$power_charts_series_color_2 = get_post_meta( $post->ID, '_wpgo_power_charts_series_color_2', true );
		//$power_charts_series_color_3 = get_post_meta( $post->ID, '_wpgo_power_charts_series_color_3', true );

		$power_charts_series_colors = get_post_meta( $post->ID, '_wpgo_power_charts_series_colors', true );

		//echo "<pre>";
		//print_r($power_charts_series_colors);
		//echo "</pre>";
		?>

		<table width="100%">
			<tbody>
			<tr>
				<td colspan="2">
					<?php
					for ($i = 1; $i <= $num_series_color_pickers; $i++) {
					?>
					<div id="wpgo_power_charts_series_color_container_<?php echo $i; ?>">
					<label for="wpgo_power_charts_series_color_<?php echo $i; ?>">Series <?php echo $i; ?></label>
					<input class="alpha-color-picker" type="text" id="wpgo_power_charts_series_color_<?php echo $i; ?>" name="wpgo_power_charts_series_color_<?php echo $i; ?>" value="<?php echo $power_charts_series_colors['wpgo_power_charts_series_color_' . $i]; ?>" />
					</div>
					<?php
					}
					?>
				</td>
			</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Display the Power Charts color pickers meta box.
	 *
	 * @since 0.1.0
	 */
	public function meta_box_colors( $post, $args ) {

		/* Retrieve color picker meta box values */
		$pc_chart_bg_color = get_post_meta( $post->ID, '_pc_chart_bg_color', true );
		$pc_svg_bg_color = get_post_meta( $post->ID, '_pc_svg_bg_color', true );

		//echo "<pre>";
		//print_r($power_charts_series_colors);
		//echo "</pre>";
		?>

		<table width="100%">
			<tbody>
			<tr>
				<td colspan="2">
					<div id="pc_chart_bg_colors_container">
						<label for="pc_chart_bg_color">Chart Background</label>
						<input class="alpha-color-picker" type="text" id="pc_chart_bg_color" name="pc_chart_bg_color" value="<?php echo $pc_chart_bg_color; ?>" />
						<label for="pc_svg_bg_color">SVG Background</label>
						<input class="alpha-color-picker" type="text" id="pc_svg_bg_color" name="pc_svg_bg_color" value="<?php echo $pc_svg_bg_color; ?>" />
					</div>
				</td>
			</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Display the Power Charts layout meta box.
	 *
	 * @since 0.1.0
	 */
	public function meta_box_layout( $post, $args ) {

		/* Retrieve our custom meta box values */
		$margin_top = get_post_meta( $post->ID, '_wpgo_power_charts_margin_top', true );
		$margin_right = get_post_meta( $post->ID, '_wpgo_power_charts_margin_right', true );
		$margin_bottom = get_post_meta( $post->ID, '_wpgo_power_charts_margin_bottom', true );
		$margin_left = get_post_meta( $post->ID, '_wpgo_power_charts_margin_left', true );
		$aspect_ratio = get_post_meta( $post->ID, '_wpgo_power_charts_aspect_ratio', true );
		$min_width = get_post_meta( $post->ID, '_wpgo_power_charts_min_width', true );
		$max_width = get_post_meta( $post->ID, '_wpgo_power_charts_max_width', true );
		$pc_chart_centered_chk = get_post_meta( $post->ID, '_pc_chart_centered_chk', true );
		?>

		<table width="100%">
			<tbody>
			<tr>
				<td colspan="2">
					<div class="pc-control-container layout">
						<label for="wpgo_power_charts_margin_top">Margin Top (px)</label>
						<input min="0" type="number" id="wpgo_power_charts_margin_top" name="wpgo_power_charts_margin_top" value="<?php echo $margin_top; ?>" />
					</div>

					<div class="pc-control-container layout">
						<label for="wpgo_power_charts_margin_right">Margin Right (px)</label>
						<input min="0" type="number" id="wpgo_power_charts_margin_right" name="wpgo_power_charts_margin_right" value="<?php echo $margin_right; ?>" />
					</div>

					<div class="pc-control-container layout">
						<label for="wpgo_power_charts_margin_bottom">Margin Bottom (px)</label>
						<input min="0" type="number" id="wpgo_power_charts_margin_bottom" name="wpgo_power_charts_margin_bottom" value="<?php echo $margin_bottom; ?>" />
					</div>

					<div class="pc-control-container layout">
						<label for="wpgo_power_charts_margin_left">Margin Left (px)</label>
						<input min="0" type="number" id="wpgo_power_charts_margin_left" name="wpgo_power_charts_margin_left" value="<?php echo $margin_left; ?>" />
					</div>

					<div class="pc-control-container layout">
						<label for="wpgo_power_charts_aspect_ratio">Aspect Ratio (0-1)</label>
						<input step="0.01" min="0" max="1" type="number" id="wpgo_power_charts_aspect_ratio" name="wpgo_power_charts_aspect_ratio" value="<?php echo $aspect_ratio; ?>" />
					</div>

					<div class="pc-control-container layout">
						<label for="wpgo_power_charts_min_width">Min Width</label>
						<input step="1" min="200" max="1200" type="text" id="wpgo_power_charts_min_width" name="wpgo_power_charts_min_width" value="<?php echo $min_width; ?>" />
					</div>

					<div class="pc-control-container layout">
						<label for="wpgo_power_charts_max_width">Max Width</label>
						<input step="1" min="300" max="2000" type="text" id="wpgo_power_charts_max_width" name="wpgo_power_charts_max_width" value="<?php echo $max_width; ?>" />
					</div>

					<div style="margin-top:5px;">
						<label for="pc_chart_centered_chk">
							<input value="1" type="checkbox" name="pc_chart_centered_chk" id="pc_chart_centered_chk" <?php if ( isset ( $pc_chart_centered_chk ) ) checked( $pc_chart_centered_chk, 1 ); ?> />
							<span class="pc_chart_centered_chk"><?php _e( 'Center Chart', 'power-charts' )?></span>
						</label>
					</div>
				</td>
			</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Display the Power Charts settings meta box.
	 *
	 * @since 0.1.0
	 */
	public function meta_box_chart_type( $post, $args ) {

		/* Retrieve our custom meta box values */
		$power_charts_cpt_type = get_post_meta( $post->ID, '_wpgo_power_charts_cpt_type', true );

		//$chart_types = ['column', 'grouped_column', 'bar', 'pie', 'donut', 'scatter', 'candlestick', 'multi', 'stacked', 'grouped'];
		$chart_types = ['column', 'grouped_column'];
		$default = 'column';
		?>

		<table width="100%">
			<tbody>
			<tr>
				<td colspan="2">
					<div id="pc-type-container">
					<?php foreach($chart_types as $chart_type) { ?>
						<div>
						<?php $default_checked = ($chart_type == $default) ? 'checked="checked"' : ''; ?>
					<label for="wpgo_power_charts_cpt_type_<?php echo $chart_type; ?>">
						<input <?php echo $default_checked; ?> type="radio" name="wpgo_power_charts_cpt_type" id="wpgo_power_charts_cpt_type_<?php echo $chart_type; ?>" value="<?php echo $chart_type; ?>" <?php if ( isset ( $power_charts_cpt_type ) ) checked( $power_charts_cpt_type, $chart_type ); ?>>
						<div class="pc-type-img"><img src="<?php echo $this->module_roots[uri] . '/images/chart_thumbnails/' . $chart_type . '.jpg'; ?>" alt="<?php echo $this->chart_type_display_name($chart_type); ?>" /></div>
						<div class="pc-type-txt"><?php echo $this->chart_type_display_name($chart_type); ?></div>
					</label>
						</div>
					<?php } ?>
					</div>
					<p class="description">Expecting more charts? We'll be <strong>adding more charts very soon</strong>. Please click <a href="http://eepurl.com/c3TqZT" target="_blank">here</a> to signup for regular news & updates.</p>
					<p class="description">Also, <a href="https://wpgoplugins.com/contact-us/" target="_blank">let us know</a> what new charts and features you'd like to see added. We'll do our best to implement them!</p>
					<div id="pc-create-chart"></div>
				</td>
			</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Return formatted chart type label.
	 *
	 * @since 0.1.0
	 */
	public function chart_type_display_name( $raw ) {
		return ucwords(implode(' ', explode('_', $raw)));
	}

	/**
	 * Display the Power Charts JavaScript meta box.
	 *
	 * @since 0.1.0
	 */
	public function meta_box_js( $post, $args ) {

		/* Retrieve our custom meta box values */
		$power_charts_cpt_js =       get_post_meta( $post->ID, '_wpgo_power_charts_cpt_js', true );
		$power_charts_cpt_image =        get_post_meta( $post->ID, '_wpgo_power_charts_cpt_image', true );
		?>

		<table width="100%">
			<tbody>
			<tr>
				<td colspan="2">
					<textarea id="wpgo_power_charts_cpt_js" rows="15" style="width:100%;" name="wpgo_power_charts_cpt_js" readonly><?php echo esc_attr( $power_charts_cpt_js ); ?></textarea>
				</td>
			</tr>
			<tr style="display:none;">
				<td width="100"><?php _e( 'Gravatar E-mail', 'power-charts' ); ?></td>
				<td>
					<input style="width:100%;" type="text" name="wpgo_power_charts_cpt_image" value="<?php echo esc_attr( $power_charts_cpt_image ); ?>">
				</td>
			</tr>
			<tr style="display:none;">
				<td>&nbsp;</td>
				<td>
					<p class="description"><?php printf( __( 'To upload an image, use the Power Charts Image feature to the right (recommended %1$d x %2$d pixels), or enter a Gravatar e-mail above. Leave field blank to NOT show an image.', 'power-charts' ), $w, $w ); ?></p>
				</td>
			</tr>
			</tbody>
		</table>
	<?php
	}

	/**
	 * Display the Power Charts Config JavaScript meta box.
	 *
	 * @since 0.1.0
	 */
	public function meta_box_config_js( $post, $args ) {

		/* Retrieve our custom meta box values */
		$power_charts_cpt_config_js = get_post_meta( $post->ID, '_wpgo_power_charts_cpt_config_js', true );
		?>

		<table width="100%">
			<tbody>
			<tr>
				<td colspan="2">
					<textarea id="wpgo_power_charts_cpt_config_js" rows="15" style="width:100%;" name="wpgo_power_charts_cpt_config_js" readonly><?php echo esc_attr( $power_charts_cpt_config_js ); ?></textarea>
				</td>
			</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Display the Power Charts Config legend meta box.
	 *
	 * @since 0.1.0
	 */
	public function meta_box_legend( $post, $args ) {

		/* Retrieve our custom meta box values */
		$pc_legend_status_chk = get_post_meta( $post->ID, '_pc_legend_status_chk', true );
		$pc_legend_offset = get_post_meta( $post->ID, '_pc_legend_offset', true );
		?>

		<table width="100%">
			<tbody>
			<tr>
				<td colspan="2">
					<div class="pc-control-container legend">
						<label for="pc_legend_offset_top">Offset (px)</label>
						<input min="-100" max="100" type="number" id="pc_legend_offset" name="pc_legend_offset" value="<?php echo $pc_legend_offset; ?>" />
					</div>
					<div style="margin-top:5px;" class="legend">
						<label for="pc_legend_status_chk">
							<input value="1" type="checkbox" name="pc_legend_status_chk" id="pc_legend_status_chk" <?php if ( isset ( $pc_legend_status_chk ) ) checked( $pc_legend_status_chk, 1 ); ?> />
							<span class="pc_legend_status_chk_span"><?php _e( 'Display Legend', 'power-charts' )?></span>
						</label>
					</div>
				</td>
			</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Display the Power Charts CSS meta box.
	 *
	 * @since 0.1.0
	 */
	public function meta_box_css( $post, $args ) {

		/* Retrieve our custom meta box values */
		$power_charts_cpt_css = get_post_meta( $post->ID, '_wpgo_power_charts_cpt_css', true );
		?>

		<table width="100%">
			<tbody>
			<tr>
				<td colspan="2">
					<textarea id="wpgo_power_charts_cpt_css" rows="15" style="width:100%;" name="wpgo_power_charts_cpt_css" readonly><?php echo esc_attr( $power_charts_cpt_css ); ?></textarea>
				</td>
			</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Display the Power Charts HTML meta box.
	 *
	 * @since 0.1.0
	 */
	public function meta_box_html( $post, $args ) {

		/* Retrieve our custom meta box values */
		$power_charts_cpt_html = get_post_meta( $post->ID, '_wpgo_power_charts_cpt_html', true );
		?>

		<table width="100%">
			<tbody>
			<tr>
				<td colspan="2">
					<textarea rows="15" style="width:100%;" name="wpgo_power_charts_cpt_html"><?php echo esc_attr( $power_charts_cpt_html ); ?></textarea>
				</td>
			</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Display the Power Charts data meta box.
	 *
	 * @since 0.1.0
	 */
	public function meta_box_data( $post, $args ) {

		/* Retrieve our custom meta box values */
		$power_charts_cpt_data = get_post_meta( $post->ID, '_wpgo_power_charts_cpt_data', true );
		?>

		<table width="100%">
			<tbody>
			<tr>
				<td colspan="2">
					<textarea rows="15" style="width:100%;" id="wpgo_power_charts_cpt_data" name="wpgo_power_charts_cpt_data"><?php echo esc_attr( $power_charts_cpt_data ); ?></textarea>
					<button style="margin: 10px 0 0 0;float: right;" id="wpgo_power_charts_cpt_update_data" class="button button-primary button-large">Update Data</button>
				</td>
			</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Display the Power Charts preview meta box.
	 *
	 * @since 0.1.0
	 */
	public function meta_box_preview( $post, $args ) {

		// render chart wrapper element
		WPGO_Power_Charts_Builder::render_chart($post->ID);
	}

	/**
	 * Save the custom post type meta box input field settings.
	 *
	 * @since 0.1.0
	 */
	public function save_meta_box_data( $post_id ) {

		global $typenow;

		/* Only work for specific post type */
		if ( $typenow != 'wpgo_power_charts' ) {
			return;
		}

		/* Save the meta box data as post meta, using the post ID as a unique prefix. */

		// Chart series colors
		$col_array = array(); // initialise empty array
		foreach($_POST as $key => $value){
			if("wpgo_power_charts_series_color_" == substr($key,0,31)){
				$col_array[$key] = $value;
			}
		}
		// if the first one is set then set them all
		if ( isset( $_POST['wpgo_power_charts_series_color_1'] ) ) {
			update_post_meta( $post_id, '_wpgo_power_charts_series_colors', $col_array );
		}

		// Chart colors
		if ( isset( $_POST['pc_chart_bg_color'] ) ) {
			update_post_meta( $post_id, '_pc_chart_bg_color', esc_attr( $_POST['pc_chart_bg_color'] ) );
		}
		if ( isset( $_POST['pc_svg_bg_color'] ) ) {
			update_post_meta( $post_id, '_pc_svg_bg_color', esc_attr( $_POST['pc_svg_bg_color'] ) );
		}

		// Legend
		if ( isset( $_POST['pc_legend_status_chk'] ) ) {
			update_post_meta( $post_id, '_pc_legend_status_chk', esc_attr( $_POST['pc_legend_status_chk'] ) );
			update_post_meta( $post_id, '_pc_legend_offset', sanitize_text_field( $_POST['pc_legend_offset'] ) );
		}

		// Chart layout
		if ( isset( $_POST['wpgo_power_charts_margin_top'] ) ) {
			update_post_meta( $post_id, '_wpgo_power_charts_margin_top', sanitize_text_field( $_POST['wpgo_power_charts_margin_top'] ) );
		}
		if ( isset( $_POST['wpgo_power_charts_margin_right'] ) ) {
			update_post_meta( $post_id, '_wpgo_power_charts_margin_right', sanitize_text_field( $_POST['wpgo_power_charts_margin_right'] ) );
		}
		if ( isset( $_POST['wpgo_power_charts_margin_bottom'] ) ) {
			update_post_meta( $post_id, '_wpgo_power_charts_margin_bottom', sanitize_text_field( $_POST['wpgo_power_charts_margin_bottom'] ) );
		}
		if ( isset( $_POST['wpgo_power_charts_margin_left'] ) ) {
			update_post_meta( $post_id, '_wpgo_power_charts_margin_left', sanitize_text_field( $_POST['wpgo_power_charts_margin_left'] ) );
		}
		if ( isset( $_POST['wpgo_power_charts_aspect_ratio'] ) ) {
			update_post_meta( $post_id, '_wpgo_power_charts_aspect_ratio', sanitize_text_field( $_POST['wpgo_power_charts_aspect_ratio'] ) );
		}
		if ( isset( $_POST['wpgo_power_charts_min_width'] ) ) {
			update_post_meta( $post_id, '_wpgo_power_charts_min_width', sanitize_text_field( $_POST['wpgo_power_charts_min_width'] ) );
		}
		if ( isset( $_POST['wpgo_power_charts_max_width'] ) ) {
			update_post_meta( $post_id, '_wpgo_power_charts_max_width', sanitize_text_field( $_POST['wpgo_power_charts_max_width'] ) );
		}
		if ( isset( $_POST['pc_chart_centered_chk'] ) ) {
			update_post_meta( $post_id, '_pc_chart_centered_chk', esc_attr( $_POST['pc_chart_centered_chk'] ) );
		}

		// Chart labels
		if ( isset( $_POST['wpgo_power_charts_x_axis_label'] ) ) {
			update_post_meta( $post_id, '_wpgo_power_charts_x_axis_label', sanitize_text_field( $_POST['wpgo_power_charts_x_axis_label'] ) );
		}
		if ( isset( $_POST['wpgo_power_charts_y_axis_label'] ) ) {
			update_post_meta( $post_id, '_wpgo_power_charts_y_axis_label', sanitize_text_field( $_POST['wpgo_power_charts_y_axis_label'] ) );
		}
		if ( isset( $_POST['wpgo_power_charts_title_label'] ) ) {
			update_post_meta( $post_id, '_wpgo_power_charts_title_label', sanitize_text_field( $_POST['wpgo_power_charts_title_label'] ) );
		}

		if( isset( $_POST[ 'wpgo_power_charts_cpt_type' ] ) ) {
			update_post_meta( $post_id, '_wpgo_power_charts_cpt_type', esc_attr( $_POST[ 'wpgo_power_charts_cpt_type' ] ) );
		}

		if ( isset( $_POST['wpgo_power_charts_cpt_js'] ) ) {
			update_post_meta( $post_id, '_wpgo_power_charts_cpt_js', ( $_POST['wpgo_power_charts_cpt_js'] ) );
		}

		if ( isset( $_POST['wpgo_power_charts_cpt_config_js'] ) ) {
			update_post_meta( $post_id, '_wpgo_power_charts_cpt_config_js', ( $_POST['wpgo_power_charts_cpt_config_js'] ) );
		}

		if ( isset( $_POST['wpgo_power_charts_cpt_css'] ) ) {
			update_post_meta( $post_id, '_wpgo_power_charts_cpt_css', ( $_POST['wpgo_power_charts_cpt_css'] ) );
		}

		if ( isset( $_POST['wpgo_power_charts_cpt_html'] ) ) {
			update_post_meta( $post_id, '_wpgo_power_charts_cpt_html', ( $_POST['wpgo_power_charts_cpt_html'] ) );
		}

		if ( isset( $_POST['wpgo_power_charts_cpt_data'] ) ) {
			update_post_meta( $post_id, '_wpgo_power_charts_cpt_data', esc_attr( $_POST['wpgo_power_charts_cpt_data'] ) );
		}

		/*if ( isset( $_POST['wpgo_power_charts_cpt_company'] ) ) {
			update_post_meta( $post_id, '_wpgo_power_charts_cpt_company', sanitize_text_field( $_POST['wpgo_power_charts_cpt_company'] ) );
		}

		if ( isset( $_POST['wpgo_power_charts_cpt_company_url'] ) ) {
			update_post_meta( $post_id, '_wpgo_power_charts_cpt_company_url', sanitize_text_field( $_POST['wpgo_power_charts_cpt_company_url'] ) );
		}*/

		if ( isset( $_POST['wpgo_power_charts_cpt_image'] ) ) {
			update_post_meta( $post_id, '_wpgo_power_charts_cpt_image', sanitize_text_field( $_POST['wpgo_power_charts_cpt_image'] ) );
		}
	}

	/**
	 * Display meta box to show shortcode for the current power charts.
	 *
	 * @since 0.1.0
	 */
	public function meta_box_shortcode( $post, $args ) {

		$id = $post->ID;

		//$pc_terms = get_the_terms( $id, 'wpgo_power_charts_group' );
		$pc_description = __( 'Copy and paste the shortcode above into any post, or page, to display the chart.', 'power-charts' );
		//$group_pc_html = '';

		/*if( !empty($pc_terms) ) {
			$group_sc = '';
			$pc_description = __( 'Copy and paste ONE of the shortcodes above into any post, or page, to display the chart, or group of charts.', 'power-charts' );

			foreach($pc_terms as $pc_term) {
				$group_sc .= "[pc group='{$pc_term->term_id}'] ";
			}
			$group_sc = trim($group_sc); // trim trailing space
			$group_sc = trim($group_sc); // trim trailing space

			if( count($pc_terms) > 1 ) {
				$group_label = "Group power charts shortcodes";
			} elseif( count($pc_terms) == 1 ) {
				$group_label = "Group power charts shortcode";
			}

			$group_pc_html = '<tr><td>
				<h4 style="margin: 5px 0;">'.$group_label.'</h4>
				<input style="width:100%;font-family: Courier New;" type="text" readonly name="wpgo_group_power_charts_cpt_sc" value="'.$group_sc.'">
			</td></tr>';
		}*/

		$single_sc = "[pc id='{$id}']";
		?>
		<table width="100%">
			<tbody>
			<tr>
				<td>
					<input style="width:100%;font-family: Courier New;" type="text" readonly name="wpgo_single_power_charts_cpt_sc" value="<?php echo $single_sc; ?>">
				</td>
			</tr>
			<?php // echo $group_pc_html; ?>
			<tr>
				<td >
					<p style="margin-top: 7px;" class="description"><?php echo $pc_description; ?></p>
				</td>
			</tr>
			</tbody>
		</table>
	<?php
	}

	/**
	 *
	 *
	 * @since 0.1.0
	 */
	public function update_cpt_messages( $messages ) {
		global $post, $post_ID;

		$messages['wpgo_power_charts'] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => sprintf( __( 'Chart updated.', 'power-charts' ), esc_url( get_permalink( $post_ID ) ) ),
			2  => __( 'Custom field updated.', 'power-charts' ),
			3  => __( 'Custom field deleted.', 'power-charts' ),
			4  => __( 'Chart updated.', 'power-charts' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Chart restored to revision from %s', 'power-charts' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => sprintf( __( 'Chart published.', 'power-charts' ), esc_url( get_permalink( $post_ID ) ) ),
			7  => __( 'Chart saved.', 'power-charts' ),
			8  => sprintf( __( 'Chart submitted.', 'power-charts' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
			9  => sprintf( __( 'Chart scheduled for: %1$s.', 'power-charts' ),
				// translators: Publish box date format, see http://php.net/date
				'<strong>' . date_i18n( __( 'M j, Y @ G:i', 'power-charts' ), strtotime( $post->post_date ) ) . '</strong>', esc_url( get_permalink( $post_ID ) ) ),
			10 => sprintf( __( 'Chart draft updated.', 'power-charts' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
		);

		return $messages;
	}

	/**
	 * Update the title edit prompt message shown when editing a new power chart.
	 *
	 * @since 0.1.0
	 */
	public function update_title_message( $message ) {
		global $post;

		$pt = get_post_type( $post );
		if ( $pt == 'wpgo_power_charts' ) {
			$message = __( 'Enter chart title here', 'power-charts' );
		}

		return $message;
	}

	/**
	 * Filter the request to just give posts for the given taxonomy.
	 *
	 * @since 0.1.0
	 */
	public function taxonomy_filter_restrict_manage_posts() {
		global $typenow;

		/* Only work for specific post type */
		if ( $typenow != 'wpgo_power_charts' ) {
			return;
		}

		$post_types = get_post_types( array( '_builtin' => false ) );

		if ( in_array( $typenow, $post_types ) ) {
			$filters = get_object_taxonomies( $typenow );

			foreach ( $filters as $tax_slug ) {
				if ( ! isset( $_GET[$tax_slug] ) ) {
					$selected = '';
				} else {
					$selected = $_GET[$tax_slug];
				}

				$tax_obj = get_taxonomy( $tax_slug );
				wp_dropdown_categories( array(
					'taxonomy'     => $tax_slug,
					'name'         => $tax_obj->name,
					'orderby'      => 'name',
					'selected'     => $selected,
					'hierarchical' => $tax_obj->hierarchical,
					'show_count'   => true,
					'hide_empty'   => true
				) );
			}
		}
	}

	/**
	 * Add a filter to the query so the dropdown will work.
	 *
	 * @since 0.1.0
	 */
	public function taxonomy_filter_post_type_request( $query ) {
		global $pagenow, $typenow;

		if ( 'edit.php' == $pagenow ) {
			$filters = get_object_taxonomies( $typenow );
			foreach ( $filters as $tax_slug ) {
				$var = & $query->query_vars[$tax_slug];
				if ( isset( $var ) ) {
					$term = get_term_by( 'id', $var, $tax_slug );
					$var  = $term->slug;
				}
			}
		}
	}
}