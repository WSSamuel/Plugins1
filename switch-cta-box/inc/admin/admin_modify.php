<?php
add_filter( 'post_updated_messages', 'wppw_cttabox_my_post_updated_messages' );
/**
 * Callback for WordPress 'post_updated_messages' filter.
 * 
 * @param  array $messages The array of messages.
 * @return array $messages The array of messages.
 */
function wppw_cttabox_my_post_updated_messages( $messages ){
        
    global $post;
    
    $post_ID = $post->ID;
    
    $messages['ctabox'] = array(
        0 => '', // Unused. Messages start at index 1.
        1 => sprintf( __('Post Type updated. <a href="%s">View Post Type</a>'), esc_url( get_permalink($post_ID) ) ),
        2 => __('Post Type field updated.'),
        3 => __('Post Type field deleted.'),
        4 => __('Post Type updated.'),
        5 => isset($_GET['revision']) ? sprintf( __('Post Type restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6 => sprintf( __('Post Type published. <a href="%s">View run</a>'), esc_url( get_permalink($post_ID) ) ),
        7 => __('Post Type saved.'),
        8 => sprintf( __('Post Type submitted. <a target="_blank" href="%s">Preview run</a>'), esc_url( add_query_arg( 'preview', 'true',get_permalink($post_ID) ) ) ),
        9 => sprintf( __('Post Type scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview run</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
        10 => sprintf( __('Cta Box Saved. Place Short-code to Display Anywhere'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    );
    
    return $messages;
        
}