<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wphelpful.com
 * @since      1.0.0
 * @last       1.0.0
 *
 * @package    WPHelpful
 * @subpackage wphelpful/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WPHelpful
 * @subpackage wphelpful/admin
 * @author     Zack Gilbert <zack@zackgilbert.com>
 */
class WPHelpful_Admin extends WPHelpful_Common {

  /**
   * The ID of this plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      string    $plugin_name    The ID of this plugin.
   */
  protected $plugin_name;

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      string    $version    The current version of this plugin.
   */
  protected $version;

  /**
   * Register the stylesheets for the admin area.
   *
   * @since    1.0.0
   */
  public function enqueue_styles() {

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in Plugin_Name_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The WPHelpful_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wphelpful-admin.css', array('wp-color-picker'), $this->version, 'all' );

  }

  /**
   * Register the JavaScript for the admin area.
   *
   * @since    1.0.0
   */
  public function enqueue_scripts() {
    global $pagenow;

    if ( !in_array( $pagenow, array( 'edit-tags.php' ) ) ) {
      $deps = array( 'jquery', 'jquery-ui-autocomplete', 'wp-color-picker', 'inline-edit-post' );
    
      wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wphelpful-admin.js', $deps, $this->version, true );

      wp_localize_script( $this->plugin_name, WPHELPFUL_PRODUCT_NAME, array( 'url' => admin_url( 'admin-ajax.php' ) ) );
    }
  }

  /**
   * Add WPHelpful specific page under the Settings submenu.
   *
   * @since  1.0.0
   */
  public function add_options_page() {
  
    $this->plugin_screen_hook_suffix = add_options_page(
      __( WPHELPFUL_PRODUCT_NAME . ' Settings', $this->plugin_name ),
      __( WPHELPFUL_PRODUCT_NAME, $this->plugin_name ),
      'manage_options',
      $this->plugin_name,
      array( $this, 'display_settings_page' )
    );
  
  }

  /**
   * Render the WPHelpful specific settings page for plugin.
   *
   * @since  1.0.0
   */
  public function display_settings_page() {
    include_once 'partials/wphelpful-admin-display.php';
  }

  /**
   * Build all the settings for plugin on the WPHelpful settings page.
   *
   * @since  1.0.0
   */
  public function register_settings() {
    // Section related to students:
    add_settings_section(
      $this->plugin_name . '_general',
      __( 'General Settings', $this->plugin_name ),
      array( $this, 'settings_section_cb' ),
      $this->plugin_name . '_general'
    );

    add_settings_field(
      $this->plugin_name . '_post_type',
      __( 'Show On Content Types', $this->plugin_name ),
      array( $this, 'settings_post_type_cb' ),
      $this->plugin_name . '_general',
      $this->plugin_name . '_general',
      array( 'label_for' => $this->plugin_name . '_post_type' )
    );
    register_setting( $this->plugin_name . '_general', $this->plugin_name . '_post_type', array('sanitize_callback' => array( $this, 'sanitize_post_types_cb' ) ) );

    add_settings_field(
      $this->plugin_name . '_template',
      __( 'Feedback Template', $this->plugin_name ),
      array( $this, 'settings_template_cb' ),
      $this->plugin_name . '_general',
      $this->plugin_name . '_general',
      array()
    );
    register_setting( $this->plugin_name . '_general', $this->plugin_name . '_template', 'sanitize_text_field' );

    add_settings_field(
      $this->plugin_name . '_show_feedback',
      __( 'Show Feedback Field', $this->plugin_name ),
      array( $this, 'settings_show_feedback_cb' ),
      $this->plugin_name . '_general',
      $this->plugin_name . '_general',
      array()
    );
    register_setting( $this->plugin_name . '_general', $this->plugin_name . '_show_feedback', 'sanitize_text_field' );

    add_settings_field(
      $this->plugin_name . '_auto_enable',
      '',
      array( $this, 'settings_auto_enable_cb' ),
      $this->plugin_name . '_general',
      $this->plugin_name . '_general',
      array()
    );
    register_setting( $this->plugin_name . '_general', $this->plugin_name . '_auto_enable', 'sanitize_text_field' );

    add_settings_field(
      $this->plugin_name . '_logged_out',
      '',
      array( $this, 'settings_logged_out_cb' ),
      $this->plugin_name . '_general',
      $this->plugin_name . '_general',
      array()
    );
    register_setting( $this->plugin_name . '_general', $this->plugin_name . '_logged_out', 'sanitize_text_field' );

    add_settings_field(
      $this->plugin_name . '_anonymous',
      '',
      array( $this, 'settings_anonymous_cb' ),
      $this->plugin_name . '_general',
      $this->plugin_name . '_general',
      array()
    );
    register_setting( $this->plugin_name . '_general', $this->plugin_name . '_anonymous', 'sanitize_text_field' );
  
    // Section related to the template:
    add_settings_section(
      $this->plugin_name . '_copy',
      __( 'Text Defaults', $this->plugin_name ),
      array( $this, 'settings_section_cb' ),
      $this->plugin_name . '_copy'
    );

    add_settings_field(
      $this->plugin_name . '_header_text',
      __( 'Header Text', $this->plugin_name ),
      array( $this, 'settings_header_text_cb' ),
      $this->plugin_name . '_copy',
      $this->plugin_name . '_copy',
      array( 'label_for' => $this->plugin_name . '_header_text' )
    );
    register_setting( $this->plugin_name . '_copy', $this->plugin_name . '_header_text', 'sanitize_text_field' );

    add_settings_field(
      $this->plugin_name . '_subheader_text',
      __( 'Subheader Text', $this->plugin_name ),
      array( $this, 'settings_subheader_text_cb' ),
      $this->plugin_name . '_copy',
      $this->plugin_name . '_copy',
      array( 'label_for' => $this->plugin_name . '_subheader_text' )
    );
    register_setting( $this->plugin_name . '_copy', $this->plugin_name . '_subheader_text', 'sanitize_text_field' );

    add_settings_field(
      $this->plugin_name . '_email_placeholder_text',
      __( 'Email Placeholder', $this->plugin_name ),
      array( $this, 'settings_email_placeholder_text_cb' ),
      $this->plugin_name . '_copy',
      $this->plugin_name . '_copy',
      array( 'label_for' => $this->plugin_name . '_email_placeholder_text' )
    );
    register_setting( $this->plugin_name . '_copy', $this->plugin_name . '_email_placeholder_text', 'sanitize_text_field' );

    add_settings_field(
      $this->plugin_name . '_placeholder_text',
      __( 'Textarea Placeholder', $this->plugin_name ),
      array( $this, 'settings_placeholder_text_cb' ),
      $this->plugin_name . '_copy',
      $this->plugin_name . '_copy',
      array( 'label_for' => $this->plugin_name . '_placeholder_text' )
    );
    register_setting( $this->plugin_name . '_copy', $this->plugin_name . '_placeholder_text', 'sanitize_text_field' );

    add_settings_field(
      $this->plugin_name . '_button_text',
      __( 'Button Text', $this->plugin_name ),
      array( $this, 'settings_button_text_cb' ),
      $this->plugin_name . '_copy',
      $this->plugin_name . '_copy',
      array( 'label_for' => $this->plugin_name . '_button_text' )
    );
    register_setting( $this->plugin_name . '_copy', $this->plugin_name . '_button_text', 'sanitize_text_field' );

    add_settings_field(
      $this->plugin_name . '_button_active_text',
      __( 'Saving Text', $this->plugin_name ),
      array( $this, 'settings_button_active_text_cb' ),
      $this->plugin_name . '_copy',
      $this->plugin_name . '_copy',
      array( 'label_for' => $this->plugin_name . '_button_active_text' )
    );
    register_setting( $this->plugin_name . '_copy', $this->plugin_name . '_button_active_text', 'sanitize_text_field' );

    add_settings_field(
      $this->plugin_name . '_thankyou_text',
      __( 'Thank You Text', $this->plugin_name ),
      array( $this, 'settings_thankyou_text_cb' ),
      $this->plugin_name . '_copy',
      $this->plugin_name . '_copy',
      array( 'label_for' => $this->plugin_name . '_thankyou_text' )
    );
    register_setting( $this->plugin_name . '_copy', $this->plugin_name . '_thankyou_text', 'sanitize_text_field' );

    add_settings_section(
      $this->plugin_name . '_colors',
      __( 'Color Defaults', $this->plugin_name ),
      array( $this, 'settings_section_cb' ),
      $this->plugin_name . '_colors'
    );

    add_settings_field(
      $this->plugin_name . '_background_color',
      __( 'Background Color', $this->plugin_name ),
      array( $this, 'settings_background_color_cb' ),
      $this->plugin_name . '_colors',
      $this->plugin_name . '_colors',
      array( 'label_for' => $this->plugin_name . '_background_color' )
    );
    register_setting( $this->plugin_name . '_colors', $this->plugin_name . '_background_color', 'sanitize_text_field' );

    add_settings_field(
      $this->plugin_name . '_rating_default_color',
      __( 'Default Rating Color', $this->plugin_name ),
      array( $this, 'settings_rating_default_color_cb' ),
      $this->plugin_name . '_colors',
      $this->plugin_name . '_colors',
      array( 'label_for' => $this->plugin_name . '_rating_default_color' )
    );
    register_setting( $this->plugin_name . '_colors', $this->plugin_name . '_rating_default_color', 'sanitize_text_field' );

    add_settings_field(
      $this->plugin_name . '_rating_selected_color',
      __( 'Selected Rating Color', $this->plugin_name ),
      array( $this, 'settings_rating_selected_color_cb' ),
      $this->plugin_name . '_colors',
      $this->plugin_name . '_colors',
      array( 'label_for' => $this->plugin_name . '_rating_selected_color' )
    );
    register_setting( $this->plugin_name . '_colors', $this->plugin_name . '_rating_selected_color', 'sanitize_text_field' );

    add_settings_field(
      $this->plugin_name . '_button_color',
      __( 'Button Color', $this->plugin_name ),
      array( $this, 'settings_button_color_cb' ),
      $this->plugin_name . '_colors',
      $this->plugin_name . '_colors',
      array( 'label_for' => $this->plugin_name . '_button_color' )
    );
    register_setting( $this->plugin_name . '_colors', $this->plugin_name . '_button_color', 'sanitize_text_field' );

    add_settings_field(
      $this->plugin_name . '_button_hover',
      __( 'Button Hover Color', $this->plugin_name ),
      array( $this, 'settings_button_hover_cb' ),
      $this->plugin_name . '_colors',
      $this->plugin_name . '_colors',
      array( 'label_for' => $this->plugin_name . '_button_hover' )
    );
    register_setting( $this->plugin_name . '_colors', $this->plugin_name . '_button_hover', 'sanitize_text_field' );

    add_settings_field(
      $this->plugin_name . '_button_text_color',
      __( 'Button Text Color', $this->plugin_name ),
      array( $this, 'settings_button_text_color_cb' ),
      $this->plugin_name . '_colors',
      $this->plugin_name . '_colors',
      array( 'label_for' => $this->plugin_name . '_button_text_color' )
    );
    register_setting( $this->plugin_name . '_colors', $this->plugin_name . '_button_text_color', 'sanitize_text_field' );

    add_settings_section(
      $this->plugin_name . '_advanced',
      __( 'Advanced Settings', $this->plugin_name ),
      array( $this, 'settings_section_cb' ),
      $this->plugin_name . '_advanced'
    );

    add_settings_field(
      $this->plugin_name . '_custom_styles',
      __( 'Custom Styles (CSS)', $this->plugin_name ),
      array( $this, 'settings_custom_styles_cb' ),
      $this->plugin_name . '_advanced',
      $this->plugin_name . '_advanced',
      array( 'label_for' => $this->plugin_name . '_custom_styles' )
    );
    register_setting( $this->plugin_name . '_advanced', $this->plugin_name . '_custom_styles', 'sanitize_text_field' );
  }

  /**
   * 
   *
   * @since  1.1.0
   */
  public function sanitize_post_types_cb( $input ) {
    return (is_array($input)) ? join(',', $input) : $input;
  }

  /**
   * 
   *
   * @since  1.0.0
   */
  public function settings_section_cb() {
  }

  /**
   * Render select menu for assigning which type of user roles should be tracked as students.
   *
   * @since  1.0.3
   */
  public function settings_post_type_cb() {
    $selected_type = get_option( $this->plugin_name . '_post_type', 'page,post' );
    if ($selected_type == 'all') {
      $selected_types = get_post_types();
    } else if ( $selected_type == 'page_post' ) {
      $selected_types = array('page', 'post');
    } else {
      $selected_types = explode( ',', $selected_type );
    }

    $disabled = false;
    $is_premium = false;

    include 'partials/wphelpful-admin-settings-post-type.php';
  }

  /**
   * Render checkbox for if should attempt to enable shortcode if not found
   *
   * @since  1.0.0
   */
  public function settings_auto_enable_cb() {
    $name = $this->plugin_name . '_auto_enable';
    $text = "Automatically enable WPHelpful for newly created content types.";
    $is_enabled = get_option( $this->plugin_name . '_auto_enable', 'false' );
    $disabled = false;
    $is_premium = false;
    include 'partials/wphelpful-admin-settings-checkbox.php';
  }

  /**
   * Render checkbox for if they want to show to only logged in users or also logged out
   *
   * @since  1.1.0
   */
  public function settings_logged_out_cb() {
    $name = $this->plugin_name . '_logged_out';
    $text = "Show WPHelpful to non-logged in users.";
    $is_enabled = get_option( $this->plugin_name . '_logged_out', 'false' );
    $disabled = false;
    $is_premium = false;

    $onchange = "jQuery('#" . $this->plugin_name . "_anonymous').prop('disabled', !this.checked);";

    include 'partials/wphelpful-admin-settings-checkbox.php';
  }

  /**
   * Render checkbox for if should allow logged out users to see feedback widget
   *
   * @since  1.1.0
   */
  public function settings_anonymous_cb() {
    $name = $this->plugin_name . '_anonymous';
    $text = "Allow anonymous submissions.";
    $is_enabled = get_option( $this->plugin_name . '_anonymous', 'false' );
    $disabled = (get_option( $this->plugin_name . '_logged_out', 'false' ) === 'false');
    $is_premium = false;

    include 'partials/wphelpful-admin-settings-checkbox.php';
  }

  /**
   * Render radio button for when to show feedback field
   *
   * @since  1.1.0
   */
  public function settings_show_feedback_cb() {
    $name = $this->plugin_name . '_show_feedback';
    $text = "Show Feedback Field:";
    $is_enabled = get_option( $this->plugin_name . '_show_feedback', 'always' );
    $disabled = false;
    $is_premium = false;

    include 'partials/wphelpful-admin-settings-show-feedback.php';
  }

  /**
   * ...
   *
   * @since  1.0.0
   */
  public function settings_template_cb() {
    $is_enabled = get_option( $this->plugin_name . '_template', 'emojis' );
    $disabled = false;
    $is_premium = false;
    include 'partials/wphelpful-admin-settings-template.php';
  }

  /**
   * Render the header text setting field.
   *
   * @since  1.0.0
   */
  public function settings_header_text_cb() {
    $name = $this->plugin_name . '_header_text';
    $text = get_option( $name, 'How helpful was this page?' );
    $class = '';
    $disabled = false;
    $is_premium = false;

    include 'partials/wphelpful-admin-settings-input.php';
  }

  /**
   * Render the subheader text setting field.
   *
   * @since  1.0.0
   */
  public function settings_subheader_text_cb() {
    $name = $this->plugin_name . '_subheader_text';
    $text = get_option( $name, 'Do you have any feedback or suggestions to improve this page?' );
    $class = '';
    $disabled = false;
    $is_premium = false;

    include 'partials/wphelpful-admin-settings-input.php';
  }

  /**
   * Render the email placeholder text setting field.
   *
   * @since  1.1.0
   */
  public function settings_email_placeholder_text_cb() {
    $name = $this->plugin_name . '_email_placeholder_text';
    $text = get_option( $name, 'Enter your email address...' );
    $class = '';
    $disabled = false;
    $is_premium = false;

    include 'partials/wphelpful-admin-settings-input.php';
  }

  /**
   * Render the placeholder text setting field.
   *
   * @since  1.0.0
   */
  public function settings_placeholder_text_cb() {
    $name = $this->plugin_name . '_placeholder_text';
    $text = get_option( $name, 'Enter your answer here...' );
    $class = '';
    $disabled = false;
    $is_premium = false;

    include 'partials/wphelpful-admin-settings-input.php';
  }

  /**
   * Render the button text setting field.
   *
   * @since  1.0.0
   */
  public function settings_button_text_cb() {
    $name = $this->plugin_name . '_button_text';
    $text = get_option( $name, 'Submit your response' );
    $class = '';
    $disabled = false;
    $is_premium = false;

    include 'partials/wphelpful-admin-settings-input.php';
  }

  /**
   * Render the background color setting field.
   *
   * @since  1.0.0
   */
  public function settings_background_color_cb() {
    $name = $this->plugin_name . '_background_color';
    $text = get_option( $name, '#f6f6f7' );
    $class = 'wpc-color-picker';
    $disabled = false;
    $is_premium = false;

    include 'partials/wphelpful-admin-settings-input.php';
  }

  /**
   * Render the rating icons color setting field.
   *
   * @since  1.0.0
   */
  public function settings_rating_color_cb() {
    $name = $this->plugin_name . '_rating_color';
    $text = get_option( $name, '#2068f0' );
    $class = 'wpc-color-picker';
    $disabled = false;
    $is_premium = false;

    include 'partials/wphelpful-admin-settings-input.php';
  }

  /**
   * Render the rating icons color setting field.
   *
   * @since  1.0.0
   */
  public function settings_rating_default_color_cb() {
    $name = $this->plugin_name . '_rating_default_color';
    $text = get_option( $name, '#ccc' );
    $class = 'wpc-color-picker';
    $disabled = false;
    $is_premium = false;

    include 'partials/wphelpful-admin-settings-input.php';
  }

  /**
   * Render the rating icons color setting field.
   *
   * @since  1.0.0
   */
  public function settings_rating_selected_color_cb() {
    $name = $this->plugin_name . '_rating_selected_color';
    $text = get_option( $name, '#2068f0' );
    $class = 'wpc-color-picker';
    $disabled = false;
    $is_premium = false;

    include 'partials/wphelpful-admin-settings-input.php';
  }

  /**
   * Render the button color setting field.
   *
   * @since  1.0.0
   */
  public function settings_button_color_cb() {
    $name = $this->plugin_name . '_button_color';
    $text = get_option( $name, '#2068f0' );
    $class = 'wpc-color-picker';
    $disabled = false;
    $is_premium = false;

    include 'partials/wphelpful-admin-settings-input.php';
  }

  /**
   * Render the button hover color setting field.
   *
   * @since  1.0.0
   */
  public function settings_button_hover_cb() {
    $name = $this->plugin_name . '_button_hover';
    $text = get_option( $name, '#1450be' );
    $class = 'wpc-color-picker';
    $disabled = false;
    $is_premium = false;

    include 'partials/wphelpful-admin-settings-input.php';
  }

  /**
   * Render the button text color setting field.
   *
   * @since  1.0.0
   */
  public function settings_button_text_color_cb() {
    $name = $this->plugin_name . '_button_text_color';
    $text = get_option( $name, '#ffffff' );
    $class = 'wpc-color-picker';
    $disabled = false;
    $is_premium = false;

    include 'partials/wphelpful-admin-settings-input.php';
  }

  /**
   * Render the button active text setting field.
   *
   * @since  1.0.0
   */
  public function settings_button_active_text_cb() {
    $name = $this->plugin_name . '_button_active_text';
    $text = get_option( $name, 'Saving...' );
    $class = '';
    $disabled = false;
    $is_premium = false;

    include 'partials/wphelpful-admin-settings-input.php';
  }

  /**
   * Render the button active text setting field.
   *
   * @since  1.0.0
   */
  public function settings_thankyou_text_cb() {
    $name = $this->plugin_name . '_thankyou_text';
    $text = get_option( $name, 'Thanks for your feedback!' );
    $class = '';
    $disabled = false;
    $is_premium = false;

    include 'partials/wphelpful-admin-settings-input.php';
  }

  /**
   * Render textarea for custom styles.
   *
   * @since  1.0.0
   */
  public function settings_custom_styles_cb() {
    $name = $this->plugin_name . '_custom_styles';
    $default = '';
    $text = get_option( $name, $default );
    if ( empty( $text ) ) {
      $text = '';
    }
    $text = str_replace("} ", "}\n", $text);
    $disabled = false;
    $is_premium = false;

    include 'partials/wphelpful-admin-settings-textarea.php';
  }

  /* END SETTINGS PAGE HELPERS */

  /**
   * Render the meta box for this plugin enabling completion functionality
   *
   * @since  1.0.0
   */
  public function add_feedback_metabox() {
    $screens = $this->get_enabled_post_types();

    foreach ( $screens as $screen ) {
      add_meta_box(
        'wphelpful',                                 // Unique ID
        __( 'WPHelpful', $this->plugin_name ),        // Box title
        array( $this, 'add_feedback_metabox_cb' ),  // Content callback
        $screen                                        // post type
      );
    }
  }

  /**
   * Callback which renders the actual html for completable metabox. Includes enabling completability and redirect url.
   *
   * @since  1.0.0
   * @last   2.0.0
   */
  public function add_feedback_metabox_cb( $post ) {
    // get the variables we need to build the form:
    $feedback = false;
    $post_meta = get_post_meta( $post->ID, 'wphelpful', true);

    if ($post_meta) {
      $feedback = true;
      $post_meta = json_decode($post_meta, true);
    } else if ($post->post_status == 'auto-draft') {
      $feedback = get_option( $this->plugin_name . '_auto_enable', 'true' ) === 'true';
    }
    // include a nonce to ensure we can save:
    wp_nonce_field( $this->plugin_name, 'wphelpful_nonce' );
    include 'partials/wphelpful-admin-metabox.php';
  }

  /**
   * Add options to the bulk menu for posts and pages.
   *
   * @since  1.0.0
   */
  public function add_bulk_actions() {
    global $post_type;
 
    if ( in_array( $post_type, $this->get_enabled_post_types() ) ) {
      ?>
      <script defer type="text/javascript">
        jQuery(document).ready(function() {
          jQuery('<option>').val('wphelpful').text("<?php _e('Enable WPHelpful', $this->plugin_name)?>").appendTo("select[name='action'],select[name='action2']");        
        });
      </script>
      <?php
    }
  }

  /**
   * Save script for saving an individual post/page, enabling it to show WPHelpful.
   *
   * @since  1.0.0
   * @last   1.0.0
   */
  public function save_feedback( $post_id ) {
    global $wpdb;

    if ( isset( $_POST['wphelpful_nonce'] ) && isset( $_POST['post_type'] ) && isset( $_POST['wphelpful'] ) && isset( $_POST['wphelpful']['feedback'] ) ) {

      if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        //echo '<!-- Autosave -->';
        return;
      } // end if

      // Make sure the user has permissions to posts and pages
      if ( ! in_array( $_POST['post_type'], $this->get_enabled_post_types() ) ) {
        // echo '<!-- Post type isn\'t allowed to be marked as completable -->';
        return;
      }

      $is_enabled = $_POST['wphelpful']['feedback'];
      
      if ($is_enabled == 'true') {

        $post_meta = array('enabled' => 'true');
        update_post_meta( $post_id, 'wphelpful', json_encode( $post_meta, JSON_UNESCAPED_UNICODE ) );
        
      } else {

        // If the value exists, delete it.
        delete_post_meta( $post_id, 'wphelpful' );
      
      }

      wp_cache_flush();

    }
  }

  /**
   * Save script for the bulk action that marks multiple pages/posts as enabled for feedback.
   *
   * @since  1.0.0
   * @last   1.0.0
   */
  public function save_bulk_completable() {
    global $typenow;
    $post_type = $typenow;

    if ( in_array( $post_type, $this->get_enabled_post_types() ) && isset($_REQUEST['post']) ) {
      if ( (($_REQUEST['action'] == 'wphelpful') || ($_REQUEST['action2'] == 'wphelpful')) ) {
        // security check
        check_admin_referer( 'bulk-posts' );

        $action = ($_REQUEST['action'] == '-1') ? $_REQUEST['action2'] : $_REQUEST['action'];
        
        // make sure ids are submitted.  depending on the resource type, this may be 'media' or 'ids'
        if ( isset($_REQUEST['post'] ) ) {
          $post_ids = array_map( 'intval', $_REQUEST['post'] );
        }
        
        if ( empty( $post_ids ) ) return;

        // this is based on wp-admin/edit.php
        $sendback = remove_query_arg( array('exported', 'untrashed', 'deleted', 'ids'), wp_get_referer() );
        if ( ! $sendback )
          $sendback = admin_url( "edit.php?post_type=$post_type" );     

        // do the marking as complete!
        $marked = 0;
        foreach ( $post_ids as $post_id ) {
          $post_meta = get_post_meta( $post_id, 'wphelpful', true );

          if ( ! $post_meta ) {
            // Enable the post because it wasn't previously.
            $post_meta = array('enabled' => 'true');
            update_post_meta( $post_id, 'wphelpful', json_encode( $post_meta, JSON_UNESCAPED_UNICODE ) );
            $marked++;
          } else {
            // Already enabled... no need to do anything...
          }
        }

        $sendback = add_query_arg( array('wphelpful' => $marked, 'ids' => join(',', $post_ids) ), $sendback );
        $sendback = remove_query_arg( array('action', 'action2', 'tags_input', 'post_author', 'comment_status', 'ping_status', '_status',  'post', 'bulk_edit', 'post_view'), $sendback );

        wp_cache_flush();

        wp_redirect( $sendback );
        exit();
      }
    }
  }

  /**
   * Add a notice message for completed bulk actions.
   *
   * @since  1.0.0
   */
  public function show_bulk_action_notice() {
    global $post_type, $pagenow;
 
    if ( $pagenow == 'edit.php' && in_array( $post_type, $this->get_enabled_post_types() ) && isset($_REQUEST['wphelpful']) && (int) $_REQUEST['wphelpful']) {
      $message = sprintf( _n( 'WPHelpful has been enabled for this post.', 'WPHelpful enabled on %s posts.', $_REQUEST['wphelpful'] ), number_format_i18n( $_REQUEST['wphelpful'] ) );
      echo "<div class=\"updated\"><p>{$message}</p></div>";
    }
  }

  /**
   * Add the new custom column header, "Feedback" to pages and posts edit.php page.
   *
   * @since  1.0.0
   */
  public function add_custom_column_header( $columns ) {
    global $post_type;

    if (!$post_type) $post_type = $_POST['post_type'];

    if ( in_array( $post_type, $this->get_enabled_post_types() ) ) {
      $columns = array_merge( $columns, array( 'wphelpful' => __( 'Feedback', $this->plugin_name ) ) );
    }

    return $columns;
  }

  /**
   * Add the values for each post/page of the new custom "Feedback" column.
   * If post/page isn't enabled to be completed, it shows — in column.
   *
   * @since  1.0.0
   * @last   1.0.0
   */
  public function add_custom_column_value( $column_name, $post_id ) {
    if ( $column_name == 'wphelpful' ) {
      if ( $this->post_is_enabled( $post_id ) ) {
        $post_feedback = $this->get_post_feedback( $post_id, true );
        $rating_type = 'yes/no';

        if ( count($post_feedback) > 0 ) {
          $post_total_rating = 0;
          foreach( $post_feedback as $feedback ) {
            if ( $feedback['rating'] == 'yes' ) {
              $post_total_rating += 1;
            } else if ( is_numeric( $feedback['rating'] ) ) {
              $post_total_rating += $feedback['rating'];
              $rating_type = 'int';
            }
          }

          if ( $rating_type == 'yes/no' ) {
            $post_rating = ( ( ( $post_total_rating / count($post_feedback) ) * 100 ) . "% helpful");
          } else {
            $post_rating = "Average: " . ( $post_total_rating / count($post_feedback) );
          }

        } else {
          $post_rating = "--";
        }

        include 'partials/wphelpful-admin-post-feedback-column.php';
      } else {
        echo '<abbr title="Make sure to enable WPHelpful on this post.">Not Enabled</abbr>';
      }
    }
  }

  /**
   * 
   *
   * @since  1.0.0
   */
  public function add_post_feedback_page() {
    add_submenu_page( 
      null, 
      __( 'Post Feedback', $this->plugin_name ), 
      __( 'Post Feedback', $this->plugin_name ), 
      'manage_options', 
      'wphelpful-posts', 
      array( $this, 'render_post_feedback_page' )
    );
  }

  /**
   * 
   *
   * @since  1.4.0
   * @last   2.0.0
   */
  public function render_post_feedback_page() {
    global $wpdb;

    if ( ! current_user_can( 'manage_options' ) )  {
      wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    if ( !$_GET['post_id'] || !is_numeric( $_GET['post_id'] ) ) {
      wp_die( __( 'Invalid post supplied.' ) );
    }
    // Get post info:
    $post_id = intval( $_GET['post_id'] );
    $post = get_post($post_id);

    if ( !$post ) {
      wp_die( __( 'Post not found.' ) );
    }

    $post_feedback = $this->get_post_feedback($post_id);

    include_once 'partials/wphelpful-admin-post-feedback.php';
  }

  /**
   * Add custom field for quick edit of posts and pages.
   *
   * @since  1.0.0
   */
  public function add_custom_quick_edit( $column_name, $post_type ) {
    if ( in_array( $post_type, $this->get_enabled_post_types() ) ) {
      include 'partials/wphelpful-admin-quickedit.php';
    }
  }

  /**
   * Add the new custom column header, "Feedback" to users page.
   *
   * @since  1.0.0
   * @last   1.0.0
   */
  public function add_user_column_header( $columns ) {
    return array_merge( $columns, array( 'wphelpful' => __( 'Feedback', $this->plugin_name) ));
  }

  /**
   * Add the values for each user of the custom "Feedback" column.
   * It'll show the number of lessons given feedback on.
   *
   * @since  1.0.0
   * @last   1.0.0
   */
  public function add_user_column_value( $value, $column_name, $user_id ) {
    if ( $column_name == 'wphelpful' ) {
      $user = get_userdata( $user_id );

      $total_posts = $this->get_enabled_posts();
      $user_posts = $this->get_user_feedback( $user_id, true );

      ob_start();
      include 'partials/wphelpful-admin-user-feedback-column.php';
      return ob_get_clean();
    } else {
      return $value;
    }
  }

  /**
   * 
   *
   * @since  1.0.0
   */
  public function add_user_feedback_page() {
    add_submenu_page( 
      null, 
      __( 'User Feedback', $this->plugin_name ), 
      __( 'User Feedback', $this->plugin_name ), 
      'manage_options', 
      'wphelpful-users', 
      array( $this, 'render_user_feedback_page' )
    );
  }

  /**
   * 
   *
   * @since  1.0.0
   * @last   1.0.0
   */
  public function render_user_feedback_page() {
    if ( !current_user_can( 'manage_options' ) )  {
      wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    if ( !$_GET['user_id'] || !is_numeric( $_GET['user_id'] ) ) {
      wp_die( __( 'Invalid user supplied.' ) );
    }
    
    $user_id = intval( $_GET['user_id'] );
    $user = get_userdata( $user_id );

    if ( !$user ) {
      wp_die( __( 'User not found.' ) );
    }

    $user_feedback = $this->get_user_feedback($user_id);

    include_once 'partials/wphelpful-admin-user-feedback.php';
  }

  /**
   * 
   *
   * @since  1.1.0
   * @last   1.1.0
   */
  public function add_site_feedback_page() {
    add_menu_page( 
      WPHELPFUL_PRODUCT_NAME, 
      __( WPHELPFUL_PRODUCT_NAME, $this->plugin_name ), 
      'manage_options', 
      $this->plugin_name . '-feedback', 
      array( $this, 'render_site_feedback_page' ),
      'dashicons-star-filled',
      50
    );

    add_submenu_page( 
      $this->plugin_name . '-feedback', 
      __( 'Sitewide Feedback', $this->plugin_name ), 
      __( 'Sitewide Feedback', $this->plugin_name ), 
      'manage_options', 
      $this->plugin_name . '-feedback', 
      array( $this, 'render_site_feedback_page' )
    );

    add_submenu_page( 
      $this->plugin_name . '-feedback', 
      __( 'General Settings', $this->plugin_name ), 
      __( 'General Settings', $this->plugin_name ), 
      'manage_options', 
      $this->plugin_name . '-settings', 
      array( $this, 'render_feedback_settings_page' )
    );
  }

  /**
   * 
   *
   * @since  1.1.0
   * @last   1.1.0
   */
  public function render_site_feedback_page() {
    if ( !current_user_can( 'manage_options' ) )  {
      wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }

    // TODO: paginate?
    $all_feedback = $this->get_feedback();

    include_once 'partials/wphelpful-admin-site-feedback.php';
  }

  /**
   * 
   *
   * @since  1.1.0
   * @last   1.1.0
   */
  public function render_feedback_settings_page() {
    echo "<p><em>loading...</em></p><script type='text/javascript'> window.location = 'options-general.php?page=" . $this->plugin_name . "'; </script>";
    //wp_redirect('options-general.php?page=' . $this->plugin_name);
    //exit;
  }

  /**
   * Delete feedback stored in database.
   *
   * @since  1.1.0
   * @last   1.1.0
   */
  public function delete_feedback() {
    $feedback_id = intval($_REQUEST['feedback_id']);

    $feedback = get_metadata_by_mid('user', $feedback_id);
    $post_id = str_replace($this->plugin_name . '-post-', '', $feedback->meta_key);

    $saved = delete_metadata_by_mid('user', $feedback_id);
    $this->break_caches($feedback->user_id, $post_id);

    //wp_redirect( $_SERVER['HTTP_REFERER'] );
    $response = json_encode( $saved, JSON_UNESCAPED_UNICODE );
    echo $response;
    exit();
  }

}
