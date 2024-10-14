<?php
/*
Plugin Name: Power Charts Lite
Plugin URI: http://wordpress.org/plugins/power-charts-lite/
Description: Add responsive charts and graphs in WordPress using the advanced D3.js visualization library.
Version: 0.1.0
Author: David Gwyer
Author URI: http://www.wpgoplugins.com
*/

/*  Copyright 2017 David Gwyer (email : david@wpgoplugins.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* Bootstrap class for Power Charts. */
class WPGO_Power_Charts {

	protected $module_roots;

	/* Main class constructor. */
	public function __construct($module_roots) {

		$this->module_roots = $module_roots;

		add_action( 'plugins_loaded', array( &$this, 'load_supported_features' ) );
		add_action( 'plugins_loaded', array( &$this, 'localize_plugin' ) );
		add_filter( 'plugin_action_links', array( &$this, 'plugin_get_started_link'), 10, 2 );
	}

	/* Check for specific CPT used in the current WPGO theme. */
	public function load_supported_features() {

		$root = $this->module_roots['dir'];

		// Power Charts CPT
		require_once( $root . 'classes/power-charts-cpt.php' );
		new WPGO_Power_Charts_CPT($this->module_roots);

		// Power Charts enqueue functions
		require_once( $root . 'classes/power-charts-enqueue-scripts.php' );
		new WPGO_Power_Charts_Enqueue_Scripts($this->module_roots);

		// Power Charts data CPT
		//require_once( $root . 'classes/power-charts-data-cpt.php' );
		//new WPGO_Power_Charts_Data_CPT($this->module_roots);

		// Power Charts about page
		require_once( $root . 'classes/power-charts-about.php' );
		new WPGO_Power_Charts_About_Page($this->module_roots);

		// Power Charts Shortcodes
		require_once( $root . 'classes/power-charts-shortcodes.php' );
		new WPGO_Power_Charts_Shortcodes($this->module_roots);

		// Power Charts Settings
		//require_once( $root . 'classes/power-charts-settings.php' );
		//new WPGO_Power_Charts_Options();

		// Power Charts Settings
		require_once( $root . 'classes/power-charts-builder.php' );

		// Allow shortcodes to be used in widgets. These callbacks are WordPress functions.
		add_filter( 'widget_text', 'shortcode_unautop' );
		add_filter( 'widget_text', 'do_shortcode' );
	}

	/**
	 * Add Plugin localization support.
	 */
	public function localize_plugin() {
		load_plugin_textdomain( 'power-charts', false, plugin_basename( $this->module_roots['dir'] ) . '/languages' );
	}

	/* Display a 'Get Started' link on the main Plugins page. */
	public function plugin_get_started_link( $links, $file ) {

		if ( $file == plugin_basename( __FILE__ ) ) {
			$new_links = '<a href="' . get_admin_url() . 'edit.php?post_type=wpgo_power_charts&page=wpgo-power-charts-about-page">' . __( 'Getting Started' ) . '</a>';
			/* Make the 'Settings' link appear first. */
			array_unshift( $links, $new_links );
		}

		/*if ( $file == plugin_basename( __FILE__ ) ) {
			$pccf_links = '<a style="color:#60a559;" href="https://powerchartswp.com/" target="_blank" title="Go PRO - 100% money back guarantee"><span style="width:18px;height:18px;font-size:18px;" class="dashicons dashicons-flag"></span></a>';
			array_push( $links, $pccf_links );
		}*/

		return $links;
	}
} /* End class definition */

$module_roots = array(
	'dir' => plugin_dir_path( __FILE__ ),
	'uri' => plugins_url( '', __FILE__ ),
	'__FILE__' => __FILE__
);
new WPGO_Power_Charts( $module_roots );
