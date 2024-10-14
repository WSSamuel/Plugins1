<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://ottertext.com
 * @since      1.0.0
 *
 * @package    otter_text_chat_widget
 * @subpackage otter_text_chat_widget/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    otter_text_chat_widget
 * @subpackage otter_text_chat_widget/public
 * @author     Otter Text <info@ottertext.com>
 */
class Otter_Text_Chat_Widget_Public {

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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}


	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script(
			$this->plugin_name,
			'https://app.ottertext.com/js/chatwidget.js',
			array(),
			$this->version,
			true
		);
	}

	/**
	 * Register the function that echos the code for the chat
	 *
	 * @since    1.0.0
	 */
	public function echo_footer_script() {
		$options        = get_option( 'otter_text_settings' );
		$chat_widget_id = isset( $options['chat_widget_id'] ) ? $options['chat_widget_id'] : '';
		echo '<div id="otterWebsiteChatWidget" data-client="';
		echo esc_html( $chat_widget_id );
		echo '"></div>';
	}

}

