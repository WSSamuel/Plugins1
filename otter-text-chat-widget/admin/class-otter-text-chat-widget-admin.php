<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ottertext.com
 * @since      1.0.0
 *
 * @package    otter_text_chat_widget
 * @subpackage otter_text_chat_widget/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    otter_text_chat_widget
 * @subpackage otter_text_chat_widget/admin
 * @author     Otter Text <info@ottertext.com>
 */
class Otter_Text_Chat_Widget_Admin {

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
	 * The capability required to change the chat widget ID.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $use_capability;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name    = $plugin_name;
		$this->version        = $version;
		$this->use_capability = 'manage_options';

	}

	/**
	 * Check if the Chat Widget ID is set and if not display an alert
	 *
	 * @since    1.0.0
	 */
	public function admin_notice() {
		if ( current_user_can( $this->use_capability ) ) {
			$options        = get_option( 'otter_text_settings' );
			$chat_widget_id = isset( $options['chat_widget_id'] ) ? $options['chat_widget_id'] : '';
			if ( empty( $chat_widget_id ) ) {
				echo '<div class="notice notice-error"><p>';
				echo esc_html( __( 'The Otter Text Chat Widget is not being displayed.', 'otter_text_chat_widget' ) );
				$link_text        = __( 'Click here to set the chat widget ID.', 'otter_text_chat_widget' );
				$options_page_url = menu_page_url( 'otter_text_settings', false );
				echo '<a href="' . esc_html( $options_page_url ) . '">' . esc_html( $link_text ) . '</a>.';
				echo '</p></div>';
			}
		}
	}

	/**
	 * Add the new page to the settings section
	 *
	 * @since    1.0.0
	 */
	public function admin_menu() {
		add_options_page(
			'Otter Text',
			'Otter Text',
			$this->use_capability,
			'otter_text_settings',
			array( $this, 'admin_menu_otter_text_settings_html' ),
			1
		);
	}

	/**
	 * Outputs the page for the admin menu
	 *
	 * @since    1.0.0
	 */
	public function admin_menu_otter_text_settings_html() {
		echo '<h1>' . esc_html( __( 'Otter Text Settings', 'otter_text_chat_widget' ) ) . '</h1>';
		echo '<form action="options.php" method="post">';
		settings_fields( 'otter_text_settings' );
		do_settings_sections( 'otter_text_settings' );
		echo '<input name="submit" class="button button-primary" type="submit" ';
		echo 'value="' . esc_attr_e( 'Save', 'otter_text_chat_widget' ) . '" />';
		echo '</form>';
	}

	/**
	 * Registers settings for otter settings page
	 *
	 * @since    1.0.0
	 */
	public function otter_text_register_settings() {
		register_setting(
			'otter_text_settings',
			'otter_text_settings',
			array(
				'type'              => 'string',
				'sanitize_callback' => array( $this, 'otter_text_chat_widget_id_validate' ),
				'default'           => null,
			)
		);
		add_settings_section(
			'otter_text_chat_widget',
			__( 'Chat Widget Settings', 'otter_text_chat_widget' ),
			'',
			'otter_text_settings'
		);
		add_settings_field(
			'otter_text_setting_chat_wi ',
			__( 'Chat Widget ID', 'otter_text_chat_widget' ),
			array( $this, 'otter_text_setting_chat_widget_id_setting' ),
			'otter_text_settings',
			'otter_text_chat_widget'
		);
	}

	/**
	 * Sanitizes the value to only letters and numbers
	 *
	 * @since    1.0.0
	 * @param string|array $input The value to be sanitized.
	 *
	 * @return array
	 */
	public function otter_text_chat_widget_id_validate( $input ) {
		$new_input['chat_widget_id'] = trim( $input['chat_widget_id'] );
		if ( ! preg_match( '/^^[a-zA-Z\d]+$/i', $new_input['chat_widget_id'] ) ) {
			$new_input['chat_widget_id'] = '';
		}
		return $new_input;
	}

	/**
	 * Displays the field for the chat widget ID
	 *
	 * @since    1.0.0
	 */
	public function otter_text_setting_chat_widget_id_setting() {
		$options       = get_option( 'otter_text_settings' );
		$current_value = isset( $options['chat_widget_id'] ) ? $options['chat_widget_id'] : '';

		echo '<input id="otter_text_setting_chat_widget_id" name="otter_text_settings[chat_widget_id]" ';
		echo 'type="text" value="' . esc_attr( $current_value ) . '" />';
	}


}
