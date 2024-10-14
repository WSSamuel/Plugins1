
<div class="wph wph-wrapper wph-emoji wph-<?php echo $show_feedback; ?>">
  <div class="wph-inner">
    <form action="<?php echo admin_url( 'admin-post.php?action=save_feedback' ); ?>" class="wph-form">
      <h3 class="wph-h3"><?php echo $header_text; ?></h3>
      <input type="hidden" name="wphelpful[post_id]" value="<?php echo $post_id; ?>" />
      <input type="hidden" name="wphelpful[rating]" value="-" />

      <div class="wph-rating-wrap">          
        <label class="wph-emoji-label wph-emoji-01 wph-label" title="Bad">
          <input type="radio" name="wphelpful[rating]" value="1" class="wph-rating rating-01" <?php checked( $rating, '1' ); ?>>
          <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="sad-tear" class="svg-emoji" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-110.3 0-200-89.7-200-200S137.7 56 248 56s200 89.7 200 200-89.7 200-200 200zm8-152c-13.2 0-24 10.8-24 24s10.8 24 24 24c23.8 0 46.3 10.5 61.6 28.8 8.1 9.8 23.2 11.9 33.8 3.1 10.2-8.5 11.6-23.6 3.1-33.8C330 320.8 294.1 304 256 304zm-88-64c17.7 0 32-14.3 32-32s-14.3-32-32-32-32 14.3-32 32 14.3 32 32 32zm160-64c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zm-165.6 98.8C151 290.1 126 325.4 126 342.9c0 22.7 18.8 41.1 42 41.1s42-18.4 42-41.1c0-17.5-25-52.8-36.4-68.1-2.8-3.7-8.4-3.7-11.2 0z"></path></svg>
        </label>
        
        <label class="wph-emoji-label wph-emoji-02 wph-label" title="Not Good">
          <input type="radio" name="wphelpful[rating]" value="2" class="wph-rating rating-02" <?php checked( $rating, '2' ); ?>>
          <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="frown" class="svg-emoji" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-110.3 0-200-89.7-200-200S137.7 56 248 56s200 89.7 200 200-89.7 200-200 200zm-80-216c17.7 0 32-14.3 32-32s-14.3-32-32-32-32 14.3-32 32 14.3 32 32 32zm160-64c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zm-80 128c-40.2 0-78 17.7-103.8 48.6-8.5 10.2-7.1 25.3 3.1 33.8 10.2 8.4 25.3 7.1 33.8-3.1 16.6-19.9 41-31.4 66.9-31.4s50.3 11.4 66.9 31.4c8.1 9.7 23.1 11.9 33.8 3.1 10.2-8.5 11.5-23.6 3.1-33.8C326 321.7 288.2 304 248 304z"></path></svg>
        </label>
        
        <label class="wph-emoji-label wph-emoji-03 wph-label" title="Okay">
          <input type="radio" name="wphelpful[rating]" value="3" class="wph-rating rating-03" <?php checked( $rating, '3' ); ?>>
          <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="meh" class="svg-emoji" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-110.3 0-200-89.7-200-200S137.7 56 248 56s200 89.7 200 200-89.7 200-200 200zm-80-216c17.7 0 32-14.3 32-32s-14.3-32-32-32-32 14.3-32 32 14.3 32 32 32zm160-64c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zm8 144H160c-13.2 0-24 10.8-24 24s10.8 24 24 24h176c13.2 0 24-10.8 24-24s-10.8-24-24-24z"></path></svg>
        </label>
        
        <label class="wph-emoji-label wph-emoji-04 wph-label" title="Good">
          <input type="radio" name="wphelpful[rating]" value="4" class="checked wph-rating rating-04" <?php checked( $rating, '4' ); ?>>
          <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="smile" class="svg-emoji" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-110.3 0-200-89.7-200-200S137.7 56 248 56s200 89.7 200 200-89.7 200-200 200zm-80-216c17.7 0 32-14.3 32-32s-14.3-32-32-32-32 14.3-32 32 14.3 32 32 32zm160 0c17.7 0 32-14.3 32-32s-14.3-32-32-32-32 14.3-32 32 14.3 32 32 32zm4 72.6c-20.8 25-51.5 39.4-84 39.4s-63.2-14.3-84-39.4c-8.5-10.2-23.7-11.5-33.8-3.1-10.2 8.5-11.5 23.6-3.1 33.8 30 36 74.1 56.6 120.9 56.6s90.9-20.6 120.9-56.6c8.5-10.2 7.1-25.3-3.1-33.8-10.1-8.4-25.3-7.1-33.8 3.1z"></path></svg>
        </label>
        
        <label class="wph-emoji-label wph-emoji-05 wph-label" title="Great">
          <input type="radio" name="wphelpful[rating]" value="5" class="wph-rating rating-05" <?php checked( $rating, '5' ); ?>>
          <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="grin-stars" class="svg-emoji" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-110.3 0-200-89.7-200-200S137.7 56 248 56s200 89.7 200 200-89.7 200-200 200zm105.6-151.4c-25.9 8.3-64.4 13.1-105.6 13.1s-79.6-4.8-105.6-13.1c-9.8-3.1-19.4 5.3-17.7 15.3 7.9 47.2 71.3 80 123.3 80s115.3-32.9 123.3-80c1.6-9.8-7.7-18.4-17.7-15.3zm-227.9-57.5c-1 6.2 5.4 11 11 7.9l31.3-16.3 31.3 16.3c5.6 3.1 12-1.7 11-7.9l-6-34.9 25.4-24.6c4.5-4.5 1.9-12.2-4.3-13.2l-34.9-5-15.5-31.6c-2.9-5.8-11-5.8-13.9 0l-15.5 31.6-34.9 5c-6.2.9-8.9 8.6-4.3 13.2l25.4 24.6-6.1 34.9zm259.7-72.7l-34.9-5-15.5-31.6c-2.9-5.8-11-5.8-13.9 0l-15.5 31.6-34.9 5c-6.2.9-8.9 8.6-4.3 13.2l25.4 24.6-6 34.9c-1 6.2 5.4 11 11 7.9l31.3-16.3 31.3 16.3c5.6 3.1 12-1.7 11-7.9l-6-34.9 25.4-24.6c4.5-4.6 1.8-12.2-4.4-13.2z"></path></svg>
        </label>

      </div><!-- wph-rating-wrap -->
      
      <div class="wph-feedback-wrap">
      
        <p class="wph-p"><?php echo $subheader_text; ?></p>
        <?php if ( is_array( $previous_feedback ) && @date_create_from_format( 'D M d Y H:i:s e+', $previous_feedback['local_time'] ) ) : ?>
        <small class="wph-small">You previously submitted feedback here on <?php echo date_format( date_create_from_format( 'D M d Y H:i:s e+', $previous_feedback['local_time'] ), "M j, Y" ); ?>.</small>
        <?php endif; ?>
        <?php if ( !$user_logged_in ) : ?>
        <input type="email" name="wphelpful[email]" class="wph-email" placeholder="<?php echo $email_placeholder_text; ?>"<?php if ( $allow_anonymous === 'false' ) echo ' required'; ?>>
        <?php endif; ?>
        <textarea name="wphelpful[feedback]" class="wph-textarea" placeholder="<?php echo $placeholder_text; ?>"><?php if ( $previous_feedback && !empty( $previous_feedback['feedback'] ) ) echo stripslashes($previous_feedback['feedback']); ?></textarea>
        
        <button type="submit" class="wph-button" data-active="<?php echo $button_active_text; ?>"><?php echo $button_text; ?></button>
      
      </div>

    </form>
  
  </div><!-- wph-inner -->
</div><!-- wph-wrapper -->
