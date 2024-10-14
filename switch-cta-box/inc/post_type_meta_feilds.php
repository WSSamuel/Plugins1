<?php

function wppw_cttabox_add_cta_box_metaboxes() {
	add_meta_box('cta_box_description', 'Box Description', 'wppw_cttabox_cta_box_description_callback', 'CTA Box', 'normal', 'high');
	add_meta_box('cta_box_button_text', 'CTA Button Text', 'wppw_cttabox_cta_box_button_text_callback', 'CTA Box', 'normal', 'high');
	add_meta_box('cta_box_button_id', 'CTA Button ID', 'wppw_cttabox_cta_box_button_id_callback', 'CTA Box', 'normal', 'high');
	add_meta_box('cta_box_button_link', 'CTA Button Link', 'wppw_cttabox_cta_box_button_link_callback', 'CTA Box', 'normal', 'high');
	add_meta_box('cta_box_show_shortcode', 'CTA Box Shortcode To Display', 'wppw_cttabox_cta_box_show_shortcode_callback', 'CTA Box', 'side', 'high');
	add_meta_box('cta_box_template_select', 'Select Template for This Box', 'wppw_cttabox_cta_box_template_select_callback', 'CTA Box', 'normal', 'high');
	add_meta_box('cta_box_contact_dev', 'Get You WordPress Service Done!!', 'wppw_cttabox_cta_box_contact_dev_callback', 'CTA Box', 'side', 'low');
	add_meta_box('cta_box_update_coming', 'Next Update', 'wppw_cttabox_cta_box_update_coming_callback', 'CTA Box', 'normal', 'high');
}
add_action( 'add_meta_boxes', 'wppw_cttabox_add_cta_box_metaboxes' );


function wppw_cttabox_cta_box_button_id_callback() {
	global $post;
	
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="ctaboxmeta_noncename" id="ctaboxmeta_noncename" value="' . 
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	// Get the location data if its already been entered
	$cta_box_button_id = esc_attr(get_post_meta($post->ID, 'cta_box_button_id', true));
	
	// Echo out the field
	echo '<input type="text" name="cta_box_button_id" value="' . $cta_box_button_id  . '" class="widefat" /><p class="description">Please enter the button ID without any spaces!</p>';
	
}
function wppw_cttabox_cta_box_button_text_callback() {
	global $post;
	
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="ctaboxmeta_noncename" id="ctaboxmeta_noncename" value="' . 
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	// Get the location data if its already been entered
	$cta_box_button_text = esc_attr(get_post_meta($post->ID, 'cta_box_button_text', true));
	
	// Echo out the field
	echo '<input type="text" name="cta_box_button_text" value="' . $cta_box_button_text  . '" class="widefat" />';
	
}
function wppw_cttabox_cta_box_show_shortcode_callback() {
	global $post;
	
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="ctaboxmeta_noncename" id="ctaboxmeta_noncename" value="' . 
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	// Get the location data if its already been entered
	$postId  = $post->ID;
	$shortcode = '[wppw_cta_box id =' . $postId.']';
	// Echo out the field
	echo '<input type="text" value="' . $shortcode  . '" class="widefat"/>';
	
}
function wppw_cttabox_cta_box_button_link_callback() {
	global $post;
	
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="ctaboxmeta_noncename" id="ctaboxmeta_noncename" value="' . 
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	// Get the location data if its already been entered
	$cta_box_button_link = esc_attr(get_post_meta($post->ID, 'cta_box_button_link', true));
	
	// Echo out the field
	echo '<input type="text" name="cta_box_button_link" value="' . $cta_box_button_link  . '" class="widefat"  /><p class="description">CTA button link</p>';
	
}
function wppw_cttabox_cta_box_description_callback() {
	global $post;
	
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="ctaboxmeta_noncename" id="ctaboxmeta_noncename" value="' . 
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	// Get the location data if its already been entered
	$cta_box_description = esc_attr(get_post_meta($post->ID, 'cta_box_description', true));
	
	// Echo out the field
	echo '<textarea name="cta_box_description" value="" class="widefat"  rows="6">'. $cta_box_description  . '
</textarea><p class="description">CTA box main content</p>';

}
function wppw_cttabox_cta_box_contact_dev_callback(){
	
	$output = "<p>Get <i>10% off</i> at any WordPress related services, You are special to us as you are our plugin user</p>";
	$output .= "<a target=\"blank\" href=\"http://www.wppluginwiki.com/contributors/\">Check out us</a>";
	
	echo $output;
}
function wppw_cttabox_cta_box_update_coming_callback(){
	
	$output = "<p>Next update coming soon</p>";
	$output .= "<p>Each box color customization feature</p>";
	$output .= "<p>Button action to pop-up any short-code content</p>";
	echo $output;
}


function wppw_cttabox_cta_box_template_select_callback(){
	global $post;
	
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="ctaboxmeta_noncename" id="ctaboxmeta_noncename" value="' . 
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	// Get the location data if its already been entered
	$cta_box_template_id = esc_attr(get_post_meta($post->ID, 'cta_box_template_id', true));
	
	// Echo out the field
	?>
	<label>
				<select id="cta_box_template_id" name="cta_box_template_id" ?>>
					<option value="template_one" <?php if($cta_box_template_id  == 'template_one') echo 'selected="selected"'; ?>>Template 1</option>
					<option value="template_two" <?php if($cta_box_template_id  == 'template_two') echo 'selected="selected"'; ?>>Template 2</option>
					<option value="template_three" <?php if($cta_box_template_id  == 'template_three') echo 'selected="selected"'; ?>>Template 3</option>
				</select>
				<div class="preview_button_holder"><a id="launcce_cta_box_template_preview">Selected Template Layout Preview</a></div>
				<input type="hidden" id="template_one_image"  value="<?php echo plugins_url( 'admin/preview/template_1.png', __FILE__ )?>" />
				<input type="hidden" id="template_two_image"  value="<?php echo plugins_url( 'admin/preview/template_2.png', __FILE__ )?>" />
				<input type="hidden" id="template_three_image"  value="<?php echo plugins_url( 'admin/preview/template_3.png', __FILE__ )?>" />
				<div id="the_template_preview"><div id="theimage_loader" class="image_conatiner launcedState"></div></div>
			</label><?php
	
}
// Save the Metabox Data

function wppw_cttabox_wpt_save_ctabox_meta($post_id, $post) {
	
	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
		if (isset($_POST["cta_box_description"]) && !empty($_POST["cta_box_description"])) {
	if ( !wp_verify_nonce( $_POST['ctaboxmeta_noncename'], plugin_basename(__FILE__) )) {
	return $post->ID;
	}

	// Is the user allowed to edit the post or page?
	if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;

	// OK, we're authenticated: we need to find and save the data
	// We'll put it into an array to make it easier to loop though.
	$ctabox_meta['cta_box_description'] = sanitize_text_field($_POST['cta_box_description']);
	$ctabox_meta['cta_box_button_id'] = sanitize_text_field($_POST['cta_box_button_id']);
	$ctabox_meta['cta_box_button_link'] = sanitize_text_field($_POST['cta_box_button_link']);
	$ctabox_meta['cta_box_button_text'] = sanitize_text_field($_POST['cta_box_button_text']);
	$ctabox_meta['cta_box_template_id'] = sanitize_text_field($_POST['cta_box_template_id']);
	
	// Add values of $downloads_meta as custom fields
	
	foreach ($ctabox_meta as $key => $value) { // Cycle through the $downloads_meta array!
		if( $post->post_type == 'revision' ) return; // Don't store custom data twice
		$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
		if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
			update_post_meta($post->ID, $key, $value);
		} else { // If the custom field doesn't have a value
			add_post_meta($post->ID, $key, $value);
		}
		if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
	}

}
}

add_action('save_post', 'wppw_cttabox_wpt_save_ctabox_meta', 1, 2); // save the custom fields