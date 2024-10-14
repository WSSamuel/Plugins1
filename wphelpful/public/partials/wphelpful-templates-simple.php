
<div class="wph wph-wrapper wph-simple wph-<?php echo $show_feedback; ?>">
  <div class="wph-inner">
    <form action="<?php echo admin_url( 'admin-post.php?action=save_feedback' ); ?>" class="wph-form">
      <h3 class="wph-h3"><?php echo $header_text; ?></h3>
      <input type="hidden" name="wphelpful[post_id]" value="<?php echo $post_id; ?>" />
      <input type="hidden" name="wphelpful[rating]" value="-" />

      <div class="wph-rating-wrap-simple">
        
        <input type="radio" name="wphelpful[rating]" value="yes" id="wph-rating-<?php echo $uid; ?>-yes" class="wph-rating rating-yes" <?php checked( $rating, 'yes' ); ?>>
        <label class="wph-simple-label wph-simple-yes wph-label" for="wph-rating-<?php echo $uid; ?>-yes">
          Yes
        </label>
        
        <input type="radio" name="wphelpful[rating]" value="no" id="wph-rating-<?php echo $uid; ?>-no" class="wph-rating rating-no" <?php checked( $rating, 'no' ); ?>>
        <label class="wph-simple-label wph-simple-no wph-label" for="wph-rating-<?php echo $uid; ?>-no">
          No
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
