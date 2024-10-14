<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   author-avatar
 * @author    Guillaume Kanoufi <guillaume@lostwebdesigns.com>
 * @license   GPL-2.0+
 * @link      http://lostwebdesigns.com
 * @copyright 12-16-2013 Company Name
 */
?>
<div class="wrap">

	 <h3><?php _e( 'Additional User Profile Picture', '<?php echo $this->plugin_slug;?>' ); ?></h3>

	    <table class="form-table">

	        <tr>
	            <th><label for="user_meta_image"><?php _e( 'A custom image per user', '<?php echo $this->plugin_slug;?>' ); ?></label></th>
	            <td>
	                <!-- Outputs the image after save -->
	                <img src="<?php echo esc_url( get_the_author_meta( 'user_meta_image', $user->ID ) ); ?>" style="width:150px;" class="user_meta_thumb"><br />
	                <!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
	                <input type="text" name="user_meta_image" id="user_meta_image" value="<?php echo esc_url_raw( get_the_author_meta( 'user_meta_image', $user->ID ) ); ?>" class="regular-text" />
	                <!-- Outputs the save button -->
	                <input type='button' class="additional-user-image button-primary" value="<?php _e( 'Upload Image', '<?php echo $this->plugin_slug;?>' ); ?>" id="uploadimage"/><br />
	                <span class="description"><?php _e( 'Upload an additional image for your user profile.', '<?php echo $this->plugin_slug;?>' ); ?></span>
	            </td>
	        </tr>

	    </table><!-- end form-table -->

</div>
