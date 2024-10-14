<?php
/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Convertix_Pixel
 * @subpackage Convertix_Pixel/includes
 * @file       class-convertix-pixel-deactivator.php
 */

/**
 * The plugin deactivator class.
 */
class Convertix_Pixel_Deactivator {
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
	}
}
