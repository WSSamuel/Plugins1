<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://roadmap.space
 * @since      1.0.0
 *
 * @package    Roadmap_Space
 * @subpackage Roadmap_Space/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Roadmap_Space
 * @subpackage Roadmap_Space/public
 * @author     Roadmap <support@roadmap.space>
 */
class Roadmap_Space_Public {

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
	public function enqueue_styles() {}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		$roadmap_id = get_option("{$this->plugin_name}_roadmap_id");
		$feedback = get_option("{$this->plugin_name}_feedback_widget");
		$should_enqueue = false;

		switch ($feedback) {
			case "all":
				if (!empty($roadmap_id)) {
					$should_enqueue = true;
				}
			break;
			case "logged-in":
				if (is_user_logged_in() && !empty($roadmap_id)) {
					$should_enqueue = true;
				}
				break;
			case "none":
				break;
		}

		if ($should_enqueue) {
			$user = wp_get_current_user();
			wp_enqueue_script( "{$this->plugin_name}-feedback", 'https://cdn.roadmap.space/widget/feedback.js' );
			wp_add_inline_script( "{$this->plugin_name}-feedback", "
				window.onload = function() {
					RoadmapSettings.load({
						id: \"{$roadmap_id}\",
						email: \"{$user->user_email}\",
						first: \"{$user->first_name}\",
						last: \"{$user->last_name}\"
					});
				};
			");
		}
	}

	public function register_shortcodes() {
		add_shortcode( 'roadmap', array( $this, 'roadmap_shortcode' ) );
	}

	public function roadmap_shortcode() {
		$roadmap_id = get_option("{$this->plugin_name}_roadmap_id");

		$html = sprintf(
			"<p><em>%s</em></p>",
			__( 'No Roadmap ID is configured in your settings. Add it to show your Roadmap here!', 'roadmap-space' )
		);

		if ( !empty($roadmap_id) ) {
			$user = wp_get_current_user();

			$html = "<div id=\"roadmap-container\"></div>";
			$html .= "<script type=\"text/javascript\"
					src=\"https://cdn.roadmap.space/widget/roadmap.js\"
					id=\"public-roadmap\"
					data-id=\"{$roadmap_id}\"
					data-embedded=\"true\"
					data-container=\"roadmap-container\"
					data-email=\"{$user->user_email}\"
					data-first=\"{$user->first_name}\"
					data-last=\"{$user->last_name}\"
				>
				</script>
			";
		}

		return $html;
	}
}
