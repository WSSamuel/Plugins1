<?php
// Load the plugin options array
$cookie_notification_jc_options_arr = get_option( 'cookie_notification_jc_options' );

// Set the option values to variables
$notification_text = $cookie_notification_jc_options_arr[ 'notification_text' ];
$accept_text = $cookie_notification_jc_options_arr[ 'accept_text' ];
$link_text_to_details = $cookie_notification_jc_options_arr[ 'link_text_to_details' ];
$details_page_id = $cookie_notification_jc_options_arr[ 'details_page_id' ];
$notification_width = $cookie_notification_jc_options_arr[ 'notification_width' ];
$position = $cookie_notification_jc_options_arr[ 'position' ];
$opacity = $cookie_notification_jc_options_arr[ 'background_opacity' ];

?>

<div class="cookie-notification-jc-admin-wrapper">
    <h2><?php _e( 'Cookie Notification Setting', 'cookie-notification-jc' ); ?></h2>
    
    <form method="post" action="options.php">
        <?php settings_fields( 'cookie-notification-jc-option-group' ); ?>
        
        <table class="form-table">            
        	<tr valign="top">
            	<th scope="row">
                	<label><?php _e( 'Notification Text', 'cookie-notification-jc' ); ?></label>
                </th>
                <td>
                	<textarea name="cookie_notification_jc_options[notification_text]"><?php echo $notification_text; ?></textarea>
                    <p class="description">This text will be used in the Cookie Consent Notification.</p>
                </td>
            </tr>
            
        	<tr valign="top">
            	<th scope="row">
                	<label><?php _e( 'Accept Text', 'cookie-notification-jc' ); ?></label>
                </th>
                <td>
                	<input type="text" class="regular-text code" name="cookie_notification_jc_options[accept_text]" value="<?php echo $accept_text; ?>" maxlength="50" />
                    <p class="description">This text will be used for the accept button. Maximum length is 50 characters.</p>
                </td>
            </tr>
            
        	<tr valign="top">
            	<th scope="row">
                	<label><?php _e( 'Link Text To The Deails', 'cookie-notification-jc' ); ?></label>
                </th>
                <td>
                	<input type="text" class="regular-text code" name="cookie_notification_jc_options[link_text_to_details]" value="<?php echo $link_text_to_details; ?>" maxlength="50" />
                    <p class="description">This text will be used for the link button to the more details page. Maximum length is 50 characters.</p>
                </td>
            </tr>
            
        	<tr valign="top">
            	<th scope="row">
                	<label><?php _e( 'Select The Details Page', 'cookie-notification-jc' ); ?></label>
                </th>
                <td>
                	<select name="cookie_notification_jc_options[details_page_id]">
                    	<?php
						$pages = get_pages( array( 'sort_order' => 'ASC', 'sort_column' => 'post_title' ) );
						foreach( $pages as $page )
						{
						?>
							<option value="<?php echo $page->ID; ?>" <?php echo ( $page->ID == $details_page_id ) ? 'selected' : ''; ?>><?php echo $page->post_title; ?></option>
                        <?php
						}
						?>
                    </select>
                    <p class="description">This plugin creates a details page on activation. However you can select a different page, which will be linked to the link text.</p>
                </td>
            </tr>
            
        	<tr valign="top">
            	<th scope="row">
                	<label><?php _e( 'Width', 'cookie-notification-jc' ); ?></label>
                </th>
                <td>
                	<input type="text" class="code" name="cookie_notification_jc_options[notification_width]" value="<?php echo $notification_width; ?>" size="6" />
                    <p class="description">This will set the width of this notification. Suffix it with either px or %.
                </td>
            </tr>
            
            <tr valign="top">
            	<th scope="row">
                	<label><?php _e( 'Position', 'cookie-notification-jc' ); ?></label>
                </th>
                <td>
                	<select name="cookie_notification_jc_options[position]">
                        <option value="top" <?php echo ( $position == 'top' ) ? 'Selected' : ''; ?>>Top</option>
                        <option value="bottom" <?php echo ( $position == 'bottom' ) ? 'Selected' : ''; ?>>Bottom</option>
                    </select>
                    <p class="description">Select the position of this notification on the site. ex. Top or bottom of the site.</p>
                </td>
            </tr>
            
            <tr valign="top">
            	<th scope="row">
                	<label><?php _e( 'Notification Background Opacity', 'cookie-notification-jc' ); ?></label>
                </th>
                <td>
                	<input type="text" class="code" name="cookie_notification_jc_options[background_opacity]" id="cookie-notification-jc-opacity-slider-val" value="<?php echo $opacity; ?>" readonly="readonly" size="3" />%
                	<span id="cookie-notification-jc-opacity-slider"></span>
                    <p class="description">Set the opacity of this notification's background.</p>
                </td>
            </tr>
        </table>
        
        <p class="submit">
            <input id="submit" class="button button-primary" type="submit" value="<?php _e( 'Save changes', 'cookie-notification-jc' ); ?>" />
        </p>
    </form>
</div>