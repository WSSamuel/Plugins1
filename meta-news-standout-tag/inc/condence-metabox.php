<?php 
add_action( 'init', 'condence_register_meta_fields' );
function condence_register_meta_fields() {
  register_meta( 'post', 'condence_metabox_tags', 'sanitize_text_field', 'condence_custom_fields_auth_callback' ); 
  register_meta( 'post', 'condence_metabox_standout', 'condence_desinfectar_standout', 'condence_custom_fields_auth_callback' ); 
}

function condence_desinfectar_standout( $value ) { 
  if( ! empty( $value ) ) {
    return 1;
  } else {
    return 0;
  }
}

function condence_custom_fields_auth_callback( $allowed, $meta_key, $post_id, $user_id, $cap, $caps ) {
  if( 'post' == get_post_type( $post_id ) && current_user_can( 'edit_post', $post_id ) ) {
      $allowed = true;
  } else  {
      $allowed = false;
  }

  return $allowed;
}

add_action( 'add_meta_boxes', 'condence_meta_boxes' );
function condence_meta_boxes() {
    add_meta_box( 'condence-meta-box', __( 'Google News SEO', 'condence_textdomain' ), 'condence_meta_box_callback', 'post' );
}
 
function condence_meta_box_callback( $post ) { 
     wp_nonce_field( 'condence_meta_box', 'condence_meta_box_noncename' ); 
     ?>
     <p>
         <label class="label" for="condence_metabox_tags"> <?php _e( 'Meta Tags', 'condence_textdomain' ); ?> </label>
         <input  name="condence_metabox_tags" id="condence_metabox_tags" type="text" value="<?php echo esc_attr( get_post_meta( $post->ID, 'condence_metabox_tags', true ) ); ?>">
     </p> 
    <?php 
    $current_value = get_post_meta( $post->ID, 'condence_metabox_standout', true );
    ?>
    <p>
        <input type="checkbox" name="condence_metabox_standout" id="condence_metabox_standout" value="1" <?php checked( $current_value, 1 ); ?>>
        <label class="label" for="condence_metabox_standout"><?php  _e( 'Standout', 'condence_textdomain' ); ?></label>
   </p>
   <?php
}

add_action( 'save_post', 'condence_save_custom_fields', 10, 2 );
function condence_save_custom_fields( $post_id, $post ){
     
    if ( ! isset( $_POST['condence_meta_box_noncename'] ) || ! wp_verify_nonce( $_POST['condence_meta_box_noncename'], 'condence_meta_box' ) ) {
        return;
    }
             
    if( isset( $_POST['condence_metabox_tags'] ) && $_POST['condence_metabox_tags'] != "" ) {
        $condence_meta_sanitize_tags = sanitize_text_field($_POST['condence_metabox_tags']);
        update_post_meta( $post_id, 'condence_metabox_tags', $condence_meta_sanitize_tags );
    } else { 
        delete_post_meta( $post_id, 'condence_metabox_tags' );
    }
 
 
    if( isset( $_POST['condence_metabox_standout'] ) && $_POST['condence_metabox_standout'] == "1" ) {
        update_post_meta( $post_id, 'condence_metabox_standout', $_POST['condence_metabox_standout'] );
    } else { 
        delete_post_meta( $post_id, 'condence_metabox_standout' );
    }
}
?>