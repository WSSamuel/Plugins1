<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://themeegg.com
 * @since      1.0.0
 *
 * @package    Weather_Forecast
 * @subpackage Weather_Forecast/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Weather_Forecast
 * @subpackage Weather_Forecast/public
 * @author     ThemeEgg Team <themeeggofficial@gmail.com>
 */
class Weather_Forecast_Public {

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
		 * defined in Weather_Forecast_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Weather_Forecast_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/weather-forecast-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Add all Widgets
	 * @since    1.0.0
	 * @access   public
	 */
	public function add_widgets(){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-weather-forecast-widget.php';
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
		 * defined in Weather_Forecast_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Weather_Forecast_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'jquery.simpleWeather', plugin_dir_url( __FILE__ ) . 'js/jquery.simpleWeather.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/weather-forecast-public.js', array( 'jquery' ), $this->version, false );

	}

}
