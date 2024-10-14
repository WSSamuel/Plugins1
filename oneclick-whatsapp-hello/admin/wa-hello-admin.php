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
 * @category    Admin Page
 */

function wa_hello_add_admin_page() {

    // Generate WhatsApp Hello Admin Page
    add_menu_page( 'OneClick WP Hello Options', 'OneClick WP Hello', 'manage_options', 'whatsapp-hello', 'wa_hello_create_admin_page', plugin_dir_url( dirname( __FILE__ ) ) . '/assets/images/chat-menu.png' );

    // Begin building
    add_action( 'admin_init', 'wa_hello_register_settings' );
        }
    add_action( 'admin_menu', 'wa_hello_add_admin_page' );

function wa_hello_register_settings() {

    // Register the settings
    register_setting( 'wa-hello-settings-group-button-config', 'wa_hello_whatsapp_number' );
    register_setting( 'wa-hello-settings-group-button-config', 'wa_hello_hide_button' );
    register_setting( 'wa-hello-settings-group-button-config', 'wa_hello_shortcode_message' );
    register_setting( 'wa-hello-settings-group-button-config', 'wa_hello_shortcode_text_button' );
    register_setting( 'wa-hello-settings-group-button-config', 'wa_hello_shortcode_target' );
    register_setting( 'wa-hello-settings-group-button-config', 'wa_hello_gdpr_status_enable' );
    register_setting( 'wa-hello-settings-group-button-config', 'wa_hello_gdpr_message' );
    register_setting( 'wa-hello-settings-group-button-config', 'wa_hello_gdpr_privacy_page' );
    register_setting( 'wa-hello-settings-group-floating', 'wa_hello_floating_button' );
    register_setting( 'wa-hello-settings-group-floating', 'wa_hello_floating_button_position' );
    register_setting( 'wa-hello-settings-group-floating', 'wa_hello_floating_message' );
    register_setting( 'wa-hello-settings-group-floating', 'wa_hello_floating_target' );
    register_setting( 'wa-hello-settings-group-floating', 'wa_hello_floating_tooltip_enable' );
    register_setting( 'wa-hello-settings-group-floating', 'wa_hello_floating_tooltip' );
    register_setting( 'wa-hello-settings-group-floating', 'wa_hello_floating_hide_mobile' );    
}

    // Delete option upon deactivation
function wa_hello_deactivation() {
    delete_option( 'wa_hello_whatsapp_number' );
    delete_option( 'wa_hello_hide_button' );
    delete_option( 'wa_hello_shortcode_message' );
    delete_option( 'wa_hello_shortcode_text_button' );
    delete_option( 'wa_hello_shortcode_target' );
    delete_option( 'wa_hello_gdpr_status_enable' );
    delete_option( 'wa_hello_gdpr_message' );
    delete_option( 'wa_hello_gdpr_privacy_page' );
    delete_option( 'wa_hello_floating_button' );
    delete_option( 'wa_hello_floating_button_position' );
    delete_option( 'wa_hello_floating_message' );
    delete_option( 'wa_hello_floating_target' );
    delete_option( 'wa_hello_floating_tooltip_enable' );
    delete_option( 'wa_hello_floating_tooltip' );    
    delete_option( 'wa_hello_floating_hide_mobile' );  
}
register_deactivation_hook( __FILE__, 'wa_hello_deactivation' );

    // Begin Building the Admin Option
function wa_hello_create_admin_page( $active_tab = '' ){
	if( isset( $_GET[ 'tab' ] ) ) {
	      $active_tab = esc_attr($_GET[ 'tab' ]);
	  } else if( $active_tab == 'button_config' ) {
	      $active_tab = 'button_config';
	  } else if( $active_tab == 'floating_button' ) {
	      $active_tab = 'floating_button';
	  } else if( $active_tab == 'tutorial_support' ) {
	      $active_tab = 'tutorial_support';                   
	  } else {
	      $active_tab = 'welcome';
	  } // end if/else 

?>
    <div class="wrap OCWAhello_pluginpage_title">
        <h1><?php _e( 'OneClick WP Hello', 'oneclick-whatsapp-hello' ); ?></h1>
        <hr>     
        <h2 class="nav-tab-wrapper">
            <a href="?page=whatsapp-hello&tab=welcome" class="nav-tab <?php echo esc_attr( $active_tab ) == 'welcome' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Welcome', 'oneclick-whatsapp-hello' ); ?></a>
            <a href="?page=whatsapp-hello&tab=button_config" class="nav-tab <?php echo esc_attr( $active_tab ) == 'button_config' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Button & Shortcode', 'oneclick-whatsapp-hello' ); ?></a>
            <a href="?page=whatsapp-hello&tab=floating_button" class="nav-tab <?php echo esc_attr( $active_tab ) == 'floating_button' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Floating Button', 'oneclick-whatsapp-hello' ); ?></a>
            <a href="?page=whatsapp-hello&tab=tutorial_support" class="nav-tab <?php echo esc_attr( $active_tab ) == 'tutorial_support' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Support', 'oneclick-whatsapp-hello' ); ?></a>
        </h2>
         <?php if( $active_tab == 'tutorial_support' ) { ?>
            <!-- Begin creating plugin admin page --> 
            <div class="wrap">
                    <div class="feature-section one-col wrap about-wrap">
             
                <div class="about-text">
                    <h4><?php printf( __( "<strong>OneClick WP Hello</strong> is Waiting for a Feedback", 'oneclick-whatsapp-hello' )); ?></h>
                </div>
                        <div class="indo-about-description">
                            <?php printf( __( "<strong> OneClick WP Hello</strong> is my third plugin and it's open source. I acknowledge that there are still a lot to fix, here and there, that's why I really need your feedback. <br>Let's get in touch and show some love by <a href=\"https://wordpress.org/support/plugin/oneclick-whatsapp-hello/reviews/?rate=5#new-post\" target=\"_blank\"><strong>leaving a review</strong></a>.", 'oneclick-whatsapp-hello' )); ?>
                                </div>                    

        <table class="tg" style="table-layout: fixed; width: 269px">
        <colgroup>
        <col style="width: 105px">
        <col style="width: 164px">
        </colgroup>
          <tr>
            <th class="tg-kiyi">Author:</th>
            <th class="tg-fymr">Walter Pinem</th>
          </tr>
          <tr>
            <td class="tg-kiyi">Website:</td>
            <td class="tg-fymr"><a href="https://walterpinem.me/" target="_blank">walterpinem.me</a></td>
          </tr>
          <tr>
            <td class="tg-kiyi" rowspan="2"></td>
            <td class="tg-fymr"><a href="https://www.seniberpikir.com/" target="_blank">www.seniberpikir.com</a></td>
          </tr>
          <tr>
            <td class="tg-fymr"><a href="https://www.dequixote.com/" target="_blank">www.dequixote.com</a></td>
          </tr>
          <tr>
            <td class="tg-kiyi">Email:</td>
            <td class="tg-fymr"><a href="mailto:hello@walterpinem.me" target="_blank">hello@walterpinem.me</a></td>
          </tr>
          <tr>
            <td class="tg-kiyi">More:</td>
            <td class="tg-fymr"><a href="https://walterpinem.me/projects/contact/" target="_blank">Support Page</a></td>
          </tr>
          <tr>
            <td class="tg-kiyi" rowspan="3"></td>
            <td class="tg-fymr"><a href="https://walterpinem.me/about/" target="_blank">Other Projects</a></td>
          </tr>
          <tr>
            <td class="tg-fymr"><a href="https://www.linkedin.com/in/walterpinem/" target="_blank">Linkedin</a></td>
          </tr>
          <tr>
            <td class="tg-fymr"><a href="https://www.paypal.me/WalterPinem" target="_blank">Donate</a></td>
          </tr>
        </table>               
            </div>
            </div>

 <?php } elseif( $active_tab == 'button_config' ) { ?>
    <!-- Basic Configurations -->
    <form method="post" action="options.php">
    <?php settings_errors(); ?>
    <?php settings_fields( 'wa-hello-settings-group-button-config' ); ?> 
    <?php do_settings_sections( 'wa-hello-settings-group-button-config' ); ?>
    <h2 class="section_wa_hello"><?php _e( 'WhatsApp Number', 'oneclick-whatsapp-hello' ); ?></h2>
    <p>
        <?php _e('WhatsApp Number is <strong>required</strong>. Please fill it first.', 'oneclick-whatsapp-hello'); ?>
            <br />
    </p>
    <table class="form-table">
        <tbody>
            <tr class="wa_hello_number">
                <th scope="row">
                    <label class="wa_hello_number_label" for="phone_number"><b><?php _e( 'WhatsApp Number', 'oneclick-whatsapp-hello' ); ?></b></label>
                </th><hr>
                <td>
                    <input type="number" name="wa_hello_whatsapp_number" class="wa_hello_input" value="<?php echo get_option('wa_hello_whatsapp_number'); ?>" placeholder="<?php _e( 'e.g. 6281234567890', 'oneclick-whatsapp-hello' ); ?>">
                    <p class="description">
                        <?php _e( 'Enter number including country code, e.g. <code><b>62</b>81234567890</code>', 'oneclick-whatsapp-hello' ); ?></p>
                </td>
            </tr>
                </tbody>
            </table>
            <hr>
            <h2 class="section_wa_hello"><?php _e( 'Generate Shortcode', 'oneclick-whatsapp-hello' ); ?></h2>
            <p>
                <?php _e('Use shortcode to display WhatsApp button anywhere on your site.', 'oneclick-whatsapp-hello'); ?>
                    <br />
            </p>
            <table class="form-table">
                <tbody>
                    <tr class="wa_hello_btn_text">
                        <th scope="row">
                            <label class="wa_hello_btn_txt_label" for="text_button"><b><?php _e( 'Text on Button', 'oneclick-whatsapp-hello' ); ?></b></label>
                        </th>
                        <td>
                            <input type="text" name="wa_hello_shortcode_text_button" class="wa_hello_input" value="<?php echo get_option('wa_hello_shortcode_text_button'); ?>" placeholder="<?php _e( 'e.g. Chat on WhatsApp', 'oneclick-whatsapp-hello' ); ?>">
                        </td>
                    </tr>
                    <tr class="wa_hello_message">
                        <th scope="row">
                            <label class="wa_hello_message_label" for="message_wbw"><b><?php _e( 'Custom Message', 'oneclick-whatsapp-hello' ); ?></b></label>
                        </th>
                        <td>
                            <textarea name="wa_hello_shortcode_message" class="wa_hello_input_areatext" rows="5" placeholder="<?php _e( 'e.g. Hello, I need to know more about', 'oneclick-whatsapp-hello' ); ?>"><?php echo get_option('wa_hello_shortcode_message'); ?></textarea>
                            <p class="description">
                                <?php _e( 'Enter custom message, e.g. <code>Hello, I need to know more about</code>', 'oneclick-whatsapp-hello' ); ?></p </td>
                    </tr>
						<tr>
                            <th scope="row">
                                <label>
                                    <?php _e('Enable GDPR Notice', 'oneclick-whatsapp-hello') ?>
                                </label>
                            </th>
                            <td>
                                <input type="checkbox" name="wa_hello_gdpr_status_enable" class="wa_hello_input_check" value="yes" <?php checked( get_option( 'wa_hello_gdpr_status_enable'), 'yes' ); ?>>
                                <?php _e( 'Check to Enable GDPR Notice.', 'oneclick-whatsapp-hello' ) ?>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label>
                                    <?php _e('GDPR Message', 'oneclick-whatsapp-hello') ?>
                                </label>
                            </th>
                            <td>
                                <textarea name="wa_hello_gdpr_message" class="wa_hello_input_areatext" rows="5" placeholder="<?php _e( 'e.g. I have read the [gdpr]', 'oneclick-whatsapp-hello' ); ?>"><?php echo get_option('wa_hello_gdpr_message'); ?></textarea>
                                <p class="description">
                                    <?php printf( __('Use %s to display Privacy Policy page link.', 'oneclick-whatsapp-hello') , '<code>[gdpr]</code>' ) ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label>
                                    <?php _e('Privacy Policy Page', 'oneclick-whatsapp-hello') ?>
                                </label>
                            </th>
                            <td>
                                <?php wa_hello_options_dropdown( 
                                    array(
                                        'name'      => 'wa_hello_gdpr_privacy_page',
                                        'selected'  => ( get_option('wa_hello_gdpr_privacy_page')), 
                                        ) 
                                    ) 
                                ?>
                            </td>
                        </tr>
                        <tr class="wa_hello_target">
                            <th scope="row">
                                <label class="wa_hello_target_label" for="wa_hello_target"><b><?php _e( 'Open in New Tab?', 'oneclick-whatsapp-hello' ); ?></b></label>
                            </th>
                            <td>
                                <input type="checkbox" name="wa_hello_shortcode_target" class="wa_hello_input_check" value="_blank" <?php checked( get_option( 'wa_hello_shortcode_target'), '_blank' );?>>
                                <?php _e( 'Yes, Open in New Tab', 'oneclick-whatsapp-hello' ); ?>
                                    <br>
                            </td>
                        </tr>
                        <tr class="wa_hello_remove_add_btn">
                            <th scope="row">
                                <label class="wa_hello_remove_btn_label" for="wa_hello_remove_wa_hello_btn"><b><?php _e( 'Show Only on Mobile?', 'oneclick-whatsapp-hello' ); ?></b></label>
                            </th>
                            <td>
                                <input type="checkbox" name="wa_hello_hide_button" class="wa_hello_input_check" value="yes" <?php checked( get_option( 'wa_hello_hide_button'), 'yes' );?>>
                                <?php _e( 'This will hide WhatsApp Button on Desktop.', 'oneclick-whatsapp-hello' ); ?>
                                    <br>
                            </td>
                        </tr>   
            <tr class="wa_hello_target">
                <th scope="row">
                    <label class="wa_hello_copy_label" for="wa_hello_copy"><b><?php _e( 'Copy Shortcode', 'oneclick-whatsapp-hello' ); ?></b></label>
                </th>
                <td>
                    <input style="letter-spacing: 1px;" class="wa_hello_shortcode_input" onClick="this.setSelectionRange(0, this.value.length)" value="[wa-hello]" />
                        <br>
                </td>
            </tr>
        </tbody>
    </table>
    <hr>
        <?php submit_button(); ?>
        </form>
<?php } elseif( $active_tab == 'floating_button' ) { ?>
    <form method="post" action="options.php">
    <?php settings_errors(); ?>
    <?php settings_fields( 'wa-hello-settings-group-floating' ); ?> 
    <?php do_settings_sections( 'wa-hello-settings-group-floating' ); ?>
    <!-- Floating Button -->
    <h2 class="section_wa_hello"><?php _e( 'Floating Button', 'oneclick-whatsapp-hello' ); ?></h2>
    <p>
        <?php _e('Enable / disable a floating WhatsApp button on your entire pages. You can configure the floating button below.', 'oneclick-whatsapp-hello'); ?>
            <br />
    </p>
    <table class="form-table">
        <tbody>
            <tr class="wa_hello_remove_add_btn">
                <th scope="row">
                    <label class="wa_hello_remove_btn_label" for="wa_hello_remove_wa_hello_btn"><b><?php _e( 'Display Floating Button?', 'oneclick-whatsapp-hello' ); ?></b></label>
                </th>
                <td>
                    <input type="checkbox" name="wa_hello_floating_button" class="wa_hello_input_check" value="yes" <?php checked( get_option( 'wa_hello_floating_button'), 'yes' );?>>
                    <?php _e( 'This will show floating WhatsApp Button', 'oneclick-whatsapp-hello' ); ?>
                        <br>
                </td>
            </tr>
            <th scope="row">
                <label>
                    <?php _e('Floating Button Position', 'oneclick-whatsapp-hello') ?>
                </label>
            </th>
            <td>
                <input type="radio" name="wa_hello_floating_button_position" value="left" <?php checked( 'left', get_option( 'wa_hello_floating_button_position'), true); ?>>
                <?php _e( 'Left', 'oneclick-whatsapp-hello' ); ?>
                    <input type="radio" name="wa_hello_floating_button_position" value="right" <?php checked( 'right', get_option( 'wa_hello_floating_button_position'), true); ?>>
                    <?php _e( 'Right', 'oneclick-whatsapp-hello' ); ?>
            </td>
            </tr>
            <tr class="wa_hello_message">
                <th scope="row">
                    <label class="wa_hello_message_label" for="message_wbw"><b><?php _e( 'Custom Message', 'oneclick-whatsapp-hello' ); ?></b></label>
                </th>
                <td>
                    <textarea name="wa_hello_floating_message" class="wa_hello_input_areatext" rows="5" placeholder="<?php _e( 'e.g. Hello, I need to know more about', 'oneclick-whatsapp-hello' ); ?>"><?php echo get_option('wa_hello_floating_message'); ?></textarea>
                    <p class="description">
                        <?php _e( 'Enter custom message, e.g. <code>Hello, I need to know more about</code>', 'oneclick-whatsapp-hello' ); ?></p>
                    </td>
            </tr>

            <tr class="wa_hello_remove_add_btn">
                <th scope="row">
                    <label class="wa_hello_remove_btn_label" for="wa_hello_remove_wa_hello_btn"><b><?php _e( 'Display Tooltip?', 'oneclick-whatsapp-hello' ); ?></b></label>
                </th>
                <td>
                    <input type="checkbox" name="wa_hello_floating_tooltip_enable" class="wa_hello_input_check" value="yes" <?php checked( get_option( 'wa_hello_floating_tooltip_enable'), 'yes' );?>>
                    <?php _e( 'This will show a custom tooltip', 'oneclick-whatsapp-hello' ); ?>
                        <br>
                </td>
            </tr>

            <tr class="wa_hello_btn_text">
                <th scope="row">
                    <label class="wa_hello_btn_txt_label" for="floating_tooltip"><b><?php _e( 'Button Tooltip', 'oneclick-whatsapp-hello' ); ?></b></label>
                </th>
                <td>
                    <input type="text" name="wa_hello_floating_tooltip" class="wa_hello_input" value="<?php echo get_option('wa_hello_floating_tooltip'); ?>" placeholder="<?php _e( 'e.g. Let\'s Chat', 'oneclick-whatsapp-hello' ); ?>">
                    <p class="description">
                        <?php _e( 'Use this to greet your readers. Make it short and sweet.', 'oneclick-whatsapp-hello' ); ?></p>
                </td>
            </tr>                         

            <tr class="wa_hello_target">
                <th scope="row">
                    <label class="wa_hello_target_label" for="wa_hello_target"><b><?php _e( 'Hide Floating Button on Mobile?', 'oneclick-whatsapp-hello' ); ?></b></label>
                </th>                                
                <td>
                    <input type="checkbox" name="wa_hello_floating_hide_mobile" class="wa_hello_input_check" value="yes" <?php checked( get_option( 'wa_hello_floating_hide_mobile'), 'yes' );?>>
                    <?php _e( 'This will hide Floating Button on Mobile.', 'oneclick-whatsapp-hello' ); ?>
                        <br>
                </td>
            </tr>

            <tr class="wa_hello_target">
                <th scope="row">
                    <label class="wa_hello_target_label" for="wa_hello_target"><b><?php _e( 'Open in New Tab?', 'oneclick-whatsapp-hello' ); ?></b></label>
                </th>
                <td>
                    <input type="checkbox" name="wa_hello_floating_target" class="wa_hello_input_check" value="_blank" <?php checked( get_option( 'wa_hello_floating_target'), '_blank' );?>>
                    <?php _e( 'Yes, Open in New Tab', 'oneclick-whatsapp-hello' ); ?>
                        <br>
                </td>
            </tr>
        </tbody>
    </table>
    <hr>
        <?php submit_button(); ?>
        </form>
  <?php } elseif ( $active_tab == 'welcome' ) { ?>
    <!-- Begin creating plugin admin page --> 
    <div class="wrap">
            <div class="feature-section one-col wrap about-wrap">
    <!-- <div class="wp-badge welcome__logo"></div> --> 
        <div class="indo-title-text"><h2><?php printf( __( 'Thank you for using <br>OneClick WP Hello', 'oneclick-whatsapp-hello' )); ?></h2>
    <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/oneclick-wp-hello.png'; ?>" />
        </div>
     
        <div class="feature-section one-col about-text">
            <h3><?php printf( __( "Make It Easy for Readers to Reach You!", 'oneclick-whatsapp-hello' )); ?></h3>
        </div>
                <div class="feature-section one-col indo-about-description">
        <?php printf( __( "<strong>OneClick WP Hello</strong> will make it easier for your readers to contact you directly through WhatsApp with a single click using a custom shortcode or a floating button. Get connected with your audience is easier than ever!", 'oneclick-whatsapp-hello' )); ?>                
            </div>
    <div class="clear"></div>
        <div class="feature-section one-col">
            <div class="indo-get-started"><h3><?php _e( 'Let\'s Get Started', 'oneclick-whatsapp-hello' ); ?></h3>
            <ul>
                <li><strong><?php _e( 'Step #1:', 'oneclick-whatsapp-hello' ); ?></strong> <?php _e( 'Start adding your <strong>WhatsApp number</strong> and display WhatsApp button anywhere you like with a <strong>single shortcode</strong> on <a href="admin.php?page=whatsapp-hello&tab=button_config"><strong>Button & Shortcode</strong></a> setting panel.', 'oneclick-whatsapp-hello' ); ?></li>
                <li><strong><?php _e( 'Step #2:', 'oneclick-whatsapp-hello' ); ?></strong> <?php _e( 'Show a fancy<strong> Floating Button</strong> with customized message and tooltip which you can customize easily on <a href="admin.php?page=whatsapp-hello&tab=floating_button"><strong>Floating Button</strong></a> setting panel.', 'oneclick-whatsapp-hello' ); ?></li>
                <li><strong><?php _e( 'Step #3:', 'oneclick-whatsapp-hello' ); ?></strong> <?php _e( 'Make your site GDPR-ready by showing <strong>GDPR Notice</strong> right under the WhatsApp button.', 'oneclick-whatsapp-hello' ); ?></li>
                <li><strong><?php _e( 'Step #4:', 'oneclick-whatsapp-hello' ); ?></strong> <?php _e( '<strong>Have an inquiry?</strong> Find out how to reach me out on <a href="admin.php?page=whatsapp-hello&tab=tutorial_support"><strong>Support</strong></a> panel.', 'oneclick-whatsapp-hello' ); ?></li>
            </ul>
         </div>
         </div>
<!-- iframe -->     <hr>
        <div class="feature-section two-col">
            <div class="col">
                <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/simple-chat-button.png'; ?>" />
                <h3><?php _e( 'Simple Chat Button', 'oneclick-whatsapp-hello' ); ?></h3>
                <p><?php _e( 'Show a WhatsApp button anywhere you like using a simple shortcode with custom message. You can also display the button with or without GDPR notice and button text. It\'s yours!', 'oneclick-whatsapp-hello' ); ?></p>
            </div>
            <div class="col">
                <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/fancy-floating-button.png'; ?>" />
                <h3><?php _e( 'Fancy Floating Button', 'oneclick-whatsapp-hello' ); ?></h3>
                <p><?php _e( 'Make it easy for your audience to reach you out through a click of a floating WhatsApp button, displayed on the left of right with tons of customization options.', 'woneclick-whatsapp-hello' ); ?></p>
            </div>
     
            <div class="col">
                <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/gdpr-ready.png'; ?>" />
                <h3><?php _e( 'Make Yours GDPR-Ready', 'oneclick-whatsapp-hello' ); ?></h3>
                <p><?php _e( 'The regulations are real and it\'s time to make your site ready for them. Make your site GDPR-ready with some simple configurations, really easy!', 'oneclick-whatsapp-hello' ); ?></p>
            </div>
     
            <div class="col">
                <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/documentation.png'; ?>" />
                <h3><?php _e( 'Comprehensive Documentation', 'oneclick-whatsapp-hello' ); ?></h3>
                <p><?php _e( 'You will not be left alone. Our complete documentation or tutorial will always help and support all your needs to get started.', 'oneclick-whatsapp-hello' ); ?></p>
            </div>
        </div>    
     
    </div>
    </div>    
        <br>
    </div>
    <?php
}
}