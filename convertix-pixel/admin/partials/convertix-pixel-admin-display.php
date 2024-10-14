<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://convertix.digital
 * @since      1.0.0
 *
 * @package    Convertix_Pixel
 * @subpackage Convertix_Pixel/admin/partials
 */

?>

<style>
	.set-width {
	  width: 500px;
	}
</style>

<div id="convertix-pixel-admin-settings" class="wrap">
	<h2><?php esc_html_e( 'Convertix Pixel for WordPress Options', 'convertix-pixel' ); ?></h2>
	<form action="options.php" method="post">
		<?php settings_fields( CONVERTIX_PIXEL_ADMIN_GROUP ); ?>
		<?php do_settings_sections( CONVERTIX_PIXEL_ADMIN_SLUG ); ?>
		<?php submit_button(); ?>
	</form>
</div>
