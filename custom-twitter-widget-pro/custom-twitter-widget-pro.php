<?php
/*
Plugin Name: Custom twitter widget pro
Description: Display twitter feed on your WordPress site by using this plugin. Simply add your user name in widget setting. 
Version: 2.4
Author: Techvers
Author URI: http://techvers.com/
License: GPLv2 or later
Text Domain: custom-twitter-widget-pro
*/





		// Define plugin url 
	define( 'Etw_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	define( 'Etw_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	
	//call default data
	require_once(Etw_PLUGIN_DIR.'/default_settings.php');
	
	define("Etw", "custom-twitter-widget-pro");

/**
 * Get Ready Plugin Translation
 */
add_action('plugins_loaded', 'FacebookTranslation');
function FacebookTranslation() {
	load_plugin_textdomain( Etw, FALSE, dirname( plugin_basename(__FILE__)).'/languages/' );
}
	
	// Include requred file 
	require_once(Etw_PLUGIN_DIR.'/twitter-shortcode.php');

	// Register Required css and js 
	add_action( 'admin_init', 'Etw_plugin_scripts' );
	function Etw_plugin_scripts(){
								if( is_admin() ){
								wp_register_script('Etw-twitter-admin-easytab',Etw_PLUGIN_URL.'lib/js/admin-js/jquery.easytabs.min.js');
								wp_register_script('Etw-twiiter-admin-custom-js',Etw_PLUGIN_URL.'lib/js/admin-js/admin-custom-js.js');
								wp_register_script('Etw-twitter-admin-wp-color-js',Etw_PLUGIN_URL.'lib/js/admin-js/admin-wp-color-picker.js');
								wp_register_script( 'custom-script-handle', plugins_url(  'lib/js/admin-js/tech-color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
								wp_register_style('admin_style',Etw_PLUGIN_URL.'lib/style/admin-panel-style.css');
								// Add the color picker css file       
								wp_enqueue_style( 'wp-color-picker' );  
								// Include our custom jQuery file with WordPress Color Picker dependency
								 
								}
	}
	
	// Menu function hook 
	
	//$Menu_status = get_option('Etw_widget_hide_pro_panel'); 
//if($Menu_status != 'on'){
	
	add_action('admin_menu', 'custom_twitter_menu');
//}
	//Menu creation function
	function custom_twitter_menu(){

									$Etw_twitter_hook_suffix =  add_menu_page(__('Custom Twitter','Etw'), __('Custom Twitter','Etw'), 'manage_options', 'custom-twitter', 'tech_twitter_output' );

									add_action('admin_print_scripts-' . $Etw_twitter_hook_suffix, 'tech_twitter_admin_scripts');
		
		}

	// Enque required css and js	
	function tech_twitter_admin_scripts() {
			/* Link our already registered script to a page */
			wp_enqueue_script( 'Etw-twitter-admin-easytab' );
			wp_enqueue_script( 'Etw-twiiter-admin-custom-js' );
			wp_enqueue_script('Etw-twitter-admin-wp-color-js');
			wp_enqueue_script( 'custom-script-handle' );
			wp_enqueue_style( 'wp-color-picker' ); 
			wp_enqueue_style( 'admin_style' ); 
		}
		
		

	// Create option panel		
	function tech_twitter_output(){
	?>
		<body>
			<h2>custom twitter Premium Settings.<span ><a style="color: red;"target="_blank" href="http://techvers.com/custom-twitter-pro/" 14px;"=""><span>Buy our pro plugin just in 2$</a> </span></h2>
			<!-- <span style="color:red;"> This is premium version settings demo panel if you dont like this you can hide this from widegt.</span><br><span style="color:blue;"> go to > widget> custom facebook widget pro > Hide custom facebok pro setting pane "checked this check box"</span> -->
			
			<div id="tab-container" class='tab-container'>
				<ul class='etabs'>
				   <li class='tab'><a href="#tabs1-Gsettings">Twitter shortcode settings </a></li>
				   <li class='tab'><a href="#tabs1-sticky-fb-box">Twitter sticky box settings</a></li>
				   <li class='tab'><a href="#tabs1-Design">Custom css and js </a></li>
				   <li class='tab'><a href="#tab1-show-love">Suppot and Help</a></li>
	   
				</ul>
				<div class='panel-container'>
					<div id="tabs1-Gsettings">
					
					<?php if(isset($_POST['TGsettings'])){
							$ETWP_settings = array();
							$ETWP_settings = get_option('ETWP_settings');
							$ETWP_settings['ETWP_user_name'] = $_POST['ETWP_user_name'];
							$ETWP_settings['ETWP_url_link_color'] = $_POST['ETWP_url_link_color'];
							$ETWP_settings['Etw_twitter_id'] = '634434836409614336';
							$ETWP_settings['ETWP_theme_border_color'] = $_POST['ETWP_theme_border_color'];
							
							// update options
							update_option('ETWP_settings',$ETWP_settings);

							}
						?>
						
						<form  name="ETWP_form" method="post"><?php $ETWP_settings = get_option('ETWP_settings');?>
							<h2>Settings</h2>
							<table class="form-table">
								<tr valign="top">
									<th scope="row"><label><?php _e('Twitter user name:','ETWP');?> </label></th>
									<td><input type="text" id="ETWP_user_name"  name="ETWP_user_name" value="<?php esc_attr_e($ETWP_settings['ETWP_user_name']); ?>" /></td></td>
								</tr>
								
								
			 
								<tr valign="top">
									<th scope="row"><label><?php _e('Theme:','ETWP');?> </label></th>
									<td>
										<select name="ETWP_twitter_theme" disabled="" style="width:70px;">
										<option value="dark"><?php _e('dark'); ?></option>
											<option value="light"><?php _e('light'); ?></option>
								
										</select><span>&nbsp &nbsp <a target="_blank" href="http://techvers.com/custom-twitter-pro/">Upgrade to pro</a></span></td>
									</td>
								</tr>
			
								<tr valign="top">
									<th scope="row"><label> <?php _e('Height:','ETWP')?> </label></th>
									<td>
										<input type="text" id="ETWP_height" disabled=""  name="ETWP_height" value="" size="5" /><span>&nbsp &nbsp <a target="_blank" href="http://techvers.com/custom-twitter-pro/">Upgrade to pro</a></span></td>
			  
									</td>
								</tr>
								
								
			
								<tr valign="top">
									<th scope="row"><label> <?php _e('Width:','ETWP');?> </label></th>
									<td>
										<input type="text" id="ETWP_width"  name="ETWP_width" disabled="" value="" size="5" /><span>&nbsp &nbsp <a target="_blank" href="http://techvers.com/custom-twitter-pro/">Upgrade to pro</a></span></td>
									</td>
								</tr>
			
								<tr valign="top">
										<th scope="row"><label> <?php _e('Url link color:','ETWP');?></label></th>
									<td>
										<input type="text" id="ETWP_url_link_color" class="color-field"  name="ETWP_url_link_color"  value="<?php esc_attr_e($ETWP_settings['ETWP_url_link_color']); ?>" size="5" /></td>
									</td>
								</tr>
			<!--
								<tr valign="top">
									<th scope="row"><label> <?php _e('Theme Border:','ETWP');?> </label></th>
									<td>
										<select name="ETWP_theme_boder" style="width:70px;">
											<option value="0" <?php //if($ETWP_settings['ETWP_theme_boder'] == "0") echo 'selected="selected"' ?> >0</option>
											<option value="1" <?php //if($ETWP_settings['ETWP_theme_boder'] == "1") echo 'selected="selected"' ?> >1</option>
											<option value="2" <?php //if($ETWP_settings['ETWP_theme_boder'] == "2") echo 'selected="selected"' ?> >2</option>
											<option value="3" <?php //if($ETWP_settings['ETWP_theme_boder'] == "3") echo 'selected="selected"' ?> >3</option>
											<option value="4" <?php //if($ETWP_settings['ETWP_theme_boder'] == "4") echo 'selected="selected"' ?> >4</option>
											<option value="5" <?php //if($ETWP_settings['ETWP_theme_boder'] == "5") echo 'selected="selected"' ?> >5</option>
											<option value="6" <?php //if($ETWP_settings['ETWP_theme_boder'] == "6") echo 'selected="selected"' ?> >6</option>
										</select> px
									</td>
								</tr>
								-->
								<tr valign="top">
										<th scope="row"><label> <?php _e('Theme border color:','ETWP');?></label></th>
									<td>
										<input type="text" id="ETWP_theme_border_color" class="color-field"  name="ETWP_theme_border_color"  value="<?php esc_attr_e($ETWP_settings['ETWP_theme_border_color']); ?>" size="5" /></td>
									</td>
								</tr>
			
								
								<tr valign="top">
									<th scope="row"><label> <?php _e('Show Reply:','ETWP');?> </label></th>
									<td>
										<select name="ETWP_show_reply"style="width:70px;" disabled="" >
											<option value="yes" ><?php _e('Yes'); ?></option>
											<option value="no" ><?php _e('No'); ?></option>
										</select><span>&nbsp &nbsp <a target="_blank" href="http://techvers.com/custom-twitter-pro/">Upgrade to pro</a></span></td>
									</td>
								</tr>
			
								<tr valign="top">
									<th scope="row"><label> <?php _e('Like box language:','ETWP');?> </label></th>
									<td>
										<input type="text" id="ETWP_theme_like_box_lang" disabled=""  name="ETWP_theme_like_box_lang" value=""/>(en_US,de_DE...)<span>&nbsp &nbsp <a target="_blank" href="http://techvers.com/custom-twitter-pro/">Upgrade to pro</a></span></td>
									</td>
								</tr>
		   
							</table>
							<input type="submit" name="TGsettings" value="Save Changes" class="button button-primary"/>
						</form> 



					</div>
					<div id="tabs1-Design">
	   
						 

						<form  name="CustomCssAndJs" method="post">

							<table class="form-table">
								<tbody>
									<tr valign="top">
										<td style="padding-bottom: 0;">
											<strong style="font-size: 15px;">Custom CSS</strong><br><strong style="font-size: 12px;">
										</td>
									</tr>
									
									<tr valign="top">
										<td>
											<textarea name="ETWP_twitter_custom_css" id="ETWP_twitter_custom_css" disabled="tue"  style="width: 70%;" rows="7"></textarea><span>&nbsp &nbsp <a target="_blank" href="http://techvers.com/custom-twitter-pro/">Upgrade to pro</a></span>
										</td>
									</tr>
									
									<tr valign="top">
										<td style="padding-bottom: 0;">
											<strong style="font-size: 15px;">Custom JavaScript</strong><br><strong style="font-size: 12px;"></td>
										</tr>
										<tr valign="top">
											<td>
												<textarea name="ETWP_twitter_custom_js" id="ETWP_twitter_custom_js" disabled="" style="width: 70%;" rows="7"></textarea><span>&nbsp &nbsp <a target="_blank" href="http://techvers.com/custom-twitter-pro/">Upgrade to pro</a></span>
											</td>
										</tr>
								</tbody>
							</table>
							<input type="submit" name="CustomCssAndJs" value="Save Changes" class="button button-primary"/>
						</form> 
					</div>
	  
					<div id="tabs1-sticky-fb-box">
						<?php if(isset($_POST['TSsettings'])){
							$ETWP_settings = array();
							
							$ETWP_settings = get_option('ETWP_twitter_sticky_settings');
							$ETWP_settings['ETWP_sticky_enable_setting'] = $_POST['ETWP_sticky_enable_setting'];
							$ETWP_settings['ETWP_user_name'] = $_POST['ETWP_user_name'];
							$ETWP_settings['ETWP_url_link_color'] = $_POST['ETWP_url_link_color'];
							$ETWP_settings['Etw_twitter_id'] = '634434836409614336';
							$ETWP_settings['ETWP_theme_border_color'] = $_POST['ETWP_theme_border_color'];
							
							
							
						update_option('ETWP_twitter_sticky_settings',$ETWP_settings);
						}?>
						
						<form  name="ETWP_form" method="post"><?php $ETWP_settings = get_option('ETWP_twitter_sticky_settings');?>
							<h2>Settings</h2>
							<table class="form-table">
							<tr valign="top">
									<th scope="row"><label><?php _e('Twitter sticky enable:','ETWP');?> </label></th>
										<td>
											<select name="ETWP_sticky_enable_setting" style="width:70px;">
												<option value="yes" <?php if($ETWP_settings['ETWP_sticky_enable_setting'] == "yes") echo 'selected="selected"' ?> ><?php _e('Yes'); ?></option>
												<option value="no" <?php if($ETWP_settings['ETWP_sticky_enable_setting'] == "no") echo 'selected="selected"' ?> ><?php _e('No'); ?></option>
											</select>
										</td>
								</tr>
								
								<tr valign="top">
									<th scope="row"><label><?php _e('Twitter user name:','ETWP');?> </label></th>
									<td><input type="text" id="ETWP_user_name"  name="ETWP_user_name" value="<?php esc_attr_e($ETWP_settings['ETWP_user_name']); ?>" /></td>
								</tr>
	
								<tr valign="top">
									<th scope="row"><label><?php _e('Theme:','ETWP');?> </label></th>
									<td>
										<select name="ETWP_twitter_theme" disabled="" style="width:70px;">
											<option value="dark"  ><?php _e('dark'); ?></option>
											<option value="light"  ><?php _e('light'); ?></option>
											
										</select><span>&nbsp &nbsp <a target="_blank" href="http://techvers.com/custom-twitter-pro/">Upgrade to pro</a></span>
									</td>
								</tr>

								<tr valign="top">
									<th scope="row"><label> <?php _e('Height:','ETWP')?> </label></th>
									<td>
										<input type="text" id="ETWP_height"  name="ETWP_height" disabled="" value="" size="5" /><span>&nbsp &nbsp <a target="_blank" href="http://techvers.com/custom-twitter-pro/">Upgrade to pro</a></span>
			  
									</td>
								</tr>
								
								<tr valign="top">
									<th scope="row"><label> <?php _e('Width:','ETWP');?> </label></th>
									<td>
										<input type="text" id="ETWP_width" disabled="" name="ETWP_width" value="" size="5" /><span>&nbsp &nbsp <a target="_blank" href="http://techvers.com/custom-twitter-pro/">Upgrade to pro</a></span>
									</td>
								</tr>
			
								<tr valign="top">
										<th scope="row"><label> <?php _e('Url link color:','ETWP');?></label></th>
									<td>
										<input type="text" id="ETWP_url_link_color"  class="color-field"  name="ETWP_url_link_color" value="<?php esc_attr_e($ETWP_settings['ETWP_url_link_color']); ?>" size="5" />
									</td>
								</tr>
			<!--
								<tr valign="top">
									<th scope="row"><label> <?php _e('Theme Border:','ETWP');?> </label></th>
									<td>
										<select name="ETWP_theme_boder" style="width:70px;">
											<option value="0" <?php //if($ETWP_settings['ETWP_theme_boder'] == "0") echo 'selected="selected"' ?> >0</option>
											<option value="1" <?php //if($ETWP_settings['ETWP_theme_boder'] == "1") echo 'selected="selected"' ?> >1</option>
											<option value="2" <?php //if($ETWP_settings['ETWP_theme_boder'] == "2") echo 'selected="selected"' ?> >2</option>
											<option value="3" <?php //if($ETWP_settings['ETWP_theme_boder'] == "3") echo 'selected="selected"' ?> >3</option>
											<option value="4" <?php //if($ETWP_settings['ETWP_theme_boder'] == "4") echo 'selected="selected"' ?> >4</option>
											<option value="5" <?php //if($ETWP_settings['ETWP_theme_boder'] == "5") echo 'selected="selected"' ?> >5</option>
											<option value="6" <?php //if($ETWP_settings['ETWP_theme_boder'] == "6") echo 'selected="selected"' ?> >6</option>
										</select> px
									</td>
								</tr>
								-->
								<tr valign="top">
										<th scope="row"><label> <?php _e('Theme border color:','ETWP');?></label></th>
									<td>
										<input type="text" id="ETWP_theme_border_color" class="color-field"  name="ETWP_theme_border_color" value="<?php esc_attr_e($ETWP_settings['ETWP_theme_border_color']); ?>" size="5" />
									</td>
								</tr>

								<tr valign="top">
									<th scope="row"><label> <?php _e('Show Reply:','ETWP');?> </label></th>
									<td>
										<select name="ETWP_show_reply" disabled="" style="width:70px;">
											<option value="yes"  ><?php _e('Yes'); ?></option>
											<option value="no"  ><?php _e('No'); ?></option>
										</select><span>&nbsp &nbsp <a target="_blank" href="http://techvers.com/custom-twitter-pro/">Upgrade to pro</a></span>
									</td> 
								</tr>
								
								<tr valign="top">
									<th scope="row"><label> <?php _e('Like box language:','ETWP');?> </label></th>
									<td>
										<input type="text" id="ETWP_theme_like_box_lang"  name="ETWP_theme_like_box_lang" disabled="" value=""/>(en_US,de_DE...)<span>&nbsp &nbsp <a target="_blank" href="http://techvers.com/custom-twitter-pro/">Upgrade to pro</a></span>
									</td>
								</tr>
		   
							</table>
							<input type="submit" name="TSsettings" value="Save Changes" class="button button-primary"/>
						</form> 
					</div>
					
					<div id="tab1-show-love">
					
					<p>Support us by show some love. </p>
					<a class="buy-button buy" target="_blank" href="http://techvers.com/custom-twitter-pro/" 14px;"=""><span>$ 2</span>Buy It</a>
					<a class="buy-button rate" target="_blank" href="https://wordpress.org/support/view/plugin-reviews/custom-twitter-widget-pro"><span>* </span>Rate It</a>
					<a class="buy-button buy-package" target="_blank" href="http://techvers.com/" 14px;"=""><span>$ 9</span>Buy All plugin just in $7</a>
					</div>
	 
				</div>
			</div>

		</body>
		<?php
		}


class EtwTwitter_widget extends WP_Widget{
	
		function __construct() {
			parent::__construct(
				'Etw_twitter', 
				'Custom twitter widget pro',
				array( 'description' => __( 'Display latest tweets from your Twitter account', 'Etw' ), ) 
			);
		}
	/**
		* Front-end display of widget.
	 */
		public function widget( $args, $instance ) {
			$defaults = $this->Etw_defaults_settings();
			$instance = wp_parse_args( (array) $instance, $defaults );
			extract($args);
			$title = apply_filters('title', $instance['title']);		
			echo $before_widget;
			if (!empty($title)) {	echo $before_title . $title . $after_title;	}
			$TwitterUserName    =    $instance['Etw_widget_screen_name'];
			$Theme              =   $instance['Etw_widget_theme'];
			$Height             =   $instance['Etw_widget_height'];
			$Width              =   300;
			$LinkColor          =   $instance['Etw_widget_link_color'];
			$ShowTwittsShowReply     =   ($instance['Etw_widget_show_replies'] == 'no')? 'nofooter': '';
			$TwitterWidgetId    =   $instance['Etw_widget_id'];
			$CustomStyle = $instance['Etw_widget_custom_css'];
	
			if( !empty($CustomStyle) ) echo '<!-- Custom Twitter Widget -->';
				if( !empty($CustomStyle) ) echo "\r\n";
				if( !empty($CustomStyle) ) echo '<style type="text/css">';
				if( !empty($CustomStyle) ) echo "\r\n";
				if( !empty($CustomStyle) ) echo stripslashes($CustomStyle);
				if( !empty($CustomStyle) ) echo "\r\n";
				if( !empty($CustomStyle) ) echo '</style>';
				if( !empty($CustomStyle) ) echo "\r\n";
			?>
			<div style="display:block;width:100%;float:left;overflow:hidden">
				<a class="twitter-timeline" data-dnt="true" href="https://twitter.com/twitterdev" min-width="<?php echo $Width; ?>" height="<?php echo $Height; ?>" data-theme="<?php echo $Theme; ?>" data-link-color="<?php echo $LinkColor; ?>" data-widget-id="<?php echo $TwitterWidgetId; ?>" data-screen-name="<?php echo $TwitterUserName; ?>"data-chrome="<?php echo $ShowTwittsShowReply;?>"><?php _e('Tweets By @','Etw'); echo $TwitterUserName; ?> </a>
				<script>
				!function(d,s,id) {
					var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}
				} (document,"script","twitter-wjs");
			</script>
			</div>
			<?php
			echo $after_widget;
		}
	/**
		* Back-end widget form.
    */
		public function form( $instance ) {
		
		$defaults = $this->Etw_defaults_settings();

			/** Merge the user-selected arguments with the defaults. */
			$instance = wp_parse_args( (array) $instance, $defaults );
		
			?>
			<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
			</p>
		
			<p>
				<label for="<?php echo $this->get_field_id( 'Etw_widget_screen_name' ); ?>"><?php _e( 'Twitter Username' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'Etw_widget_screen_name' ); ?>" name="<?php echo $this->get_field_name( 'Etw_widget_screen_name' ); ?>" type="text" value="<?php echo esc_attr( $instance['Etw_widget_screen_name']); ?>">
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'Etw_widget_id' ); ?>"><?php _e( 'Twitter Widget Id' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'Etw_widget_id' ); ?>" name="<?php echo $this->get_field_name( 'Etw_widget_id' ); ?>" type="text" value="<?php echo esc_attr( $instance['Etw_widget_id'] ); ?>">
				
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'Etw_widget_theme' ); ?>"><?php _e( 'Theme' ); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'Etw_widget_theme' ); ?>" name="<?php echo $this->get_field_name( 'Etw_widget_theme' ); ?>">
					<option value="light" <?php if($instance['Etw_widget_theme'] == "light") echo "selected=selected" ?>>Light</option>
					<option value="dark" <?php if($instance['Etw_widget_theme'] == "dark") echo "selected=selected" ?>>Dark</option>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'Etw_widget_height' ); ?>"><?php _e( 'Height' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'Etw_widget_height' ); ?>" name="<?php echo $this->get_field_name( 'Etw_widget_height' ); ?>" type="text" value="<?php echo esc_attr( $instance['Etw_widget_height'] ); ?>">
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'Etw_widget_link_color' ); ?>"><?php _e( 'URL Link Color:' ); ?>&nbsp;&nbsp;<a href="http://html-color-codes.info/" target="_blank">Color code</a></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'Etw_widget_link_color' ); ?>" name="<?php echo $this->get_field_name( 'Etw_widget_link_color' ); ?>" type="text" value="<?php echo esc_attr( $instance['Etw_widget_link_color'] ); ?>">
				
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'Etw_widget_show_replies' ); ?>"><?php _e( 'Show Replies' ); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'Etw_widget_show_replies' ); ?>" name="<?php echo $this->get_field_name( 'Etw_widget_show_replies' ); ?>">
					<option value="yes" <?php if($instance['Etw_widget_show_replies'] == "yes") echo "selected=selected" ?>>Yes</option>
					<option value="no" <?php if($instance['Etw_widget_show_replies'] == "no") echo "selected=selected" ?>>No</option>
				</select>
			</p>
			
			<!--
			<p>
			
					<label for ="<?php echo $this-> get_field_id('Etw_widget_hide_pro_panel');?>"><?php _e('Hide Twitter pro setting panel:');?></label><input type="checkbox" id="<?php echo $this->get_field_id( 'Etw_widget_hide_pro_panel' ); ?>" name="<?php echo $this->get_field_name( 'Etw_widget_hide_pro_panel' ); ?> "<?php if($instance['Etw_widget_hide_pro_panel']== 'on'){echo checked;} ?>>
			</p> -->

			<!--<p>
				<label for="<?php //echo $this->get_field_id( 'Etw_widget_custom_css' ); ?>"><?php/// _e( 'Custom css:' ); ?></label>
				<textarea rows="2" cols="40" id="<?php //echo $this->get_field_id( 'Etw_widget_custom_css' ); ?>" name="<?php //echo $this->get_field_name( 'Etw_widget_custom_css' ); ?>"><?php //echo esc_attr( $instance['Etw_widget_custom_css'] ); ?></textarea>
			</p>-->
			<p>
			<a target="_blanck" href="https://wordpress.org/support/view/plugin-reviews/custom-twitter-widget-pro">Show some love </a>
			</p>
		   
			<?php
		}
	
	/**
		*Updating widget replacing old instances with new.
	**/
		 public function update( $new_instance, $old_instance ) {
			/** Default Args */
			$defaults = $this->Etw_defaults_settings();
			$instance = $old_instance;
			foreach( $defaults as $key => $val ) {
				$instance[$key] = strip_tags( $new_instance[$key] );
			}
			//update_option('Etw_widget_hide_pro_panel',$instance['Etw_widget_hide_pro_panel']);
			return $instance;
		}
	
	/** 
		*Set up the default form values. 
	*/
		function Etw_defaults_settings() {
			$defaults = array(
				'title' => esc_attr__( 'Twitter Widget', 'test'),
				'Etw_widget_screen_name' => '',
				'Etw_widget_id' => '634434836409614336',
				'Etw_widget_theme' => 'light',
				'Etw_widget_height' => 400,
				'Etw_widget_link_color' => '#CC0000',
				'Etw_widget_show_replies' => 'yes',
				'Etw_widget_hide_pro_panel' => 'on',
				'Etw_widget_custom_css' => ''
			);
			return $defaults;
		}
}
	/**
	*register EtwTwitter_widget widget
	**/
		function registerTwitterWidget() {
			register_widget( 'EtwTwitter_widget' );
		}
		add_action( 'widgets_init', 'registerTwitterWidget' );
		
		
			
		/**
		*Sticky facebook feed front end code
		**/		
		
	function ETWP_sticky_box(){

			$instance = get_option('ETWP_twitter_sticky_settings');
			$ETWP_TwitterUserName    =    $instance['ETWP_user_name'];
			$ETWP_Theme              =   'light';
			$ETWP_Height             =   '600';
			$ETWP_Width              =   '400';
			$ETWP_LinkColor          =   $instance['ETWP_url_link_color'];
			$ETWP_ShowTwittsShowReply     =   ($instance['ETWP_show_reply'] == 'no')? 'nofooter': '';
			$ETWP_TwitterWidgetId    =   $instance['Etw_twitter_id'];
			
			$BorderColor = $instance['ETWP_theme_border_color'];
			//$Bordersolid = $instance['ETWP_theme_boder'];
			
			?>
			<script type="text/javascript">

				jQuery(document).ready(function(){
				jQuery(".ETWP_twitter_box").toggle(function(){
					jQuery(this).animate({right: "0"},200);
				  },function(){
					jQuery(this).animate({right: "-<?php echo $ETWP_Width - "45";?>"},200);
				  });
				});


				!function(d,s,id) {
					var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}
				} (document,"script","twitter-wjs");
			</script>
			
			<style type="text/css"> .ETWP_twitter_box{background: url("<?php echo Etw_PLUGIN_URL;?>./image/twitter-slide.jpg") no-repeat scroll left center transparent !important;display: block;float: right;height: <?php echo $ETWP_Height;?>px;padding: 0 5px 0 46px;width: <?php echo $ETWP_Width;?>px;z-index: 99999;position:fixed;right:-<?php echo $ETWP_Width - "45";?>px;top:20%;} .ETWP_twitter_box div{border:none;position:relative;display:block;} .ETWP_twitter_box span{bottom: 12px;font: 8px "lucida grande",tahoma,verdana,arial,sans-serif;position: absolute;right: 6px;text-align: right;z-index: 99999;} .ETWP_twitter_box span a{color: #808080;text-decoration:none;} .ETWP_twitter_box span a:hover{text-decoration:underline;} </style><div class="ETWP_twitter_box" style=""><div>
			<a class="twitter-timeline" data-dnt="true" href="https://twitter.com/twitterdev" min-width="<?php echo $ETWP_Width; ?>" height="<?php echo $ETWP_Height; ?>" data-theme="<?php echo $ETWP_Theme; ?>" data-link-color="<?php echo $ETWP_LinkColor; ?>" data-widget-id="<?php echo $ETWP_TwitterWidgetId; ?>" data-border-color="<?php echo $BorderColor; ?>" data-lang="en_US" data-screen-name="<?php echo $ETWP_TwitterUserName; ?>"data-chrome="no"><?php _e('Tweets By @','Etw'); echo $ETWP_TwitterUserName; ?>  </a> </div> </div>
			<?php
			
			
		}
$instance = get_option('ETWP_twitter_sticky_settings');
$StickyEnable = $instance['ETWP_sticky_enable_setting'];
if($StickyEnable == 'yes'){
	add_action( 'wp_footer', 'ETWP_sticky_box' );
}

?>