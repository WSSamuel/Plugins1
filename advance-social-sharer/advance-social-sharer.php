<?php
/*
Plugin Name: Advance Social Sharer
Plugin URI:  php4cms.wordpress.com/plugin
Description: Add Social buttons in to your posts.
Author: Elsner Technologies Pvt. Ltd.
Version: 2.1
Author URI: http://www.elsner.com
License: GPLv2 or later
*/

/*  Copyright 2013    Eveready Web Technologies( plsakaria@yahoo.in )  */

if( ! function_exists( 'fcbk_bttn_plgn_add_pages' ) ) {
	function fcbk_bttn_plgn_add_pages() {
		add_menu_page( 'WSS Plugins', 'Social Sharer', 'manage_options', 'advance-social-sharer.php', 'fcbk_bttn_plgn_settings_page', plugins_url( "images/icon_small.png", __FILE__ ), 1001); 
		
		
		//add_menu_page( 'WSS Plugins', 'WSS Plugins', 'manage_options', 'wss_plugins', 'wss_add_menu_render', plugins_url( "img/px.png", __FILE__ ), 1001); 
		//add_submenu_page( 'wss_plugins', __( 'Social Button Options', 'facebook' ), __( 'Social Buttons', 'facebook' ), 'manage_options', "advance-social-sharer.php", 'fcbk_bttn_plgn_settings_page');

		//call register settings function
		//add_action( 'admin_init', 'fcbk_btn_plgn_settings' );
	}
}

if( ! function_exists( 'fcbk_bttn_plgn_settings' ) ) {
	function fcbk_bttn_plgn_settings() {
		global $btn_plgn_options_array;

		$btn_plgn_options_array_default = array(
			'fcbk_bttn_plgn_link'						=> '',
			'fcbk_bttn_plgn_my_page'				=> 1,
			'fcbk_bttn_plgn_like'						=> 1,
			'fcbk_bttn_plgn_send'						=> 1,
			'fcbk_bttn_plgn_comment'						=> 0,
			'fcbk_bttn_plgn_where'					=> '',
			'fcbk_bttn_plgn_display_option' => '',
			'fcbk_bttn_plgn_count_icon'			=> 1,
			'fb_img_link'										=>  plugins_url( "img/standart-facebook-ico.jpg", __FILE__ ),
			'fcbk_bttn_plgn_locale' => 'en_US'
		);

		if( ! get_option( 'btn_plgn_options_array' ) )
			add_option( 'btn_plgn_options_array', $btn_plgn_options_array_default, '', 'yes' );

		$btn_plgn_options_array = get_option( 'btn_plgn_options_array' );
//echo "<pre>";print_r($btn_plgn_options_array);
		$btn_plgn_options_array = array_merge( $btn_plgn_options_array_default, $btn_plgn_options_array );
		update_option( 'btn_plgn_options_array', $btn_plgn_options_array );
	}
}

//Function formed content of the plugin's admin page.
if( ! function_exists( 'fcbk_bttn_plgn_settings_page' ) ) {
	function fcbk_bttn_plgn_settings_page() 
	{
		global $btn_plgn_options_array;
		$copy = false;
		
		if( @copy( plugin_dir_path( __FILE__ )."img/facebook-ico.jpg", plugin_dir_path( __FILE__ )."img/facebook-ico3.jpg" ) !== false )
			$copy = true;

		$message = "";
		$error = "";
		if( isset( $_REQUEST['btn_plgn_form_submit'] ) && check_admin_referer( plugin_basename(__FILE__), 'fcbk_bttn_plgn_nonce_name' ) ) {
			// Takes all the changed settings on the plugin's admin page and saves them in array 'btn_plgn_options_array'.
					
				$btn_plgn_options_array [ 'fcbk_bttn_plgn_app_id' ]			=	$_REQUEST [ 'fcbk_bttn_plgn_app_id' ];
				$btn_plgn_options_array [ 'fcbk_bttn_plgn_link' ]			=	$_REQUEST [ 'fcbk_bttn_plgn_link' ];
				$btn_plgn_options_array [ 'fcbk_bttn_plgn_where' ]		=	$_REQUEST [ 'fcbk_bttn_plgn_where' ];
				$btn_plgn_options_array [ 'fcbk_bttn_plgn_display_option' ]	=	$_REQUEST [ 'fcbk_bttn_plgn_display_option' ];
				$btn_plgn_options_array [ 'fcbk_bttn_plgn_my_page' ]	=	isset( $_REQUEST [ 'fcbk_bttn_plgn_my_page' ] ) ? 1 : 0 ;
				$btn_plgn_options_array [ 'fcbk_bttn_plgn_like' ]			=	isset( $_REQUEST [ 'fcbk_bttn_plgn_like' ] ) ? 1 : 0 ;
				$btn_plgn_options_array [ 'fcbk_bttn_plgn_send' ]			=	isset( $_REQUEST [ 'fcbk_bttn_plgn_send' ] ) ? 1 : 0 ;
				$btn_plgn_options_array [ 'fcbk_bttn_plgn_comment' ]			=	isset( $_REQUEST [ 'fcbk_bttn_plgn_comment' ] ) ? 1 : 0 ;
				if ( isset ( $_FILES [ 'uploadfile' ] [ 'tmp_name' ] ) &&  $_FILES [ 'uploadfile' ] [ 'tmp_name' ] != "" ) {		
					$btn_plgn_options_array [ 'fcbk_bttn_plgn_count_icon' ]	=	$btn_plgn_options_array [ 'fcbk_bttn_plgn_count_icon' ] + 1;
				}
				$btn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ]		=	$_REQUEST [ 'fcbk_bttn_plgn_locale' ];
				
				if($btn_plgn_options_array [ 'fcbk_bttn_plgn_count_icon' ] > 2)
					$btn_plgn_options_array [ 'fcbk_bttn_plgn_count_icon' ] = 1;
					
				$btn_plgn_options_array [ 'tw_btn_via' ]	=	$_REQUEST [ 'tw_btn_via' ];
				$btn_plgn_options_array [ 'tw_btn_count' ]	=	isset( $_REQUEST [ 'tw_btn_count' ] ) ? '' : 'none' ;
				$btn_plgn_options_array [ 'tw_btn_large' ]			=	isset( $_REQUEST [ 'tw_btn_large' ] ) ? 'large' : '' ;
				
				$btn_plgn_options_array [ 'gplus_btn_annotation' ]	=	$_REQUEST [ 'gplus_btn_annotation' ];
				$btn_plgn_options_array [ 'gplus_btn_size' ]	=	$_REQUEST [ 'gplus_btn_size' ];
				
				$btn_plgn_options_array [ 'li_btn_count' ]			=	$_REQUEST [ 'li_btn_count' ];
				
				$btn_plgn_options_array [ 'tw_btn_chk' ]			=	isset( $_REQUEST [ 'tw_btn_chk' ] ) ? 1 : 0 ;
				$btn_plgn_options_array [ 'fb_btn_chk' ]			=	isset( $_REQUEST [ 'fb_btn_chk' ] ) ? 1 : 0 ;
				$btn_plgn_options_array [ 'gplus_btn_chk' ]			=	isset( $_REQUEST [ 'gplus_btn_chk' ] ) ? 1 : 0 ;
				$btn_plgn_options_array [ 'li_btn_chk' ]			=	isset( $_REQUEST [ 'li_btn_chk' ] ) ? 1 : 0 ;
				
				update_option	( 'btn_plgn_options_array', $btn_plgn_options_array );
				$message = "Options saved";
		
			
			
			fcbk_bttn_plgn_update_option();
	} 
		?>
	<div class="wrap">
		<div class="icon32 icon32-wss" id="icon-options-general"></div>
		<h2>Social Sharer Options</h2>
		<div class="updated fade" <?php if( ! isset( $_REQUEST['fcbk_bttn_plgn_form_submit'] ) || $error != "" ) echo "style=\"display:none\""; ?>><p><strong><?php echo $message; ?></strong></p></div>
		<div class="error" <?php if( "" == $error ) echo "style=\"display:none\""; ?>><p><strong><?php echo $error; ?></strong></p></div>
		<div>
			<form name="form1" method="post" action="admin.php?page=advance-social-sharer.php" enctype="multipart/form-data" >
            <div style=" font-size: 14px;font-weight: bold;padding: 20px 0 0;">
            	<input name='fb_btn_chk' type='checkbox' value='1' onclick="if ( this . checked == true ) { getElementById ( 'fb_btn' ) . style.display = 'block'; } else { getElementById ( 'fb_btn' ) . style.display = 'none'; }" <?php if( $btn_plgn_options_array [ 'fb_btn_chk' ] != 1 ) echo ''; else echo 'checked="checked"'; ?> /> <label for="fb_btn_chk">Facebook Button</label>
            </div>
				<table class="form-table" id="fb_btn" <?php if( $btn_plgn_options_array [ 'fb_btn_chk' ] != 1 ) echo 'style="display:none;"'; else echo 'style="display:block;"'; ?>>
                    <tr valign="top">
                            <th scope="row"><?php _e( "FaceBook App Id:", 'facebook' ); ?></th>
                            <td>
                                <input name='fcbk_bttn_plgn_app_id' type='text' value='<?php echo $btn_plgn_options_array [ 'fcbk_bttn_plgn_app_id' ] ?>' style="width:200px;" />		
                            </td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( "Display button:", 'facebook' ); ?></th>
						<td>
							<input name='fcbk_bttn_plgn_like' type='checkbox' value='1' <?php if( $btn_plgn_options_array [ 'fcbk_bttn_plgn_like' ] == 1 ) echo 'checked="checked "'; ?>/> <label for="fcbk_bttn_plgn_like"><?php echo __( "Like", 'captcha' ); ?></label><br />
                            <input name='fcbk_bttn_plgn_send' type='checkbox' value='1' <?php if( $btn_plgn_options_array [ 'fcbk_bttn_plgn_send' ] == 1 ) echo 'checked="checked "'; ?>/> <label for="fcbk_bttn_plgn_send"><?php echo __( "Send", 'captcha' ); ?></label><br />
                            <input name='fcbk_bttn_plgn_comment' type='checkbox' value='1' <?php if( $btn_plgn_options_array [ 'fcbk_bttn_plgn_comment' ] == 1 ) echo 'checked="checked "'; ?>/> <label for="fcbk_bttn_plgn_comment"><?php echo __( "Comment", 'captcha' ); ?></label><br />
						</td>
					</tr>
				<!--	<tr>
						<th>
							<?php echo __( "Choose display option:", 'facebook' ); ?>
						</th>
						<td>
							<select name="fcbk_bttn_plgn_display_option" onchange="if ( this . value == 'custom' ) { getElementById ( 'fcbk_bttn_plgn_display_option_custom' ) . style.display = 'block'; } else { getElementById ( 'fcbk_bttn_plgn_display_option_custom' ) . style.display = 'none'; }" style="width:200px;" >
								<option <?php if ( $btn_plgn_options_array [ 'fcbk_bttn_plgn_display_option' ] == 'standart' ) echo 'selected="selected"'; ?> value="standart"><?php echo __( "Standart FaceBook image", 'facebook' ); ?></option>
								<?php if( $copy || $btn_plgn_options_array [ 'fcbk_bttn_plgn_display_option' ] == 'custom' ) { ?>
								<option <?php if ( $btn_plgn_options_array [ 'fcbk_bttn_plgn_display_option' ] == 'custom' ) echo 'selected="selected"'; ?> value="custom"><?php echo __( "Custom FaceBook image", 'facebook' ); ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<th>
							<?php echo __( "Current image:", 'facebook' ); ?>
						</th>
						<td>
							<img src="<?php echo $btn_plgn_options_array [ 'fb_img_link' ]; ?>" style="margin-left:2px;" />
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div id="fcbk_bttn_plgn_display_option_custom" <?php if ( $btn_plgn_options_array [ 'fcbk_bttn_plgn_display_option' ] == 'custom' ) { echo ( 'style="display:block"' ); } else {echo ( 'style="display:none"' ); }?>>
								<table>
									<th style="padding-left:0px;font-size:13px;">
										<input type="hidden" name="MAX_FILE_SIZE" value="64000"/>
										<input type="hidden" name="home" value="<?php echo ABSPATH ; ?>"/>
										<?php echo __( "FaceBook image:", 'facebook' ); ?>
									</th>
									<td>
										<input name="uploadfile" type="file" style="width:196px;" /><br />
										<span style="color: rgb(136, 136, 136); font-size: 10px;"><?php echo __( 'Image properties: max image width:100px; max image height:40px; max image size:32Kb; image types:"jpg", "jpeg".', 'facebook' ); ?></span>	
									</td>
								</table>											
							</div>
						</td>
					</tr>-->
				</table>
            
            
            
            <div style=" font-size: 14px;font-weight: bold;padding: 20px 0 0;">
            	<input name='tw_btn_chk' type='checkbox' value='1' onclick="if ( this . checked == true ) { getElementById ( 'tw_btn' ) . style.display = 'block'; } else { getElementById ( 'tw_btn' ) . style.display = 'none'; }" <?php if( $btn_plgn_options_array [ 'tw_btn_chk' ] == 1 ) echo 'checked="checked "'; ?>/> <label for="te_btn_chk">Twitter Button</label>
            </div>
				<table class="form-table" id="tw_btn" <?php if( $btn_plgn_options_array [ 'tw_btn_chk' ] == 1 ) echo 'style="display:block;"'; else echo 'style="display:none;"'; ?>>
                    <tr valign="top">
                            <th scope="row"></th>
                            <td>
                                <input name='tw_btn_count' type='checkbox' value='1' <?php if( $btn_plgn_options_array [ 'tw_btn_count' ] == '' ) echo 'checked="checked "'; ?>/> <label for="tw_btn_count">Show Count</label>		
                            </td>
					</tr>
                     <tr valign="top">
                            <th scope="row"></th>
                            <td>
                                <input name='tw_btn_large' type='checkbox' value='1' <?php if( $btn_plgn_options_array [ 'tw_btn_large' ] == 'large' ) echo 'checked="checked "'; ?>/> <label for="tw_btn_large">Large Button</label>		
                            </td>
					</tr>
					<tr valign="top">
						<th scope="row">Via</th>
						<td>
							<input name='tw_btn_via' type='text' value='<?php echo $btn_plgn_options_array [ 'tw_btn_via' ]; ?>' style="width:200px;" placeholder="@Twitter Username"/>
						</td>
					</tr>
					
				</table>
                
            <div style=" font-size: 14px;font-weight: bold;padding: 20px 0 0;">
            	<input name='gplus_btn_chk' type='checkbox' value='1' onclick="if ( this . checked == true ) { getElementById ( 'gplus_btn' ) . style.display = 'block'; } else { getElementById ( 'gplus_btn' ) . style.display = 'none'; }" <?php if( $btn_plgn_options_array [ 'gplus_btn_chk' ] == 1 ) echo 'checked="checked"'; ?>/> <label for="gplus_btn_chk">Google Button</label>
            </div>
				<table class="form-table" id="gplus_btn" <?php if( $btn_plgn_options_array [ 'gplus_btn_chk' ] == 1 ) echo 'style="display:block;"'; else echo 'style="display:none;"'; ?>>
                    <tr valign="top">
                            <th scope="row">Annotation:</th>
                            <td>
                                <select name="gplus_btn_annotation">	
                                	<option value="none" <?php if( $btn_plgn_options_array [ 'gplus_btn_annotation' ] == "none" ) echo 'selected="selected"';?>>None</option>
                                    <option value="bubble" <?php if( $btn_plgn_options_array [ 'gplus_btn_annotation' ] == "bubble" ) echo 'selected="selected"';?>>Bubble(Horizontal)</option>
                                    <option value="bubble-vertical" <?php if( $btn_plgn_options_array [ 'gplus_btn_annotation' ] == "bubble-vertical" ) echo 'selected="selected"';?>>Bubble(Vertical)</option>
                                    <option value="inline" <?php if( $btn_plgn_options_array [ 'gplus_btn_annotation' ] == "inline" ) echo 'selected="selected"';?>>Inline</option>
                                </select>	
                            </td>
					</tr>
                     <tr valign="top">
                            <th scope="row">Size:</th>
                            <td>
                                <input name='gplus_btn_size' type='radio' value='15' <?php if( $btn_plgn_options_array [ 'gplus_btn_size' ] == 15 ) echo 'checked="checked "'; ?>/> <label for="gplus_btn_size">Small</label>	
                                <input name='gplus_btn_size' type='radio' value='' <?php if( $btn_plgn_options_array [ 'gplus_btn_size' ] == "" ) echo 'checked="checked "'; ?>/> <label for="gplus_btn_size">Medium</label>	
                                <input name='gplus_btn_size' type='radio' value='24' <?php if( $btn_plgn_options_array [ 'gplus_btn_size' ] == 24 ) echo 'checked="checked "'; ?>/> <label for="gplus_btn_size">Large</label>		
                            </td>
					</tr>
					
					
				</table>
                
            <div style=" font-size: 14px;font-weight: bold;padding: 20px 0 0;">
            	<input name='li_btn_chk' type='checkbox' value='1' onclick="if ( this . checked == true ) { getElementById ( 'li_btn' ) . style.display = 'block'; } else { getElementById ( 'li_btn' ) . style.display = 'none'; }" <?php if( $btn_plgn_options_array [ 'li_btn_chk' ] == 1 ) echo 'checked="checked"'; ?>/> <label for="li_btn_chk">Linked In Button</label>
            </div>
				<table class="form-table" id="li_btn" <?php if( $btn_plgn_options_array [ 'li_btn_chk' ] == 1 ) echo 'style="display:block;"'; else echo 'style="display:none;"'; ?>>
                    <tr valign="top">
                            <th scope="row">Count Mode:</th>
                            <td>
                                <select name="li_btn_count">	
                                	<option value="" <?php if( $btn_plgn_options_array [ 'li_btn_count' ] == "" ) echo 'selected="selected"';?>>No Count</option>
                                    <option value="right" <?php if( $btn_plgn_options_array [ 'li_btn_count' ] == "right" ) echo 'selected="selected"';?>>Horizontal</option>
                                    <option value="top" <?php if( $btn_plgn_options_array [ 'li_btn_count' ] == "top" ) echo 'selected="selected"';?>>Vertical</option>
                                  
                                </select>	
                            </td>
					</tr>
              		
					
					
				</table>
                <div style=" font-size: 14px;font-weight: bold;padding: 20px 0 0;">
            		
                    <table class="form-table">
                        <tr>
                            <th>
                                Button Position:
                            </th>
                            <td>
                                <select name="fcbk_bttn_plgn_where" style="width:200px;" >
                                    <option <?php if ( $btn_plgn_options_array [ 'fcbk_bttn_plgn_where' ] == 'before' ) echo 'selected="selected"'; ?> value="before"><?php echo __( "Before", 'facebook' ); ?></option>
                                    <option <?php if ( $btn_plgn_options_array [ 'fcbk_bttn_plgn_where' ] == 'after' ) echo 'selected="selected"'; ?> value="after"><?php echo __( "After", 'facebook' ); ?></option>
                                    <!--<option <?php if ( $btn_plgn_options_array [ 'fcbk_bttn_plgn_where' ] == 'beforeandafter' ) echo 'selected="selected"'; ?> value="beforeandafter"><?php echo __( "Before and After", 'facebook' ); ?></option>-->
                                </select>
                                
                            </td>
                        </tr>
                     </table>
            	</div>
                <table class="form-table">
                	<tr>
						<td colspan="2">
							<input type="hidden" name="btn_plgn_form_submit" value="submit" />
							<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
						</td>
					</tr>
				</table>
				<?php wp_nonce_field( plugin_basename(__FILE__), 'fcbk_bttn_plgn_nonce_name' ); ?>
			</form>
		</div>
	</div>

	<?php
	}
}

//Function 'facebook_fcbk_bttn_plgn_display_option' reacts to changes type of picture (Standard or Custom) and generates link to image, link transferred to array 'btn_plgn_options_array'
if( ! function_exists( 'fcbk_bttn_plgn_update_option' ) ) {
	function fcbk_bttn_plgn_update_option () {
		global $btn_plgn_options_array;
		if ( $btn_plgn_options_array [ 'fcbk_bttn_plgn_display_option' ] == 'standart' ){
			$fb_img_link	=	plugins_url( 'img/standart-facebook-ico.jpg', __FILE__ );
		} else if ( $btn_plgn_options_array [ 'fcbk_bttn_plgn_display_option' ] == 'custom'){
			$fb_img_link	=	plugins_url( 'img/facebook-ico'.$btn_plgn_options_array [ 'fcbk_bttn_plgn_count_icon' ].'.jpg', __FILE__ );
		}
		$btn_plgn_options_array [ 'fb_img_link' ]	=	$fb_img_link ;
		update_option( "btn_plgn_options_array", $btn_plgn_options_array );
	}
}

//Function 'facebook_button' taking from array 'btn_plgn_options_array' necessary information to create FaceBook Button and reacting to your choise in plugin menu - points where it appears.
if( ! function_exists( 'fcbk_bttn_plgn_display_button' ) ) {
	function fcbk_bttn_plgn_display_button ( $content ) {
		global $post;
		//Query the database to receive array 'btn_plgn_options_array' and receiving necessary information to create button
		$btn_plgn_options_array	=	get_option ( 'btn_plgn_options_array' );
		$fcbk_bttn_plgn_where			=	$btn_plgn_options_array [ 'fcbk_bttn_plgn_where' ];
		$img				=	$btn_plgn_options_array [ 'fb_img_link' ];
		$url				=	$btn_plgn_options_array [ 'fcbk_bttn_plgn_link' ];	
		$permalink_post		=	get_permalink ( $post->ID );
		//Button
		$button				=	'<div id="fcbk_share">';
		
		if( $btn_plgn_options_array [ 'fb_btn_chk' ] == 1 ) {
			if( $btn_plgn_options_array [ 'fcbk_bttn_plgn_send' ] == 1 ) { $send = "true";}else $send = "false";
			$button .=	'<div class="fcbk_like">
										
										<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId='.$btn_plgn_options_array [ 'fcbk_bttn_plgn_app_id' ].'";
  fjs.parentNode.insertBefore(js, fjs);
}(document, "script", "facebook-jssdk"));</script>
<div class="fb-like" data-href="' . $permalink_post . '" data-layout="button_count" data-action="like" data-show-faces="true" data-share="'.$send.'"></div>					
									</div>';
		}	
		if( $btn_plgn_options_array [ 'tw_btn_chk' ] == 1 ) {
			$button .=	'<div class="fcbk_button">
							<a href="https://twitter.com/share" class="twitter-share-button" data-url="' . $permalink_post . '" data-text="'.$post->title.'" data-via="'.$btn_plgn_options_array [ 'tw_btn_via'].'" data-size="'.$btn_plgn_options_array [ 'tw_btn_large'].'" data-count="'.$btn_plgn_options_array [ 'tw_btn_count'].'"></a>
							<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
									</div>';
		}	
		
		if( $btn_plgn_options_array [ 'li_btn_chk' ] == 1 ) {
			$button .=	'<div class="fcbk_button linkedin">
							<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
<script type="IN/Share" data-url="'.$permalink_post.'" data-counter="'.$btn_plgn_options_array [ 'li_btn_count' ].'"></script>
									</div>';
		}			
		
		if( $btn_plgn_options_array [ 'gplus_btn_chk' ] == 1 ) {
			$button .=	'<div class="fcbk_button googleplus">
							<div class="g-plus" data-action="share" data-height="'.$btn_plgn_options_array [ 'gplus_btn_size' ].'" data-href="'.$permalink_post.'" data-annotation="'.$btn_plgn_options_array [ 'gplus_btn_annotation' ].'"></div>


							<script type="text/javascript">
							  (function() {
								var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
								po.src = "https://apis.google.com/js/plusone.js";
								var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
							  })();
							</script>
									</div>';
		}	
		$button .= '</div>';
		if( $btn_plgn_options_array [ 'fb_btn_chk' ] == 1 && $btn_plgn_options_array [ 'fcbk_bttn_plgn_comment' ] == 1 && is_single()) {
			add_filter( 'comments_template', 'dummy_comments_template');
			$commentBox =	'<div style="padding:0;">
							<div id="fb-root"></div>
							<script>(function(d, s, id) {
							  var js, fjs = d.getElementsByTagName(s)[0];
							  if (d.getElementById(id)) return;
							  js = d.createElement(s); js.id = id;
							  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId='.$btn_plgn_options_array [ 'fcbk_bttn_plgn_app_id' ].'";
							  fjs.parentNode.insertBefore(js, fjs);
							}(document, "script", "facebook-jssdk"));</script>
							<div class="fb-comments" data-href="'.$permalink_post.'" data-width="470" data-num-posts="1"></div>
						 </div>';
		}	
		

		
		//Indication where show FaceBook Button depending on selected item in admin page.
		if ( $fcbk_bttn_plgn_where == 'before' ) {
			return $button . $content.$commentBox; 
		} else if ( $fcbk_bttn_plgn_where == 'after' ) {		
			return $content . $button.$commentBox;
		} else if ( $fcbk_bttn_plgn_where == 'beforeandafter' ) {		
			return $button . $content . $button.$commentBox;
		} else if ( $fcbk_bttn_plgn_where == 'shortcode' ) {
			return $content;		
		} else {
			return $content;		
		}
	}
}

function dummy_comments_template() {
		return dirname( __FILE__ ) . '/includes/comments-template.php';
	}
//Function 'fcbk_bttn_plgn_shortcode' are using to create shortcode by FaceBook Button.
if( ! function_exists( 'fcbk_bttn_plgn_shortcode' ) ) {
	function fcbk_bttn_plgn_shortcode( $content ) {
		$btn_plgn_options_array	=	get_option ( 'btn_plgn_options_array' );
		$fcbk_bttn_plgn_where			=	$btn_plgn_options_array [ 'fcbk_bttn_plgn_where' ];	
		$img				=	$btn_plgn_options_array [ 'fb_img_link' ];
		$url				=	$btn_plgn_options_array [ 'fcbk_bttn_plgn_link' ];	
		$permalink_post		=	get_permalink ( $post_ID );
		$button				=	'<div id="fcbk_share">';
		if( $btn_plgn_options_array [ 'fcbk_bttn_plgn_my_page' ] == 1 ) {
			$button .=	'<div class="fcbk_button">
										<a name="fcbk_share"	href="http://www.facebook.com/' . $url . '"	target="blank">
											<img src="' . $img . '" alt="Fb-Button" />
										</a>	
									</div>';
		}
		if( $btn_plgn_options_array [ 'fcbk_bttn_plgn_like' ] == 1 ) {
			$button .=	'<div class="fcbk_like">
										<div id="fb-root"></div>
										<script src="http://connect.facebook.net/en_US/all.js#appId='.$btn_plgn_options_array [ 'fcbk_bttn_plgn_app_id' ].'&amp;xfbml=1"></script>
										<fb:like href="' . $permalink_post . '" send="false" layout="button_count" width="450" show_faces="false" font=""></fb:like>
									</div>';
		}				
		
		$button .= '</div>';		 
		return $button;	
	}
}

//Function 'fcbk_bttn_plgn_action_links' are using to create action links on admin page.
if( ! function_exists( 'fcbk_bttn_plgn_action_links' ) ) {
	function fcbk_bttn_plgn_action_links( $links, $file ) {
			//Static so we don't call plugin_basename on every plugin row.
		static $this_plugin;
		if ( ! $this_plugin ) $this_plugin = plugin_basename(__FILE__);

		if ( $file == $this_plugin ){
				 $settings_link = '<a href="admin.php?page=advance-social-sharer.php">' . __( 'Settings', 'facebook' ) . '</a>';
				 array_unshift( $links, $settings_link );
			}
		return $links;
	}
} // end function fcbk_bttn_plgn_action_links

//Function 'fcbk_bttn_plgn_links' are using to create other links on admin page.
if ( ! function_exists ( 'fcbk_bttn_plgn_links' ) ) {
	function fcbk_bttn_plgn_links($links, $file) {
		$base = plugin_basename(__FILE__);
		if ($file == $base) {
			$links[] = '<a href="admin.php?page=advance-social-sharer.php">' . __( 'Settings','facebook' ) . '</a>';
			$links[] = '<a href="http://wordpress.org/extend/plugins/advance-social-sharer/faq/" target="_blank">' . __( 'FAQ','facebook' ) . '</a>';
			$links[] = '<a href="Mailto:plsakaria@yahoo.in">' . __( 'Support','facebook' ) . '</a>';
		}
		return $links;
	}
} // end function fcbk_bttn_plgn_links

//Function '_plugin_init' are using to add language files.
if ( ! function_exists ( 'fcbk_plugin_init' ) ) {
	function fcbk_plugin_init() {
		load_plugin_textdomain( 'facebook', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
	}
} // end function fcbk_plugin_init


if ( ! function_exists ( 'fcbk_admin_head' ) ) {
	function fcbk_admin_head() {
		wp_register_style( 'fcbkStylesheet', plugins_url( 'css/style.css', __FILE__ ) );
		wp_enqueue_style( 'fcbkStylesheet' );
	}
}

/**
 * Add Open Graph protocol markup to <head>
 *
 * @since 1.0
 */
function fb_add_og_protocol() {
	global $post;

	$meta_tags = array(
		'http://ogp.me/ns#locale' => 'en_US',
		'http://ogp.me/ns#site_name' => get_bloginfo( 'name' ),
		'http://ogp.me/ns#type' => 'website'
	);
	
	if ( is_home() || is_front_page() ) {
		$meta_tags['http://ogp.me/ns#title'] = get_bloginfo( 'name' );
		$meta_tags['http://ogp.me/ns#description'] = get_bloginfo( 'description' );
	} else if ( is_single() ) {
		$post_type = get_post_type();
		$meta_tags['http://ogp.me/ns#type'] = 'article';
		$meta_tags['http://ogp.me/ns#url'] = apply_filters( 'rel_canonical', get_permalink() );
		if ( post_type_supports( $post_type, 'title' ) )
			$meta_tags['http://ogp.me/ns#title'] = get_the_title();
		if ( post_type_supports( $post_type, 'excerpt' ) ) {
			// thanks to Angelo Mandato (http://wordpress.org/support/topic/plugin-facebook-plugin-conflicts-with-powerpress?replies=16)
			// Strip and format the wordpress way, but don't apply any other filters which adds junk that ends up getitng stripped back out
			if ( !post_password_required($post) ) {
				// First lets get the post excerpt (shouldn't have any html, but anyone can enter anything...)
				$meta_tags['http://ogp.me/ns#description'] = fb_strip_and_format_desc ( $post );
			}
		}
		
		$meta_tags['http://ogp.me/ns/article#published_time'] = get_the_date('c');
		$meta_tags['http://ogp.me/ns/article#modified_time'] = get_the_modified_date('c');
		
		if ( post_type_supports( $post_type, 'author' ) && isset( $post->post_author ) )
			$meta_tags['http://ogp.me/ns/article#author'] = get_author_posts_url( $post->post_author );

		// add the first category as a section. all other categories as tags
		$cat_ids = get_the_category();
		
		if ( ! empty( $cat_ids ) ) {
			$cat = get_category( $cat_ids[0] );
			
			if ( ! empty( $cat ) )
				$meta_tags['http://ogp.me/ns/article#section'] = $cat->name;

			//output the rest of the categories as tags
			unset( $cat_ids[0] );
			
			if ( ! empty( $cat_ids ) ) {
				$meta_tags['http://ogp.me/ns/article#tag'] = array();
				foreach( $cat_ids as $cat_id ) {
					$cat = get_category( $cat_id );
					$meta_tags['http://ogp.me/ns/article#tag'][] = $cat->name;
					unset( $cat );
				}
			}
		}

		// add tags. treat tags as lower priority than multiple categories
		$tags = get_the_tags();
		
		if ( $tags ) {
			if ( ! array_key_exists( 'http://ogp.me/ns/article#tag', $meta_tags ) )
				$meta_tags['http://ogp.me/ns/article#tag'] = array();
				
			foreach ( $tags as $tag ) {
				$meta_tags['http://ogp.me/ns/article#tag'][] = $tag->name;
			}
		}

		// does current post type and the current theme support post thumbnails?
		if ( post_type_supports( $post_type, 'thumbnail' ) && function_exists( 'has_post_thumbnail' ) && has_post_thumbnail() ) {
			list( $post_thumbnail_url, $post_thumbnail_width, $post_thumbnail_height ) = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			
			if ( ! empty( $post_thumbnail_url ) ) {
				$image = array( 'url' => $post_thumbnail_url );

				if ( ! empty( $post_thumbnail_width ) )
					$image['width'] = absint( $post_thumbnail_width );

				if ( ! empty($post_thumbnail_height) )
					$image['height'] = absint( $post_thumbnail_height );
					
				$meta_tags['http://ogp.me/ns#image'] = array( $image );
			}
		}
	}
	else if ( is_author() && isset( $post->post_author ) ) {
		$meta_tags['http://ogp.me/ns#type'] = 'profile';
		$meta_tags['http://ogp.me/ns/profile#first_name'] = get_the_author_meta( 'first_name', $post->post_author );
		$meta_tags['http://ogp.me/ns/profile#last_name'] = get_the_author_meta( 'last_name', $post->post_author );
		if ( is_multi_author() )
			$meta_tags['http://ogp.me/ns/profile#username'] = get_the_author_meta( 'login', $post->post_author );
	}
	else if ( is_page() ) {
		$meta_tags['http://ogp.me/ns#type'] = 'article';
		$meta_tags['http://ogp.me/ns#title'] = get_the_title();
		$meta_tags['http://ogp.me/ns#url'] = apply_filters( 'rel_canonical', get_permalink() );
	}

	$options = get_option( 'fb_options' );
	
	if ( ! empty( $options['app_id'] ) )
		$meta_tags['http://ogp.me/ns/fb#app_id'] = $options['app_id'];

	$meta_tags = apply_filters( 'fb_meta_tags', $meta_tags, $post );

	foreach ( $meta_tags as $property => $content ) {
		fb_output_og_protocol( $property, $content );
	}
}

function fb_strip_and_format_desc( $post ) {
	
	$desc_no_html = "";
	$desc_no_html = strip_shortcodes( $desc_no_html ); // Strip shortcodes first in case there is HTML inside the shortcode
        $desc_no_html = wp_strip_all_tags( $desc_no_html ); // Strip all html
        $desc_no_html = trim( $desc_no_html ); // Trim the final string, we may have stripped everything out of the post so this will make the value empty if that's the case

	// Check if empty, may be that the strip functions above made excerpt empty, doubhtful but we want to be 100% sure.
	if( empty($desc_no_html) ) {
		$desc_no_html = $post->post_content; // Start over, this time with the post_content
		$desc_no_html = strip_shortcodes( $desc_no_html ); // Strip shortcodes first in case there is HTML inside the shortcode
		$desc_no_html = str_replace(']]>', ']]&gt;', $desc_no_html); // Angelo Recommendation, if for some reason ]]> happens to be in the_content, rare but We've seen it happen
		$desc_no_html = wp_strip_all_tags($desc_no_html);
		$excerpt_length = apply_filters('excerpt_length', 55);
		$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
		$desc_no_html = wp_trim_words( $desc_no_html, $excerpt_length, $excerpt_more );
		$desc_no_html = trim($desc_no_html); // Trim the final string, we may have stripped everything out of the post so this will make the value empty if that's the case
	}
	
	$desc_no_html = str_replace( array( "\r\n", "\r", "\n" ), ' ',$desc_no_html); // I take it Facebook doesn't like new lines?
	return $desc_no_html;
}

function fb_output_og_protocol( $property, $content ) {
	if ( empty( $property ) || empty( $content ) )
		return;

	// array of property values or structured property
	if ( is_array( $content ) ) {
		foreach( $content as $structured_property => $content_value ) {
			// handle numeric keys from regular arrays
			// account for the special structured property of url which is equivalent to the root tag and sets up the structure
			if ( ! is_string( $structured_property ) || $structured_property === 'url' )
				fb_output_og_protocol( $property, $content_value );
			else
				fb_output_og_protocol( $property . ':' . $structured_property, $content_value );
		}
	}
	else {
		echo "<meta property=\"$property\" content=\"" . esc_attr( $content ) . "\" />\n";
	}
}

add_action( 'wp_head', 'fb_add_og_protocol' );

//Add language files
add_action( 'init', 'fcbk_plugin_init' );

add_action( 'wp_enqueue_scripts', 'fcbk_admin_head' );
add_action( 'admin_enqueue_scripts', 'fcbk_admin_head' );

// adds "Settings" link to the plugin action page
add_filter( 'plugin_action_links', 'fcbk_bttn_plgn_action_links', 10, 2 );

//Additional links on the plugin page
add_filter( 'plugin_row_meta', 'fcbk_bttn_plgn_links', 10, 2 );

//Calling a function add administrative menu.
add_action( 'admin_menu', 'fcbk_bttn_plgn_add_pages' );

//Add shortcode.
add_shortcode( 'fb_button', 'fcbk_bttn_plgn_shortcode' );

//Add settings links.
add_filter( 'the_content', 'fcbk_bttn_plgn_display_button' );

