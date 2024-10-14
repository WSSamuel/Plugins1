<?php
/**
 * @package Floating Adsense Bar
 * @version 1.0
 */
/*
Plugin Name: Floating Adsense Bar
Plugin URI: http://www.reviewresults.in/reviewresults/post/2012/09/21/Floating-Adsense-Bar-WordPress-Plugin.aspx
Description: Floating Adsense side bar allows you to add floating ad bar to display floating adsense or any adnetwork ads on either side of your webpage. These Ads will scroll along with the page.
Author: Santosh Padire
Version: 1.0
Author URI: http://www.reviewresults.in
*/
 
add_action('init','FAB_share_init');
add_action('wp_footer', 'FAB_Float_Load',100);

function FAB_share_init() {
	// DISABLED IN THE ADMIN PAGES
	if (is_admin()) {
		return;
	}
    wp_enqueue_script( 'jquery' );
	wp_enqueue_style('fab_style', '/wp-content/plugins/floating-adsense-bar/fab_style.css');	
}   
function FAB_Float_Load()
{
	echo FAB_Float();
}

/* Ads*/
function FAB_Float()
{	

		if (is_admin()) 
		{
			return;
		}
        $FAB_Width = get_option('FF_width');
		$FAB_Height = get_option('FF_height');
		$FAB_Left = get_option('FF_LeftRight');
		$FAB_Code = get_option('FF_Code');

		$button = '';
				
		if ($FAB_Width != '' && $FAB_Height != '' && $FAB_Left != '' && $FAB_Code != '')
		{
			if($FAB_Left != 'Right')
			{
			$button .=' 
					<div id="ad_divRight" width="'.$FAB_Width.'"; height= "'.$FAB_Height.'";> 
					 '.$FAB_Code.'
					</div>';	
			}	
            else if($FAB_Left != 'Left')
			{
			$button .=' 
					<div id="ad_divLeft" width="'.$FAB_Width.'"; height= "'.$FAB_Height.'";> 
					 '.$FAB_Code.'
					</div>';	
			}			
		}
			
		return $button;
}
	
function get_plugin_directory(){
	return WP_PLUGIN_URL . '/floating-adsense-bar';	
}
 
/* Runs when plugin is activated */
register_activation_hook(__FILE__,'FAB_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'FAB_remove' );

function FAB_install() 
{
/* Do Nothing */
}

function FAB_remove() {
/* Deletes the database field */
delete_option('FF_width');
delete_option('FF_height');
delete_option('FF_LeftRight');
delete_option('FF_Code');
} 
if ( is_admin() ){

/* Call the html code */
add_action('admin_menu', 'floatingAB_admin_menu');

function floatingAB_admin_menu() {
add_options_page('Floating Adsense Bar', 'Floating Adsense Bar', 'administrator',
'Floating_Ad', 'floatingFA_html_page');
}
} 
 
function floatingFA_html_page() {
?>
<div>
<h2>Floating Adsense Bar Options</h2>
 
<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>
 
<table width="800">
<tr valign="top">
<th width="120" scope="row">Width</th>
<td width="680">
<input name="FF_width" type="text" id="FF_width"
value="<?php echo get_option('FF_width'); ?>" />
(ex. 160, this width is considered when ad script doesn't contain width property)</td>
</tr>
<tr valign="top">
<th width="120" scope="row">Height</th>
<td width="680">
<input name="FF_height" type="text" id="FF_height"
value="<?php echo get_option('FF_height'); ?>" />
(ex. 640, this height is considered when ad script doesn't contain height property)</td>
</tr>
<tr valign="top">
<th width="120" scope="row">Float Left or Right</th>
<td width="680">
<select name="FF_LeftRight" id="FF_LeftRight" style="width:158px;">
  <option value="Right" <?php if(get_option(FF_LeftRight)=="Right"){echo 'selected';} ?>>Right</option>
  <option value="Left" <?php if(get_option(FF_LeftRight)=="Left"){echo 'selected';} ?>>Left</option>
</select>
(ex. Left or Right)</td>
</tr>
<tr valign="top">
<th width="120" scope="row">AdScript Code</th>
<td width="680">
<textarea name="FF_Code" id="FF_Code" rows="5" cols="2" style="width:400px;"><?php echo get_option('FF_Code'); ?>
</textarea>
(ex. For multple ads add multiple div tags)</td>
</tr>
</table> 
<table width="800">
<tr valign="left">
<th width="800">Note:All Fields are Mandatory</th>
</tr>
</table> 
<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="FF_width,FF_height,FF_LeftRight,FF_Code" />
 
<p>
<input type="submit" value="<?php _e('Save Changes') ?>" />
</p> 
</form>
</div>
<?php
} 
?>