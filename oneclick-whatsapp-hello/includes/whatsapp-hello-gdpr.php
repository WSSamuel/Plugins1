<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

/**
 * @package     OneClick WP Hello
 * @author      Walter Pinem
 * @link        https://walterpinem.me
 * @link        https://www.seniberpikir.com/oneclick-whatsapp-hello-wordpress/
 * @copyright   Copyright (c) 2019, Walter Pinem, Seni Berpikir
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

class WA_HELLO_GDPR {

	// Begin creating
		function __construct()	{
			if ( get_option( 'wa_hello_gdpr_status_enable' ) != 'yes' )
				return;
			
			add_shortcode( 'gdpr', array( $this, 'get_gdpr_link' ) );
			add_action( 'wa_hello_action_plugin', array( $this, 'display_gdpr' ) );
		}

	// Construct the display
		function display_gdpr() {
			?>
			<div class="wa_hello-gdpr">
				<div>
					<label for="wa_hello-gdpr-checkbox">
						<input type="checkbox" id="wa_hello-gdpr-checkbox"> <?php echo do_shortcode( stripslashes( do_shortcode(  get_option( 'wa_hello_gdpr_privacy_page' ) ) ) ) ?>
						</label>
				</div>
			</div>
			<?php
		}

	// Generate GDPR Link
		function get_gdpr_link() {

			$page_slug 				= get_option( 'wa_hello_gdpr_privacy_page' );
			$page 						= get_page_by_path( $page_slug );
			$page_title 			= get_the_title( $page );
			$page_permalink 	= site_url( '/'.$page_slug.'/' );

			return "<a href='$page_permalink' target='_blank'><strong>$page_title</strong></a>";
		}

	// Get option if enabled
		private function _get_option( $data ) {

			$option = get_option( 'wa_hello_gdpr_status_enable' );
			
			return $option[$data];
		}

	} // WA_GDPR

new WA_HELLO_GDPR;