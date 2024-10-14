<?php
global $wpdb;
 $iiat_posts = $wpdb->prefix . 'posts';
 $iiat_postMeta = $wpdb->prefix . 'postmeta';
 $results = $wpdb->get_results("SELECT * FROM $iiat_posts WHERE post_type = 'attachment' AND post_mime_type = 'image/png' OR post_mime_type = 'image/jpeg'");
  foreach ($results as $key => $value) {
  $title_insert_image_alt_text = '';
    if(!get_post_meta($value->ID, '_wp_attachment_image_alt', true)){
        $title_insert_image_alt_text = ucwords(strtolower(preg_replace( '%\s*[-_\s]+\s*%', ' ', get_the_title($value->ID))));
       	update_post_meta($value->ID, '_wp_attachment_image_alt', $title_insert_image_alt_text);
    }
  }
 ?>