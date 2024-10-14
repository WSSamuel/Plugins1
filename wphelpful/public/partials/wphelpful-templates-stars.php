
<div class="wph wph-wrapper wph-stars wph-<?php echo $show_feedback; ?>">
  <div class="wph-inner">
    <form action="<?php echo admin_url( 'admin-post.php?action=save_feedback' ); ?>" class="wph-form">
      <h3 class="wph-h3"><?php echo $header_text; ?></h3>
      <input type="hidden" name="wphelpful[post_id]" value="<?php echo $post_id; ?>" />
      <input type="hidden" name="wphelpful[rating]" value="-" />
      
      <div class="wph-rating-wrap">
        
        <input type="radio" name="wphelpful[rating]" value="5" id="wphelpful-<?php echo $uid; ?>-05" class="wph-rating rating-05" <?php checked( $rating, '5' ); ?>>
        <label for="wphelpful-<?php echo $uid; ?>-05" class="wph-stars-label stars-05 wph-label" title="5">
          <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="star" class="svg-stars" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"></path></svg>
        </label>
        
        <input type="radio" name="wphelpful[rating]" value="4" id="wphelpful-<?php echo $uid; ?>-04" class="wph-rating rating-04" <?php checked( $rating, '4' ); ?>>
        <label for="wphelpful-<?php echo $uid; ?>-04" class="wph-stars-label stars-04 wph-label" title="4">
          <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="star" class="svg-stars" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"></path></svg>
        </label>
        
        <input type="radio" name="wphelpful[rating]" value="3" id="wphelpful-<?php echo $uid; ?>-03" class="wph-rating rating-03" <?php checked( $rating, '3' ); ?>>
        <label for="wphelpful-<?php echo $uid; ?>-03" class="wph-stars-label stars-03 wph-label" title="3">
          <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="star" class="svg-stars" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"></path></svg>
        </label>
        
        <input type="radio" name="wphelpful[rating]" value="2" id="wphelpful-<?php echo $uid; ?>-02" class="wph-rating rating-02" <?php checked( $rating, '2' ); ?>>
        <label for="wphelpful-<?php echo $uid; ?>-02" class="wph-stars-label stars-02 wph-label" title="2">
          <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="star" class="svg-stars" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"></path></svg>
        </label>
        
        <input type="radio" name="wphelpful[rating]" value="1" id="wphelpful-<?php echo $uid; ?>-01" class="wph-rating rating-01" <?php checked( $rating, '1' ); ?>>
        <label for="wphelpful-<?php echo $uid; ?>-01" class="wph-stars-label stars-01 wph-label" title="1">
          <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="star" class="svg-stars" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"></path></svg>
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
