<?php
/*
Plugin Name: Easy CC License
Plugin URI: http://www.makerblock.com
Description: An easy way to include Creative Commons license images or license blocks
Version: 0.91
Date: 01-24-2014
Author: MakerBlock
Author URI: http://www.makerblock.com
License: GPL2
**************************************************************
	Copyright 2012-2014  MakerBlock

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
//	Create Defaults, Upon Activation
	register_activation_hook( __FILE__, array('mbk_ez_cc_class', 'install') );

//	Upon Deactivation, Uninstall Everything
	register_deactivation_hook( __FILE__, array('mbk_ez_cc_class', 'uninstall') );

//	Add Shortcode 
	add_shortcode("ezcc", array('mbk_ez_cc_class', 'mbk_ez_cc_license_shortcode') );

//	Add Filters - to content and RSS content
	add_filter('the_content', array('mbk_ez_cc_class', 'mbk_ez_cc_license_filter') );
	add_filter('the_content_feed', array('mbk_ez_cc_class', 'mbk_ez_cc_license_filter') );

//	Add Action to Call Function to Call Menu
	add_action('admin_menu', array('mbk_ez_cc_class', 'mbk_ez_cc_license_menu') );

//	Plugin, as a class
	class mbk_ez_cc_class
		{
		//	Create Defaults, Upon Activation
			static function uninstall() 
				{ 
				delete_option('mbk_ez_cc_options'); 
				//	Need to include a way to delete every instance of the get_post_meta(#, 'mbk_ez_cc_license')
				global $wpdb;
				$myrows = $wpdb->get_results("DELETE FROM $wpdb->postmeta WHERE meta_key = 'mbk_ez_cc_license'");
				}
		//	Create Defaults, Upon Activation
			static function install() 
				{
				$options = array();
					//	Setting: 'image_size'; Default: 88x31; 88x31|80x15
					$options['image_size'] = '88x31';
					//	Setting: 'field_commercial'; Default: y; y|n
					$options['field_commercial'] = 'y';
					//	Setting: 'field_derivatives'; Default: y; y|sa|n
					$options['field_derivatives'] = 'y';
					//	Setting: 'field_jurisdiction'; Default: Obtained via the user's last two letters of the ISO-3166 country code!  http://creativecommons.org/choose/ for the full list.  "" is international
					$options['field_jurisdiction'] = ( WPLANG =='' ? 'us' : substr(WPLANG, -2) );
/*	These are being removed because they create a larger than necessary default license block
					//	Setting: 'field_worktitle'; Default: get_the_title(); When used inside the loop, as this will be, "get_the_title()" will display the current post/page title
						//	There should be the choice of the blog name, post/page title, or custom!
					$options['field_worktitle'] = 'get_the_title';
					//	Setting: 'field_format'; Default: "InteractiveResource"; ""|Sound|MovingImage|StillImage|Text|Dataset|InteractiveResource; "" is Other
					$options['field_format'] = 'InteractiveResource';
					//	Setting: 'field_attribute_to_name'; Default: get_bloginfo( $show, $filter );	http://codex.wordpress.org/Function_Reference/get_bloginfo
						//	There should be the choice of the blog name, post/page author name, or custom!
					$options['field_attribute_to_name'] = 'get_the_author';
					//	Setting: 'field_attribute_to_url'; Default: site_url();	http://codex.wordpress.org/Function_Reference/get_bloginfo
					$options['field_attribute_to_url'] = 'site_url';	
					//	Setting: 'field_sourceurl'; Default: get_permalink();	When used inside the loop, as this will be, "get_permalink()" will display the current post/page permalink URL
						//	There should be the choice of the blog URL, post/page URL, or custom!
					$options['field_sourceurl'] = 'get_permalink';
					//	Setting: 'field_morepermissionsurl'; Default: site_url(); The main website URL
					$options['field_morepermissionsurl'] = 'site_url';
*/
				update_option('mbk_ez_cc_options', $options);
				}
		//	Licnese Filter to Content
			static function mbk_ez_cc_license_filter($text) 
				{
				//	First, let's get the options
				$options = get_option('mbk_ez_cc_options');
				$postID = get_the_ID();
				$postType = get_post_type($postID);
				//	Next, we see if we need to run the filter for this particular post or page
				if (($options['field_location'] == 'post' && $postType == 'post') || ($options['field_location'] == 'page' && $postType == 'page') || ($options['field_location'] == 'postpage'))
					{
					//	Next, let's check and see if there's an update to the licnese since the last time
					$post_meta = get_post_meta($postID, 'mbk_ez_cc_license');
					//	If this post has updated the license text since the last plugin update, just return the saved license text
					if ($post_meta[0]['last_license_update'] > $options['time_of_last_setting'])
						{ return $text . $post_meta[0]['license_text']; }
					//	Next, let's contruct the URL/request
						$url = "http://api.creativecommons.org/rest/1.5/license/standard/get?";
						$fields 	= array('field_commercial',	'field_derivatives',	'field_jurisdiction',	'field_format',	'field_worktitle',	'field_attribute_to_name',	'field_attribute_to_url',	'field_sourceurl',	'field_morepermissionsurl');
						$settings 	= array('commercial', 		'derivatives', 			'jurisdiction', 		'type', 		'title', 			'attribution_name', 		'attribution_url', 			'source-url',		'more_permissions_url');
						for ($i=0;$i<count($settings);$i++)
							{ 
							$value = $options[$fields[$i]];
							switch ($value)
								{
								case 'unspecified': 		$value = ''; break;
								case 'get_the_title': 		$value = get_the_title(); break;
								case 'get_bloginfo_name': 	$value = get_bloginfo('name'); break;
								case 'get_the_author': 		$value = get_the_author(); break;
								case 'get_permalink': 		$value = get_permalink(); break;
								case 'site_url': 			$value = site_url(); break;
								}
							$url .= "&". $settings[$i] . "=" . rawurlencode($value);
							}
					//	Next, let's grab the license information
					$pattern = '/<a.*/i';
						preg_match($pattern, file_get_contents($url), $xml);
						$ezcctext = substr($xml[0], 0, -7);
					$license_text = "<div class='ez_cc_license_block'>$ezcctext</div>";
					update_post_meta($postID, 'mbk_ez_cc_license', array('last_license_update'=>time(), 'license_text'=>$license_text));
					//	Return the license information
					return $text . $license_text;
					}
				else 
					{ return $text; }
				}
		//	Shortcode Function
			static function mbk_ez_cc_license_shortcode($atts) 
				{
				extract(shortcode_atts(array(
					'type' => 'small',
				), $atts));
				//	First, let's get the options
				$options = get_option('mbk_ez_cc_options');
				//	Next, let's check and see if there's an update to the licnese since the last time
				$postID = get_the_ID();
				$post_meta = get_post_meta($postID, 'mbk_ez_cc_license');
				//	If this post has updated the license text since the last plugin update, just return the saved license text
				if ($post_meta[0]['last_license_update'] > $options['time_of_last_setting'])
					{ return $post_meta[0]['license_text']; }
				//	Next, let's contruct the URL/request
					$url = "http://api.creativecommons.org/rest/1.5/license/standard/get?";
					$fields 	= array('field_commercial',	'field_derivatives',	'field_jurisdiction',	'field_format',	'field_worktitle',	'field_attribute_to_name',	'field_attribute_to_url',	'field_sourceurl',	'field_morepermissionsurl');
					$settings 	= array('commercial', 		'derivatives', 			'jurisdiction', 		'type', 		'title', 			'attribution_name', 		'attribution_url', 			'source-url',		'more_permissions_url');
					for ($i=0;$i<count($settings);$i++)
						{ 
						$value = $options[$fields[$i]];
						switch ($value)
							{
							case 'unspecified': 		$value = ''; break;
							case 'get_the_title': 		$value = get_the_title(); break;
							case 'get_bloginfo_name': 	$value = get_bloginfo('name'); break;
							case 'get_the_author': 		$value = get_the_author(); break;
							case 'get_permalink': 		$value = get_permalink(); break;
							case 'site_url': 			$value = site_url(); break;
							}
						$url .= "&". $settings[$i] . "=" . rawurlencode($value);
						}
				//	Next, let's grab the license information (Thanks to Nathan Kinkade)
				$xml = file_get_contents($url);
					$doc = new DomDocument('1.0');
					$doc->loadXML($xml);
					$doc->encoding = 'UTF-8';
					$elem = $doc->getElementsByTagName('html')->item(0);
					$html = $doc->saveXML($elem);
					preg_match('/<html\>(.*)<\/html>/', $html, $matches);
					$ezcctext = $matches[1];
				$license_text = "<div class='ez_cc_license_block'>$ezcctext</div>";
				//	Save the license information
				update_post_meta($postID, 'mbk_ez_cc_license', array('last_license_update'=>time(), 'license_text'=>$license_text));
				//	Return the license information
				return $license_text;
				}
		//	Function to Call Menu
			static function mbk_ez_cc_license_menu()
				{ 
				add_options_page( __("Easy CC License","ez-cc-license-page-title"), __("Easy CC License","ez-cc-license-menu-title"), "manage_options", "ez-cc-license-settings-page", array('mbk_ez_cc_class', 'ez_cc_license_setting_page') ); 
				add_filter("plugin_action_links", array('mbk_ez_cc_class', 'mbk_ez_cc_filter_settings_option'), 10, 2);
				}
		//	Add Link to Settings Menu in Plugin Administration Page
			static function mbk_ez_cc_filter_settings_option( $links, $file )
				{
				static $this_plugin;
				if (!$this_plugin) 
					{ $this_plugin = plugin_basename(__FILE__); }
				if ($file == $this_plugin)
					{
					$settings_link = '<a href="options-general.php?page=ez-cc-license-settings-page/">' . __("Setup", "ez-cc-license-setup-link") . '</a>';
					array_unshift($links, $settings_link);
					}
				return $links;
				}
		//	Add Settings Menu
			static function ez_cc_license_setting_page() 
				{ 
				//	Nonce checks
				$nonce=$_REQUEST['ez_cc_admin_options_nonce'];
				if (!current_user_can('manage_options'))
					{ wp_die(__('Sorry, but you have no permissions to change settings.')); }
				if (! wp_verify_nonce($nonce, 'ez_cc_admin_options_nonce') && isset($_REQUEST['ez_cc_admin_options_nonce'])) 
					{ wp_die("Failed security check!"); }
				else 
					{	
					//	Load Current Settings
					$ez_cc_options = get_option('mbk_ez_cc_options');
					//	Load Default Settings
						//	The defaults are set when the plugin is activated
					// Show Options
					if ($_POST['action']=="update") 
						{ 
						//	Load New Settings
						$ez_cc_fields = array('field_location', 'image_size', 'field_commercial', 'field_derivatives', 'field_jurisdiction', 'field_worktitle', 'field_format', 'field_attribute_to_name', 'field_attribute_to_url', 'field_sourceurl', 'field_morepermissionsurl', 'licenselink');
						for ($i=0;$i<count($ez_cc_fields);$i++)
							{ if ( isset($_POST[ $ez_cc_fields[$i] ]) ) { $ez_cc_options[ $ez_cc_fields[$i] ] = stripslashes($_POST[ $ez_cc_fields[$i] ]); } }
						$ez_cc_options['time_of_last_setting'] = time();
						//	Update Settings
						update_option('mbk_ez_cc_options', $ez_cc_options);
						?> <div id="message" class="updated fade"><p><strong>Options saved.</strong></p></div> <?php 
						} 
				//	Show Settings Page
				?>
				<div class="wrap">
					<div id="icon-options-general" class="icon32"><br></div><h2><?php echo __( 'Easy CC License Settings', 'ez-cc-license-settings-page-title' ); ?></h2>
					<style>
						div.ez_cc_license_block						{ border: 1px solid #555555; margin-bottom: 10px; margin-top: 10px; padding: 10px; text-align: center; }
						label.ez_cc_label 							{ width:300px; padding-right:10px; float:left; text-align:left;}
						select.ez_cc_select, input.ez_cc_select		{ width:220px; border:1px solid black; }
						div#preview_pane							{ width:700px; }
						div#settings_control 						{ border:0px solid black; width:540px; text-align:center;}
						#wrap_advanced 								{ display:none; }
						a#wrap-advanced-link						{ text-align:center; }
						#wrap-advanced-link-close					{ text-decoration:none; display:block; color:red; font-weight:bold; padding-left:480px; }
					</style>
						<div id='preview_pane' class='ez_cc_license_block' style='display:none;'>
							<h3><?php echo __( 'License Preview:', 'ez-cc-license-preview' ); ?></h3>
							<textarea cols=120 rows=5></textarea>
						</div>
					<div id='settings_control'>
						<form action="options-general.php?page=ez-cc-license-settings-page" method="post">
							<label for="location" class="ez_cc_label">Where should licenses appear?</label>
								<select id="location" class="ez_cc_select" name="field_location">
									<option value="postpage" <?php if ($ez_cc_options['field_location'] == 'postpage') { echo "selected"; } ?> >At the end of every post or page</option>
									<option value="shortcode" <?php if ($ez_cc_options['field_location'] == 'shortcode') { echo "selected"; } ?> >Only with shortcode</option>
									<option value="post" <?php if ($ez_cc_options['field_location'] == 'post') { echo "selected"; } ?> >At the end of every post</option>
									<option value="page" <?php if ($ez_cc_options['field_location'] == 'page') { echo "selected"; } ?> >At the end of every page</option>
								</select><br>
							<label for="commercial" class="ez_cc_label">Allow commercial uses of your work?</label>
								<select id="commercial" class="ez_cc_select" name="field_commercial">
									<option value="y" <?php if ($ez_cc_options['field_commercial'] == 'y') { echo "selected"; } ?> >Yes!</option>
									<option value="n" <?php if ($ez_cc_options['field_commercial'] == 'n') { echo "selected"; } ?> >No</option>
								</select><br>
							<label for"derivatives" class="ez_cc_label">Allow modifications of your work?</label>
								<select id="derivatives" class="ez_cc_select" name="field_derivatives">
									<option value="y"  <?php if ($ez_cc_options['field_derivatives'] == 'y') { echo "selected"; } ?> >Yes!</option>
									<option value="sa" <?php if ($ez_cc_options['field_derivatives'] == 'sa') { echo "selected"; } ?> >Yes, as long as others share alike</option>
									<option value="n"  <?php if ($ez_cc_options['field_derivatives'] == 'n') { echo "selected"; } ?> >No</option>
								</select><br>
							<br>
							<a href='#' onclick='jQuery("#wrap_advanced").toggle(250); return false;' id='wrap-advanced-link'>Advanced</a>
							<div id='wrap_advanced'>
								<a href='#' onclick='jQuery("#wrap_advanced").hide(250); return false;' id='wrap-advanced-link-close'>[Close]</a>
								<label for="field_jurisdiction" class="ez_cc_label">What's the jurisdiction of your license?</label>
									<select id="field_jurisdiction" class="ez_cc_select" name="field_jurisdiction">
										<?php
										$jx1 = array('','ar','au','at','be','br','bg','ca','cl','cn','co','cr','hr','cz','dk','ec','ee','fi','fr','de','gr','gt','hk','hu','in','il','it','jp','lu','mk','my','mt','mx','nl','nz','no','pe','ph','pl','pt','pr','ro','rs','sg','si','za','kr','es','se','ch','tw','th','uk','scotland','us','vn');
										$jx2 = array('International','Argentina','Australia','Austria','Belgium','Brazil','Bulgaria','Canada','Chile','China Mainland','Colombia','Costa Rica','Croatia','Czech Republic','Denmark','Ecuador','Estonia','Finland','France','Germany','Greece','Guatemala','Hong Kong','Hungary','India','Israel','Italy','Japan','Luxembourg','Macedonia','Malaysia','Malta','Mexico','Netherlands','New Zealand','Norway','Peru','Philippines','Poland','Portugal','Puerto Rico','Romania','Serbia','Singapore','Slovenia','South Africa','South Korea','Spain','Sweden','Switzerland','Taiwan','Thailand','UK: England & Wales','UK: Scotland','United States','Vietnam');
										for ($i=0;$i<count($jx1);$i++)
											{ 
											$jxvalue = $jx1[$i];
											$jxtitle = $jx2[$i];
											$jxselected = ($jxvalue == $ez_cc_options['field_jurisdiction'] ? "selected" : "");
											echo "<option value='$jxvalue' $jxselected>$jxtitle</option>";
											}
										?>
									</select>
								<label for="field_format" class="ez_cc_label">What's the format of your work?</label>
									<select id="field_format" class="ez_cc_select" name="field_format">
										<option value=''  					<?php if ($ez_cc_options['field_format'] == '') { echo "selected"; } ?> >Other</option>
										<option value='Sound' 				<?php if ($ez_cc_options['field_format'] == 'Sound') { echo "selected"; } ?> >Audio</option>
										<option value='MovingImage'  		<?php if ($ez_cc_options['field_format'] == 'MovingImage') { echo "selected"; } ?> >Video</option>
										<option value='StillImage'  		<?php if ($ez_cc_options['field_format'] == 'StillImage') { echo "selected"; } ?> >Image</option>
										<option value='Text'  				<?php if ($ez_cc_options['field_format'] == 'Text') { echo "selected"; } ?> >Text</option>
										<option value='Dataset'  			<?php if ($ez_cc_options['field_format'] == 'Dataset') { echo "selected"; } ?> >Dataset</option>
										<option value='InteractiveResource'	<?php if ($ez_cc_options['field_format'] == 'InteractiveResource') { echo "selected"; } ?> >Interactive</option>
									</select><br>
								<label for='field_worktitle' class="ez_cc_label">What's the title of work?</label>
									<select id="field_worktitle" class="ez_cc_select" name="field_worktitle">
										<option value='unspecified' 		<?php if ($ez_cc_options['field_worktitle'] == 'unspecified') { echo "selected"; } ?> >Leave blank</option>
										<option value='get_the_title' 		<?php if ($ez_cc_options['field_worktitle'] == 'get_the_title') { echo "selected"; } ?> >Title of post or page</option>
										<option value='get_bloginfo_name'	<?php if ($ez_cc_options['field_worktitle'] == 'get_bloginfo_name') { echo "selected"; } ?> >Name of website</option>
									</select><br>
								<label for='field_attribute_to_name' class="ez_cc_label">What name should the work be attributed to?</label>
									<select id="field_attribute_to_name" class="ez_cc_select" name="field_attribute_to_name">
										<option value='unspecified' 		<?php if ($ez_cc_options['field_attribute_to_name'] == 'unspecified') { echo "selected"; } ?> >Leave blank</option>
										<option value='get_the_author'		<?php if ($ez_cc_options['field_attribute_to_name'] == 'get_the_author') { echo "selected"; } ?> >Author of post or page</option>
										<option value='get_bloginfo_name'	<?php if ($ez_cc_options['field_attribute_to_name'] == 'get_bloginfo_name') { echo "selected"; } ?> >Name of website</option>
									</select><br>
								<label for='field_attribute_to_url' class="ez_cc_label">What URL should the work be attributed to?</label>
									<select id="field_attribute_to_url" class="ez_cc_select" name="field_attribute_to_url">
										<option value='unspecified' 		<?php if ($ez_cc_options['field_attribute_to_url'] == 'unspecified') { echo "selected"; } ?> >Leave blank</option>
										<option value='get_permalink' 		<?php if ($ez_cc_options['field_attribute_to_url'] == 'get_permalink') { echo "selected"; } ?> >URL for post or page</option>
										<option value='site_url' 			<?php if ($ez_cc_options['field_attribute_to_url'] == 'site_url') { echo "selected"; } ?> >URL for website</option>
									</select><br>
								<label for='field_sourceurl' class="ez_cc_label">What's the source URL for the work?</label>
									<select id="field_sourceurl" class="ez_cc_select" name="field_sourceurl">
										<option value='unspecified' 		<?php if ($ez_cc_options['field_sourceurl'] == 'unspecified') { echo "selected"; } ?> >Leave blank</option>
										<option value='get_permalink' 		<?php if ($ez_cc_options['field_sourceurl'] == 'get_permalink') { echo "selected"; } ?> >URL for post or page</option>
										<option value='site_url' 			<?php if ($ez_cc_options['field_sourceurl'] == 'site_url') { echo "selected"; } ?> >URL for website</option>
									</select><br>
								<label for='field_morepermissionsurl' class="ez_cc_label">What URL should a person use to seek more permissions?</label>
									<select id="field_morepermissionsurl" class="ez_cc_select" name="field_morepermissionsurl">
										<option value='unspecified' 		<?php if ($ez_cc_options['field_morepermissionsurl'] == 'unspecified') { echo "selected"; } ?> >Leave blank</option>
										<option value='get_permalink' 		<?php if ($ez_cc_options['field_morepermissionsurl'] == 'get_permalink') { echo "selected"; } ?> >URL for post or page</option>
										<option value='site_url' 			<?php if ($ez_cc_options['field_morepermissionsurl'] == 'site_url') { echo "selected"; } ?> >URL for website</option>
									</select>
							</div>
							<input name="ez_cc_admin_options_nonce" type="hidden" value="<?php echo wp_create_nonce('ez_cc_admin_options_nonce'); ?>"/>
							<input type="hidden" name="action" value="update" />
						<br><br>
						<input name="ez_cc_save" class="button-primary" value="<?php _e("Save Changes","save-button"); ?>" type="submit" title="Click here to save changes." />
						</form>
					</div>
				</div> <?php
				}
			}
		}
?>