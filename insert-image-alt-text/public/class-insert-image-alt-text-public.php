<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://jonmendoza.ph
 * @since      1.0.0
 *
 * @package    Insert_Image_Alt_Text
 * @subpackage Insert_Image_Alt_Text/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Insert_Image_Alt_Text
 * @subpackage Insert_Image_Alt_Text/public
 * @author     Jon Vincent Mendoza <jonazodnem26@gmail.com>
 */
class Insert_Image_Alt_Text_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Insert_Image_Alt_Text_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Insert_Image_Alt_Text_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/insert-image-alt-text-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Insert_Image_Alt_Text_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Insert_Image_Alt_Text_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/insert-image-alt-text-public.js', array( 'jquery' ), $this->version, false );

	}

	public function see_no_alt_text_button(){
		echo '<div class="iiat-alt_text_button"><button class="iiat-check-alt-text" onclick="show_image_alt_text()" type="button">See Images without Alt</button></div>';

		echo '<div class="iiat-no-alt-here" style="display: none" id="div-no-alt"><ol id="put-all-no-alt-here"></ol></div>';
	}

}
