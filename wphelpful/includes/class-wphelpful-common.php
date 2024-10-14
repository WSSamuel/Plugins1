<?php

/**
 * Common functionality of the plugin.
 *
 * @link       https://wphelpful.com
 * @since      2.0.0
 *
 * @package    WPHelpful
 * @subpackage WPHelpful/includes
 */

/**
 * The common functionality throughout the plugin.
 *
 * @package    WPHelpful
 * @subpackage WPHelpful/includes
 * @author     Zack Gilbert <zack@zackgilbert.com>
 */
class WPHelpful_Common {

  /**
   * The ID of this plugin.
   *
   * @since    2.0.0
   * @access   protected
   * @var      string    $plugin_name    The ID of this plugin.
   */
  protected $plugin_name;

  /**
   * The version of this plugin.
   *
   * @since    2.0.0
   * @access   protected
   * @var      string    $version    The current version of this plugin.
   */
  protected $version;

  /**
   * Initialize the class and set its properties.
   *
   * @since      2.0.0
   * @param      string    $plugin_name       The name of the plugin.
   * @param      string    $version    The version of this plugin.
   */
  public function __construct( $plugin_name, $version ) {

    $this->plugin_name = $plugin_name;
    $this->version = $version;

  }

  /**
   * Returns an array of all wordpress post types that can be completed. This includes custom types.
   *
   * @since  1.0.0
   */
  public function get_enabled_post_types() {
    $post_type = get_option( $this->plugin_name . '_post_type', 'page_post' );
    if ( $post_type == 'page_post' ) {
      $screens = array();
      $screens['post'] = 'post';
      $screens['page'] = 'page';
    } else if ( $post_type == 'all' ) {
      $screens = get_post_types( array( '_builtin' => false ) );
      $screens['post'] = 'post';
      $screens['page'] = 'page';
    } else {
      $screens = explode( ',', $post_type );
    }
    return $screens;
  }

  /**
   * Returns boolean of if a specific post is enabled to show feedback.
   *
   * @since  1.0.0
   */
  public function post_is_enabled($post_id = false) {
    return !!get_post_meta( $post_id, $this->plugin_name, true);
  }

  /**
   * Returns all the posts that are enabled to show feedback.
   *
   * @since  1.0.0
   */
  public function get_enabled_posts() {
    global $wpdb;
    
    // First: check if we have this cached already in the page request:
    if ( $posts_json = wp_cache_get( "enabled-posts", $this->plugin_name ) ) {
      return json_decode( $posts_json, true );    
    }

    // Second: check the database:
    $r = $wpdb->get_results( $wpdb->prepare( "
        SELECT pm.post_id,pm.meta_value FROM {$wpdb->postmeta} pm
        WHERE pm.meta_key = '%s'", $this->plugin_name ), ARRAY_A );

    if ($r && ( count($r) > 0 ) ) {
      // Organize to format we want:
      $posts = array();
      foreach ($r as $index => $row) {
        $row_value = json_decode( $row['meta_value'], true );
        $row_value['index'] = $index;
        if ( $row_value['enabled'] === 'true' )
          $posts[ $row['post_id'] ] = $row_value;
      }
      // Cache for future use:
      wp_cache_set( "enabled-posts", json_encode( $posts, JSON_UNESCAPED_UNICODE ), $this->plugin_name );
      return $posts;
    }
    
    return array();
  }

  /**
   * Accepts new user feedback data that should be stored in database. 
   * Returns an array of all the current user's feedback.
   *
   * @since  1.0.0
   * @last   1.0.0
   */
  public function save_user_post_feedback($data, $post_id, $user_id = false) {
    global $wpdb;

    if (!$user_id) $user_id = get_current_user_id();

    if (!is_string($data)) {
      $data = json_encode( $data, JSON_UNESCAPED_UNICODE );
    }

    // Add the new data to the database:
    // Get down to the metal because WP won't let you save user meta data when user_id = 0
    $saved = $wpdb->insert(
      _get_meta_table( 'user' ),
      array(
        'user_id'    => $user_id,
        'meta_key'   => $this->plugin_name . "-post-" . $post_id,
        'meta_value' => $data
      )
    );

    // If database saved, we should try to cache it for the rest of the page request:
    if ( $saved ) {
      // Save new user completion data into page request cache:
      wp_cache_set( "user-" . $user_id . "-post-" . $post_id, json_encode( $data, JSON_UNESCAPED_UNICODE ), $this->plugin_name );
      $this->break_caches($user_id, $post_id);
    }

    return $saved;
  }

  public function break_caches($user_id, $post_id) {
    // clear other caches for post and user:
    wp_cache_delete( "user-" . $user_id . "-true" );
    wp_cache_delete( "user-" . $user_id . "-false" );
    wp_cache_delete( "post-" . $post_id . "-true" );
    wp_cache_delete( "post-" . $post_id . "-false" );
    wp_cache_delete( "site-true");
    wp_cache_delete( "site-false");
  }

  /**
   * Returns an array of all the site's feedback.
   *
   * @since  1.1.0
   * @last   1.1.0
   */
  public function get_feedback($for_ratings = false) {
    global $wpdb;
    
    // First: check if we have this cached already in the page request:
    if ( $feedback_json = wp_cache_get( "site-" . $for_ratings, $this->plugin_name ) ) {
      return json_decode( $feedback_json, true );    
    }

    // Second: check the database:
    // TODO: pagination
    $r = $wpdb->get_results( $wpdb->prepare( "
        SELECT um.umeta_id,um.user_id,um.meta_key,um.meta_value FROM {$wpdb->usermeta} um
        WHERE um.meta_key LIKE '%s' ORDER BY umeta_id DESC", $this->plugin_name . '-post-%'), ARRAY_A );

    if ($r && ( count($r) > 0 ) ) {
      // Organize to format we want:
      $feedback = array();
      foreach ($r as $index => $row) {
        $row_value = json_decode( $row['meta_value'], true );

        $type = $this->determine_type($row_value['rating']);
        
        $row_value['id'] = $row['umeta_id'];
        if ( $row['user_id'] ) {
          $user = get_userdata( $row['user_id'] );
          $row_value['user'] = '<a href="' . get_edit_user_link($user->ID) . '">' . $user->user_email . '</a>';
        } else if ( isset( $row_value['email'] ) && !empty( $row_value['email'] ) ) {
          $row_value['user'] = '<a href="mailto:' . $row_value['email'] . '">' . $row_value['email'] . '</a>';
        } else {
          $row_value['user'] = 'Anonymous';
        }
        $row_value['post_id'] = str_replace($this->plugin_name . '-post-', '', $row['meta_key']);
        $row_value['index'] = $index;

        // only show feedback that has a rating...
        if ( ( $row_value['rating'] != '-' ) ) {
          // if we want posts feedback only for ratings, 
          if ( $for_ratings ) {
            // then just get each user's latest
            // and just get the ones that are of the correct rating type...
            if ( !isset( $types[$type][$row['user_id']] ) ) {
              $feedback[$row['user_id'] . '-' . $row_value['post_id']] = $row_value;
            }
          } else { // otherwise, just include everything...
            $feedback[$row['umeta_id']] = $row_value;
          }
        }
      }
      // Cache for future use:
      wp_cache_set( "site-" . $for_ratings, json_encode( $feedback, JSON_UNESCAPED_UNICODE ), $this->plugin_name );
      return $feedback;
    }
    
    return array();
  }

  /**
   * Accepts new user feedback data that should be stored in database. 
   * Returns an array of all the current user's feedback.
   *
   * @since  1.0.0
   * @last   1.0.0
   */
  public function get_user_post_feedback($post_id, $user_id = false) {
    if (!$user_id) $user_id = get_current_user_id();

    // First: check if we have this cached already in the page request:
    if ( $user_posts_json = wp_cache_get( "user-" . $user_id . "-post-" . $post_id, $this->plugin_name ) ) {
      return json_decode( $user_posts_json, true );    
    }

    $user_feedback_array = get_user_meta( $user_id, $this->plugin_name . "-post-" . $post_id, false );
    if ( $user_feedback_array ) {
      $latest = false;
      // We want the latest, so loop through and find newest:
      foreach ( $user_feedback_array as $user_feedback_json ) {
        $current = json_decode( $user_feedback_json, true );
        if ( ( $latest === false ) || ( $current['gmt_time'] > $latest['gmt_time'] ) ) {
          $latest = $current;
        }
      }

      // set cache with new value:
      wp_cache_set( "user-" . $user_id . "-post-" . $post_id, json_encode( $latest, JSON_UNESCAPED_UNICODE ), $this->plugin_name );
      return $latest;
    }

    return false;
  }

  /**
   * Returns an array of all the current user's feedback activity.
   *
   * @since  1.0.0
   */
  public function get_user_feedback($user_id = false, $for_ratings = false) {
    global $wpdb;
    
    if (!$user_id) $user_id = get_current_user_id();

    // First: check if we have this cached already in the page request:
    if ( $user_posts_json = wp_cache_get( "user-" . $user_id . "-" . $for_ratings, $this->plugin_name ) ) {
      return json_decode( $user_posts_json, true );    
    }

    // Second: check the database:
    $r = $wpdb->get_results( $wpdb->prepare( "
        SELECT um.umeta_id,um.user_id,um.meta_key,um.meta_value FROM {$wpdb->usermeta} um
        WHERE um.user_id = %s AND um.meta_key LIKE '%s' ORDER BY umeta_id DESC", $user_id, $this->plugin_name . '-post-%'), ARRAY_A );

    if ($r && ( count($r) > 0 ) ) {
      // Organize to format we want:
      $posts = array();
      foreach ($r as $index => $row) {
        $row_value = json_decode( $row['meta_value'], true );
        $row_value['id'] = $row['umeta_id'];
        $row_value['post_id'] = str_replace($this->plugin_name . '-post-', '', $row['meta_key']);
        $row_value['index'] = $index;
        $key = ( $for_ratings ) ? $row_value['post_id'] : $row_value['post_id'] . "-" . $row_value['gmt_time'];
        if ( !isset( $posts[$key] ) && ( $row_value['rating'] != '-' ) )
          $posts[$key] = $row_value;
      }
      // Cache for future use:
      wp_cache_set( "user-" . $user_id . "-" . $for_ratings, json_encode( $posts, JSON_UNESCAPED_UNICODE ), $this->plugin_name );
      return $posts;
    }
    
    return array();
  }

  /**
   * Returns an array of all the supplied post's feedback activity.
   *
   * @since  1.0.0
   */
  public function get_post_feedback($post_id, $for_ratings = false) {
    global $wpdb;
    
    // First: check if we have this cached already in the page request:
    if ( $posts_json = wp_cache_get( 'post-' . $post_id . "-" . $for_ratings, $this->plugin_name ) ) {
      return json_decode( $posts_json, true );      
    }

    // Second: check the database:
    $r = $wpdb->get_results( $wpdb->prepare( "
        SELECT um.umeta_id,um.user_id,um.meta_key,um.meta_value FROM {$wpdb->usermeta} um
        WHERE um.meta_key LIKE '%s' ORDER BY umeta_id DESC", $this->plugin_name . '-post-' . $post_id), ARRAY_A );

    if ($r && ( count($r) > 0 ) ) {
      $type = false;
      // Organize to format we want:
      $users = array();
      foreach ($r as $index => $row) {
        $row_value = json_decode( $row['meta_value'], true );

        // if we don't know the rating type we want, figure it out...
        if ( !$type && ( $row_value['rating'] != '-' ) )
          $type = $this->determine_type($row_value['rating']);

        $row_value['id'] = $row['umeta_id'];
        if ( $row['user_id'] ) {
          $user = get_userdata( $row['user_id'] );
          $row_value['user'] = '<a href="' . get_edit_user_link($user->ID) . '">' . $user->user_email . '</a>';
        } else if ( isset( $row_value['email'] ) && !empty( $row_value['email'] ) ) {
          $row_value['user'] = '<a href="mailto:' . $row_value['email'] . '">' . $row_value['email'] . '</a>';
        } else {
          $row_value['user'] = 'Anonymous';
        }
        $row_value['index'] = $index;

        // only show feedback that has a rating...
        if ( ( $row_value['rating'] != '-' ) ) {
          // if we want posts feedback only for ratings, 
          if ( $for_ratings ) {
            // then just get each user's latest
            // and just get the ones that are of the correct rating type...
            if ( !isset( $users[$row['user_id']] ) && ( $this->determine_type($row_value['rating']) === $type ) ) {
              $users[$row['user_id']] = $row_value;
            }
          } else { // otherwise, just include everything...
            $users[$row['user_id'] . "-" . $row_value['gmt_time']] = $row_value;
          }
        }
      }

      // Cache for future use:
      wp_cache_set( "post-" . $post_id . "-" . $for_ratings, json_encode( $users, JSON_UNESCAPED_UNICODE ), $this->plugin_name );
      return $users;
    }
    
    return array();
  }

  /**
   * Returns ...
   *
   * @since  1.0.0
   */
  function determine_type($rating) {
    // if we are a number, return int...
    if ( is_numeric( $rating ) )
      return 'int';
    // otherwise, we are a yes/no...
    return 'yes/no';
    // QUESTION: do we maybe have other types?
  }

}
