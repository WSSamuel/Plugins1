<?php

/**
 * Power Charts about page.
 *
 * @since 0.1.0
 */
class WPGO_Power_Charts_About_Page {

	protected $_plugin_about_page; // handle to the plugin options page
	protected $_args;

	/**
	 * Plugin options class constructor.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( &$this, 'add_about_page' ) );
	}

	/**
	 * Display plugin about page.
	 *
	 * @since 0.1.0
	 */
	public function render_about_page() {
		?>
		<div class="wrap about-wrap">
			<h1>Welcome to Power Charts Lite</h1>
			<p class="about-text">Firstly, thank you for choosing this plugin. We've worked very hard to bring you a friendly, easy to use charting plugin. We hope you enjoy using it!</p>
			<h2 class="plugin-title">Let's get you started...</h2>
			<p class="lead-description" style="color:#e14d46;font-style:italic;">Note: This initial plugin release is a proof of concept version, just to give you a taste of what's to come!</p>

			<h3>Creating a New Chart</h3>
			<p style="font-size: 18px;">To create a new chart follow these simple steps.</p>
			<ol>
				<li>Click Power Charts ><strong><a target="_blank" href="<?php echo get_admin_url() . 'post-new.php?post_type=wpgo_power_charts'; ?>">Add New Chart</a></strong>.</li>
				<li>Select a chart type, then click <strong>Create Chart</strong>.</li>
				<li>That's it! <strong>Seriously. It's as simple as that!</strong></li>
			</ol>

			<h3>Chart Configuration</h3>
			<p style="font-size: 18px;">So, you've just created a brand new chart. What now?</p>
			<ol>
				<li>After you create a chart you'll be presented with the default chart view for the type of chart selected.</li>
				<li>At the very minimum you'll want to add your own data, which you can do by editing the <strong>Chart Data</strong> text box.</li>
				<li>When done, click the <strong>Update Data</strong> button to re-render the chart with the new data.</li>
				<li>There are numerous other settings you can change to change the way your chart looks. Try changing some settings, and experiment!</li>
				<li>When you've finished editing your chart always remember to click <strong>Update</strong> to save your changes.</li>
			</ol>

			<h3>Displaying Charts</h3>
			<p style="font-size: 18px;">Your chart looks amazing, let's share it with the world!</p>
			<ol>
				<li>In the <strong>Chart Shortcode</strong> section copy the shortcode for the chart you want to display.</li>
				<li>Open up a post or page and paste the shortcode (while in Text mode) where you want it to appear.</li>
				<li>Update the post/page and go and view your chart on the front end of your site!</li>
				<li>Note: In the near future you'll also be able to enter a chart directly from the WordPress editor via a special text editor button.</li>
			</ol>

			<br><hr><br>

			<p style="font-size: 18px;"><a href="http://eepurl.com/c3TqZT" target="_blank">Click here</a> to signup for regular news & updates about the Power Charts plugin.</p>

			<p style="font-size: 18px;">Also, <a href="https://wpgoplugins.com/contact-us/" target="_blank">let us know</a> what new charts and features you'd like to see added. We'll do our best to implement them!</p>
		</div><!-- .wrap -->
		<?php
	}

	/**
	 * Register plugin about.
	 *
	 * @since 0.1.0
	 */
	public function add_about_page() {

		add_submenu_page(
			'edit.php?post_type=wpgo_power_charts',
			__( 'About Power Charts', 'wpgo-power-charts' ),
			__( '<span style="margin-right:1px;margin-left:-4px;color:#75b9d4;" class="dashicons dashicons-editor-help"></span>Help & Info', 'wpgo-power-charts' ),
			'manage_options',
			'wpgo-power-charts-about-page',
			array( &$this, 'render_about_page' )
		);
	}
}