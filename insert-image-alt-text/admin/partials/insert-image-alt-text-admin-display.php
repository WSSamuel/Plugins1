<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://jonmendoza.ph
 * @since      1.0.0
 *
 * @package    Insert_Image_Alt_Text
 * @subpackage Insert_Image_Alt_Text/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php 
global $wpdb;
$iiat_posts = $wpdb->prefix . 'posts';
$iiat_postMeta = $wpdb->prefix . 'postmeta';
$results = $wpdb->get_results("SELECT * FROM $iiat_posts WHERE post_type = 'attachment' AND post_mime_type = 'image/png' OR post_mime_type = 'image/jpeg'");
$count = 0;
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"></div>
	<h1><?php esc_attr_e( 'Alt Images', 'WpAdminStyle' ); ?></h1>
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
   <form method="post" name="wp_alt_images_form" id="wp_alt_images_form">
    <?php submit_button('Alt them All'); ?>
		<input type="hidden" name="insert_image_alt_text_nonce" value="insert_image_alt_text_nonce">
		</form>
			<div id="post-body-content">
	<table class="widefat">
  	<thead>
  	<tr>
  		<th class="row-title"><?php esc_attr_e( 'Image Title', 'WpAdminStyle' ); ?></th>
  		<th><?php esc_attr_e( 'Image URL', 'WpAdminStyle' ); ?></th>
  	</tr>
  	</thead>
	 <tbody>
  <?php
  foreach ($results as $key => $value) {
    if(!get_post_meta($value->ID, '_wp_attachment_image_alt', true)){ ?>
    <tr class="alternate">
      <td class="row-title">
        <label for="tablecell"><?php echo get_the_title($value->ID); ?></label>
      </td>
      <td>
        <a target="_blank" href="<?php echo wp_get_attachment_url($value->ID); ?>"><?php echo wp_get_attachment_url($value->ID); ?></a>
      </td>
    </tr>
    <?php 
    $count++; }} 
  ?>
	</tbody>
	<tfoot>
	<tr>
		<th class="row-title"><?php esc_attr_e( 'Total Images without Alt', 'WpAdminStyle' ); ?></th>
		<th><?php esc_attr_e( $count, 'WpAdminStyle' ); ?></th>
	</tr>
	</tfoot>
</table>
			</div>
			<div id="postbox-container-1" class="postbox-container">
				<div class="meta-box-sortables">
					<div class="postbox">
						<div class="handlediv" title="Click to toggle"><br></div>
						<h2 class="hndle"><span><?php esc_attr_e(
									'Reminder', 'WpAdminStyle'
								); ?></span></h2>
						<div class="inside">
							<p><?php esc_attr_e( 'This is a one use tool to put alt text in all images that doesn\'t have alt text.' ); ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br class="clear">
	</div>
</div> 
