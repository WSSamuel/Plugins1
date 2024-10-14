<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wphelpful.com
 * @since      1.0.0
 *
 * @package    WPHelpful
 * @subpackage WPHelpful/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WPHelpful
 * @subpackage WPHelpful/public
 * @author     Zack Gilbert <zack@zackgilbert.com>
 */
class WPHelpful_Public extends WPHelpful_Common {

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
   * Register the stylesheets for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_styles() {
    wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wphelpful-public.css', array(), $this->version, 'all' );
  }

  /**
   * Register the JavaScript for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_scripts() {
    wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wphelpful-public.js', array( 'jquery' ), $this->version, true );

    $wphelpful_nonce = wp_create_nonce( 'wphelpful' );
    wp_localize_script( $this->plugin_name, 'wphelpful', array( 
      'ajax_url' => admin_url( 'admin-ajax.php' ),
      'nonce' => $wphelpful_nonce
    ) );
  }

  /**
   * Add custom completion code to the end of post and page content
   *
   * @since    1.0.0
   */
  public function append_custom_styles() {
    $style_default = '';
    $wrapper_styles = '';
    $background_color = get_option( $this->plugin_name . '_background_color', '#f6f6f7' );
    if ( isset( $background_color ) && !empty( $background_color ) ) {
      $wrapper_styles = ".wph.wph-wrapper { background: $background_color; }";
    } else {
      $wrapper_styles = ".wph.wph-wrapper { background: transparent; padding: 0; }";      
    }

    $rating_default_color = get_option( $this->plugin_name . '_rating_default_color', '#ccc' );
    $rating_selected_color = get_option( $this->plugin_name . '_rating_selected_color', '#2068f0' );
    $button_color = get_option( $this->plugin_name . '_button_color', '#2068f0' );
    $button_hover = get_option( $this->plugin_name . '_button_hover', '#1450be' );
    $button_text_color = get_option( $this->plugin_name . '_button_text_color', '#ffffff' );
    $custom_styles = get_option( $this->plugin_name . '_custom_styles', $style_default );

    echo "<style type=\"text/css\"> $wrapper_styles .wph .wph-button, .wph .wph-button[disabled] { background: $button_color; color: $button_text_color; } .wph .wph-button:hover { background: $button_hover; } .successful .wph-p a { color: $button_color; } .svg-emoji, .svg-stars { fill: $rating_default_color; } .wph-simple-label { border: 2px solid $rating_default_color; } .wph-simple input:checked + label { border: 2px solid $rating_selected_color; color: $rating_selected_color; } .wph-emoji input:checked + svg.svg-emoji { fill: $rating_selected_color; } .wph-stars input:checked ~ label .svg-stars { fill: $rating_selected_color; } $custom_styles </style>";
  }

  /**
   * Add defer to scripts.
   *
   * @since    1.0.0
   */
  public function append_script_defer( $tag, $handle ) {
    if ( 'WPHelpful' !== $handle )
      return $tag;
    return str_replace( ' src', ' defer="defer" src', $tag );
  }

  /**
   * Add custom completion code to the end of post and page content
   *
   * @since    1.0.0
   * @last     1.0.0
   */
  public function append_completion_code($content) {
    // Only append when we are on a single page.
    if ( !is_singular() || ! is_main_query() ) {
      return $content;
    }

    $post_type = get_post_type();
    $post_id = get_the_ID();

    // Don't append if we aren't suppose to complete this type of post:
    if ( ! in_array( $post_type, $this->get_enabled_post_types() ) ) {
      return $content;
    }

    // See if this post is actually completable:
    if ( ! $this->post_is_enabled( $post_id ) ) {
      return $content;
    }

    $post = get_post($post_id);
    $post_content = $post->post_content;
    $all_post_meta_data = get_post_meta( $post_id );
    foreach ($all_post_meta_data as $key => $value) {
      $post_content .= var_export($key, true) . "\n" . var_export( $value, true ) . "\n\n";
    }

    // Only append to body if we can't find any record of the button anywhere on the content:
    // NOTE: This doesn't fix the issue with OptimizePress... but it should help. Check current saved content:
    if ( ( strpos( $post_content, '[wphelpful' ) === false ) ) {
      if ( ( strpos( $content, '[wphelpful' ) === false ) ) {
        $content .= "\n\n[wphelpful]";
      }
    }

    return $content;
  }


/**
   * Register the shortcode for [complete_button] for the public-facing side of the site.
   *
   * @since    1.0.0
   * @last     1.0.0
   */
  public function shortcode_wphelpful_cb($atts, $content = null, $tag = '') {
    $user_logged_in = is_user_logged_in();
    if ( !$user_logged_in ) {
      $logged_out = get_option($this->plugin_name . '_logged_out', 'false');
      if ( $logged_out === 'false' ) return false;
    }

    if ( isset( $atts['id'] ) && !empty( $atts['id'] ) ) {
      $post_id = $atts['id'];
    } else if ( isset( $atts['post_id'] ) && !empty( $atts['post_id'] ) ) {
      $post_id = $atts['post_id'];
    } else if ( isset( $atts['post'] ) && !empty( $atts['post'] ) ) {
      $post_id = $atts['post'];
    } else {
      $post_id = get_the_ID();
    }

    if ( ! in_array( get_post_type( $post_id ), $this->get_enabled_post_types() ) ) return;
    if ( ! $this->post_is_enabled( $post_id ) ) return;

    $template = get_option($this->plugin_name . '_template', 'emojis');
    if ( isset( $atts['template'] ) && !empty( $atts['template'] ) ) {
      if ( $atts['template'] === 'emoji' ) $atts['template'] = 'emojis';
      if ( $atts['template'] === 'star' ) $atts['template'] = 'stars';
      if ( is_file( dirname(__FILE__) . '/partials/wphelpful-templates-' . $atts['template'] . '.php' ) ) {
        $template = $atts['template'];
      } else {
        error_log($this->plugin_name . " line " . __LINE__ . ": (Warning) Unknown template type -- " . $atts['template'] . " -- loading default template type ($template).");
      }
    }
    $show_feedback = get_option($this->plugin_name . '_show_feedback', 'always');
    
    $uid = uniqid();

    $header_text = get_option( $this->plugin_name . '_header_text', 'How helpful was this page?' );
    if ( isset( $atts['header'] ) && !empty( $atts['header'] ) )
      $header_text = $atts['header'];
    
    $subheader_text = get_option( $this->plugin_name . '_subheader_text', 'Do you have any feedback or suggestions to improve this page?' );
    if ( isset( $atts['subheader'] ) && !empty( $atts['subheader'] ) )
      $subheader_text = $atts['subheader'];
    
    $email_placeholder_text = get_option( $this->plugin_name . '_email_placeholder_text', 'Enter your email address...' );
    if ( isset( $atts['email_placeholder'] ) && !empty( $atts['email_placeholder'] ) )
      $placeholder_text = $atts['email_placeholder'];
    
    $placeholder_text = get_option( $this->plugin_name . '_placeholder_text', 'Enter your answer here...' );
    if ( isset( $atts['placeholder'] ) && !empty( $atts['placeholder'] ) )
      $placeholder_text = $atts['placeholder'];
    
    $button_text = get_option( $this->plugin_name . '_button_text', 'Submit your response' );
    if ( isset( $atts['button'] ) && !empty( $atts['button'] ) )
      $button_text = $atts['button'];
    
    $button_active_text = get_option( $this->plugin_name . '_button_active_text', 'Saving...' );
    if ( isset( $atts['save'] ) && !empty( $atts['save'] ) )
      $button_active_text = $atts['save'];
    
    // Load existing feedback if it exists:
    $previous_feedback = $this->get_user_post_feedback($post_id);
    $rating = ( $previous_feedback ) ? $previous_feedback['rating'] : false;
    $allow_anonymous = get_option($this->plugin_name . '_anonymous', 'false');

    ob_start();
    include 'partials/wphelpful-templates-' . $template  . '.php';
    return ob_get_clean();
  }

  /**
   * Handle saving feedback.
   *
   * @since    1.0.0
   * @last     1.0.0
   */
  public function save_feedback() {
    $user_logged_in = is_user_logged_in();
    
    if ( ! isset( $_REQUEST['post_id'] ) ) wp_safe_redirect( get_home_url() );
    //check_ajax_referer( 'wphelpful' );
    $post_id = intval( $_REQUEST['post_id'] );
    $user_agent = ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) ? $_SERVER['HTTP_USER_AGENT'] : '';
    if ( ! isset( $_REQUEST['rating'] ) ) $_REQUEST['rating'] = '-';
    if ( ! isset( $_REQUEST['feedback'] ) ) $_REQUEST['feedback'] = '';

    $ip = $_SERVER['REMOTE_ADDR'];
    if ( !empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
      $ip = $_SERVER['HTTP_CLIENT_IP']; // ip from share internet
    } else if ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; // ip pass from proxy
    }

    $post_feedback = array(
      'rating' => sanitize_text_field( $_REQUEST['rating'] ),
      'feedback' => sanitize_text_field( $_REQUEST['feedback'] ),
      'local_time' => ( ( isset( $_REQUEST['local_time'] ) ) ? sanitize_text_field( $_REQUEST['local_time'] ) : current_time( 'mysql' ) ),
      'gmt_time' => current_time( 'mysql', 1 ),
      'ua' => $user_agent, 
      'ip' => $ip
    );
    if ( isset( $_REQUEST['email'] ) && !empty( $_REQUEST['email'] ) ) {
      $post_feedback['email'] = sanitize_email($_REQUEST['email']);
    }
    // Save to user table:
    $saved = $this->save_user_post_feedback( $post_feedback, $post_id );

    // TODO: provide error message is something goes wrong.
    // Get confirmation / thank you template to return...
    $updates_to_sendback = array( 
      ('.wph .wph-inner') => $this->confirmation_cb()
    );

    // Add action for other plugins to hook in:
    // TODO: do_action( 'wphelpful_mark_completed', array( 'user_id' => get_current_user_id(), 'post_id' => $post_id, 'button_id' => $unique_button_id, 'course' => $course ) );

    if (defined('DOING_AJAX') && DOING_AJAX) {
      echo json_encode( $updates_to_sendback, JSON_UNESCAPED_UNICODE );
      die();
    } else {
      if ( isset( $_REQUEST['redirect'] ) ) {
        wp_safe_redirect( $_REQUEST['redirect'] );
      } else if ( wp_get_referer() ) {
        wp_safe_redirect( wp_get_referer() );
      } else {
        wp_safe_redirect( get_home_url() );
      }
    }
  }

  /**
   * ...
   *
   * @since    1.0.0
   * @last     1.0.0
   */
  public function confirmation_cb() {
    $confirmation_text = get_option( $this->plugin_name . '_thankyou_text', 'Thanks for your feedback!' );
    
    ob_start();

    include 'partials/wphelpful-templates-confirmation.php';

    return ob_get_clean();
  }

}
