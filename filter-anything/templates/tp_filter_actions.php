<div class="wfa-form-actions">
    <button type="submit" name="directory_submit" value="<?php /** @var WP_Post $directory */
	echo (int) $directory->ID; ?>"
            class="wfa-form-submit"><?php _e( carbon_get_post_meta( $directory->ID, 'submit_button_text' ) ); ?></button>
    <button type="reset"
            class="wfa-form-clear"><?php _e( carbon_get_post_meta( $directory->ID, 'clear_button_text' ) ); ?></button>
</div>