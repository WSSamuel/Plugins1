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

// Display error message if basic configuration is empty
function wa_hello_check_number_empty(){
	$phone = get_option('wa_hello_whatsapp_number');
	$error = __( '<p><strong>OneClick WP Hello</strong> requires <strong> WhatsApp Number!</strong> <a href="?page=whatsapp-hello&tab=button_config"><strong>Click here</strong></a> to fill it.</p>', 'oneclick-whatsapp-hello' );
	
	if ( $phone === '' ) {
		printf( __( '<div class="error">%s</div>', 'oneclick-whatsapp-hello' ), $error );
	}
}
add_action('admin_notices', 'wa_hello_check_number_empty');

// GDPR Page Selection
if ( ! function_exists( 'wa_hello_options_dropdown' ) ) {
	function wa_hello_options_dropdown( $args ) {
		global $wpdb;
		$query 		= $wpdb->get_results( "SELECT post_name, post_title FROM {$wpdb->posts} WHERE post_type = 'page'", ARRAY_A );
		$name 		= ( $args['name'] ) ? 'name="' . $args['name'] . '" ' : '';
		$multiple = ( isset( $args['multiple'] ) ) ? 'multiple' : '';
		echo '<select '.$name .' id="" class="wa_hello-admin-select2 regular-text" '. $multiple .' >';		
			foreach ( $query as $key => $value ) {
				if ( $args['selected'] ) {
					if ( $multiple ) {
						if ( in_array( $value['post_name'], $args['selected']) ) {
							$selected = 'selected="selected"';
						} else {
							$selected = '';
						}
					} else {
						if ( $value['post_name'] == $args['selected'] ) {
							$selected = 'selected="selected"';
						} else {
							$selected = '';
						}
					}
				}
				echo '<option value="'.$value['post_name'].'" '. $selected .'>'.$value['post_title'].'</option>';		
			}
		echo '</select>';
	}
}

// Display Floating Button
function wa_hello_floating_button() {
	$floating = get_option(sanitize_text_field('wa_hello_floating_button'));
	$floating_position = get_option(sanitize_text_field('wa_hello_floating_button_position'));
	$floating_message = get_option(sanitize_text_field('wa_hello_floating_message'));
	$floating_target = get_option(sanitize_text_field('wa_hello_floating_target'));
	$button_text = get_option(sanitize_text_field('wa_hello_option_text_button'));
	$target = get_option(sanitize_text_field('wa_hello_option_target'));
	$phone = get_option('wa_hello_option_phone_number');
	$custom_message = get_option('wa_hello_option_message');
	$floating_link = "https://wa.me/$phone?text=$floating_message";
	$tooltip_enable = get_option(sanitize_text_field('wa_hello_floating_tooltip_enable'));
	$tooltip = get_option(sanitize_text_field('wa_hello_floating_tooltip'));
	$floating_mobile = get_option(sanitize_text_field('wa_hello_floating_hide_mobile'));

	    if ( $floating === 'yes' && $floating_position === 'left' ) { ?>
			<a class="floating_button" href="<?php echo $floating_link ?>" role="button" target="<?php echo $floating_target ?>">
				<i class="fab fa-whatsapp"></i>
			</a>

				<style>
					.floating_button {
						left: 20px;
					}
					@media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
					    .floating_button {
					        left: 10px!important;
					    }
					}
				</style>
	 	<?php  } elseif ( $floating === 'yes' && $floating_position === 'right' ) { ?>
		<a class="floating_button" href="<?php echo $floating_link ?>" role="button" target="<?php echo $floating_target ?>">		
			<i class="fab fa-whatsapp"></i>
		</a>
			<style>
				.floating_button {
					right: 20px;
				}
				@media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
				    .floating_button {
				        right: 10px!important;
				    }
				}
			</style>	
     <?php
    }
}
add_filter('wp_head', 'wa_hello_floating_button');

// Display Floating Button with Tooltip
function wa_hello_floating_tooltip() {
	$floating = get_option(sanitize_text_field('wa_hello_floating_button'));
	$floating_position = get_option(sanitize_text_field('wa_hello_floating_button_position'));
	$floating_message = get_option(sanitize_text_field('wa_hello_floating_message'));
	$floating_target = get_option(sanitize_text_field('wa_hello_floating_target'));
	$button_text = get_option(sanitize_text_field('wa_hello_option_text_button'));
	$target = get_option(sanitize_text_field('wa_hello_option_target'));
	$phone = get_option('wa_hello_option_phone_number');
	$custom_message = get_option('wa_hello_option_message');
	$floating_link = "https://wa.me/$phone?text=$floating_message";
	$tooltip_enable = get_option(sanitize_text_field('wa_hello_floating_tooltip_enable'));
	$tooltip = get_option(sanitize_text_field('wa_hello_floating_tooltip'));
	$floating_mobile = get_option(sanitize_text_field('wa_hello_floating_hide_mobile'));

if ( $floating === 'yes' && $floating_position === 'left' && $tooltip_enable === 'yes' ) { ?>
					<a href="<?php echo $floating_link ?>" role="button" target="<?php echo $floating_target ?>" class="floating_button">
					<i class="fab fa-whatsapp"></i>
					</a>
					<div class="label-container">
						<i class="fa fa-caret-left label-arrow"></i>
					<div class="label-text"><i class="fas fa-comments"></i> <?php echo $tooltip ?></div>
					</div>	
			<style>
			.floating_button {
				left: 20px;
			}
				.label-container {
  					left: 85px;
				}	
				.label-text i {
				    margin-right: 5px;
				}			
			</style>
<?php  } elseif ( $floating === 'yes' && $floating_position === 'right' && $tooltip_enable === 'yes' ) { ?>
					<a href="<?php echo $floating_link ?>" role="button" target="<?php echo $floating_target ?>" class="floating_button">
					<i class="fab fa-whatsapp"></i>
					</a>
					<div class="label-container">
					<div class="label-text"><?php echo $tooltip ?> <i class="fas fa-comments"></i></div>
					<i class="fa fa-caret-right label-arrow"></i>
					</div>	
			<style>
				.floating_button {
					right: 20px;
				}
				.label-container {
  					right: 85px;
				}	
				.label-text i {
				    margin-left: 5px;
				}				
			</style>		
     <?php
    }
}
add_filter('wp_head', 'wa_hello_floating_tooltip');

// Hide Button on Mobile
function wa_hello_hide_floating_button() {
	$floating_mobile = get_option(sanitize_text_field('wa_hello_floating_hide_mobile'));
	if ( $floating_mobile === 'yes' ) { ?>
			<style>
			@media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
				.floating_button {
					display: none !important;
				}
			}		
			</style>
     <?php
    }     
}
add_filter('wp_head', 'wa_hello_hide_floating_button');

// Shortcode Function
function wa_hello_shortcode_button( $atts, $content = null ) {
		$phone = get_option('wa_hello_whatsapp_number');
		$blank = get_option(sanitize_text_field('wa_hello_shortcode_target'));
        $target_blank = "target=\"$blank\"";
        $custom_message = get_option('wa_hello_shortcode_message');
        $gdpr_message = do_shortcode( stripslashes (get_option( 'wa_hello_gdpr_message' )));
        $button_text = get_option(sanitize_text_field('wa_hello_shortcode_text_button'));
        $gdpr = get_option(sanitize_text_field('wa_hello_gdpr_status_enable'));
        $button_url = "https://wa.me/$phone?text=$custom_message";

    if ( get_option(sanitize_text_field('wa_hello_gdpr_status_enable')) && get_option(sanitize_text_field('wa_hello_shortcode_text_button')) )
    $out = "<label><a href=\"https://wa.me/" .$phone. "?text=" . $custom_message . "\"" .$target_blank." role=\"button\"><button type=\"button\" id=\"sendbtn\" class=\"gdpr_wa_button_input\" disabled=\"disabled\">" .do_shortcode($content). "$button_text</button></a></label><div class=\"wa-hello-gdprchk\"><label><input type=\"checkbox\" name=\"wa_hello_gdpr_status_enable\" class=\"wa_hello_input_check\" id=\"gdprChkbx\"><p>$gdpr_message</p></label></div>
			<script type=\"text/javascript\">
				document.getElementById('gdprChkbx').addEventListener('click', function (e) {
  				document.getElementById('sendbtn').disabled = !e.target.checked;
				});
			</script>";
    elseif ( get_option(sanitize_text_field('wa_hello_gdpr_status_enable')) && !get_option(sanitize_text_field('wa_hello_shortcode_text_button')) )
    	$out = "<label><a href=\"https://wa.me/" .$phone. "?text=" . $custom_message . "\"" .$target_blank." role=\"button\"><button class=\"shortcode_gdpr_nt\" type=\"button\" id=\"sendbtn\" disabled=\"disabled\">" .do_shortcode($content). "</button></a></label><div class=\"wa-hello-gdprchk\"><label><input type=\"checkbox\" name=\"wa_hello_gdpr_status_enable\" class=\"wa_hello_input_check\" id=\"gdprChkbx\"><p>$gdpr_message</p></label></div>
			<script type=\"text/javascript\">
				document.getElementById('gdprChkbx').addEventListener('click', function (e) {
  				document.getElementById('sendbtn').disabled = !e.target.checked;
				});
			</script>";
    elseif ( get_option(sanitize_text_field('wa_hello_shortcode_text_button')) )
    	$out = "<label><a href=\"https://wa.me/" .$phone. "?text=" . $custom_message . "\"" .$target_blank." role=\"button\"><button type=\"submit\" id=\"sendbtn\" class=\"gdpr_wa_button_input\">" .do_shortcode($content). "$button_text</button></a></label>";
    else
    	$out = "<a class=\"shortcode_wa_button_nt\" href=\"https://wa.me/" .$phone. "?text=" . $custom_message . "\"" .$target_blank.">" .do_shortcode($content). "</a>";
    return $out;   
}
add_shortcode('wa-hello', 'wa_hello_shortcode_button');

// Hide Button on Mobile
function wa_hello_hide_wa_button() {
	$hide_button = get_option(sanitize_text_field('wa_hello_hide_button'));
    if ( $hide_button === 'yes') { ?>
    	<style>
    			.gdpr_wa_button_input, .gdpr_wa_button_input_nt, .shortcode_wa_button_nt, a.shortcode_wa_button_nt, .wa-hello-gdprchk p, .wa-hello-gdprchk input[type=checkbox] {
    				display: none !important;
    			}
    		@media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
    			.gdpr_wa_button_input, .gdpr_wa_button_input_nt, .wa-gdpr-tnc, .shortcode_wa_button_nt, a.shortcode_wa_button_nt, .wa-gdpr-tnc small {
    				display: inline-flex!important;
    			}
    			.wa-hello-gdprchk p, .wa-hello-gdprchk input[type=checkbox] {
					display: inline-block!important;
    			}
    		}
    	</style>
    <?php 
	}
}
add_filter('wp_head', 'wa_hello_hide_wa_button');