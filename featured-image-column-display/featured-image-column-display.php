<?php
  /**
    * Plugin Name: Featured Image Column Display
    * Description: A plugin that adds the "Featured Image" column in post type listing display.
    * Version: 2.0
    * Author: Sawai S. Dheerawat
    * Author URI: http://twitter.com/ssdheerawat
    * License: GPLv2+
  */


  if ( !defined( 'ABSPATH' ) || preg_match('#' . basename( __FILE__ ) . '#',  $_SERVER['PHP_SELF'])) {
    die( "You are not allowed to call this page directly." );
  }


  class Featured_Image_Column_Display{

    function __construct() {

      add_filter( 'manage_posts_columns',			array( $this, 'ficd_add_img_column' ) );
      add_filter('manage_posts_custom_column', array( $this, 'ficd_manage_img_column'), 10, 2);
    }

    /**
		 * Add The Featured Image Column
		 */

    function ficd_add_img_column($columns) {
      return array_merge( $columns, array('img' => __('Featured Image')) );
    }

    /**
		 * Output the image
		 */

    function ficd_manage_img_column($column_name, $post_id) {

      if( $column_name == 'img' ) {
          if ( has_post_thumbnail() ) {
                  echo get_the_post_thumbnail($post_id, array( 80, 80), array( 'class' => 'alignleft' ));
          }
          else {
              echo '<img width="80px" height="80px" src="' . esc_url( plugins_url( 'images/no-image.jpeg', __FILE__ ) ) . '" > ';
          }
      }
    }
  }

new Featured_Image_Column_Display();