<?php
/*
Plugin Name: Ultimate Thesis Theme Options
Plugin URI: http://letusbuzz.com/
Description: Ultimate Thesis Theme Options
Author URI: http://letusbuzz.com
Author: Sudipto Pratap Mahato
Version: 1.0
*/

//add the option page menu
add_action('admin_menu', 'ut_addmenu');
function ut_addmenu(){
	add_options_page("Ultimate Thesis Options", "Ultimate Thesis Options", "administrator", "utoptions", "ut_options_page");
}
/*******************************************************************/

//Option Page 
function ut_sanatize_option($name,$defa) {
	echo stripslashes(htmlspecialchars(ut_get_option($name,$defa)));
}
function ut_options_page()
{
	$utoptions=get_option('utoptions');
	if(isset($_GET['clearwidgets']))
	{
		ut_save_option( 'all_widget','' );
		ut_create_widget_list();
	}
	if (!current_user_can('edit_themes'))
			wp_die('You do not have admin privileges to change plugin options.');
		if (isset($_POST['submit'])) 
		{
			ut_save_all_options();
			echo '<div id="message" class="updated fade"><p><strong>Options successfully saved</strong></p></div>';
		}
?>
	<h2 id="otitle">Ultimate Thesis Options</h2>
	<div style="width:65%;" class="postbox-container">
	<div class="metabox-holder">	
	<div class="meta-box-sortables">
	<?php ut_postbox_start('preame','Little Readme'); ?>
	<div style="background-color: #F6F6F6;">
	<p>Like this Plugin then why not hit the like button. Your like will motivate me to enhance the features of the Plugin :)<br />
	<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FLet-us-Buzz%2F149408071759545&layout=standard&show_faces=false&width=450&action=like&font=verdana&colorscheme=light&height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe><br />And if you are too generous then you can always <b>DONATE</b> by clicking the donation button.<br/>A Donation will help in the uninterrupted developement of the plugin.<br /><a href="http://letusbuzz.com/ultimate-thesis-options/" TARGET='_blank'>Click here</a> for <b>Reference on using the plugin</b> or if you want to <b>report a bug</b> or if you want to <b>suggest a Feature</b><br /></p>
	</div>
	
	<?php ut_postbox_end(); ?>
	<form action="<?php echo admin_url('options-general.php?page=utoptions'); ?>" method="post">

		<?php ut_postbox_start('pheader','Header Area (Insert HTML/PHP)'); ?>
		<div style="background-color: #F6F6F6;">
		<table>
		<colgroup><col><col></colgroup>
		<tr>
		<td>
			<p>You can use both HTML and PHP code here.</p>
			<p>To display menu use below shortcodes<br/>
			&nbsp;&nbsp;&nbsp;1. Left Align Primary Menu - <code>[Left-Page-Menu]</code> <br/>
			&nbsp;&nbsp;&nbsp;2. Right Align Primary Menu - <code>[Right-Page-Menu]</code> <br/>
			&nbsp;&nbsp;&nbsp;3. Center Align Primary Menu - <code>[Center-Page-Menu]</code> <br/>
			&nbsp;&nbsp;&nbsp;4. Left Align Secondary Menu - <code>[Left-Cat-Menu]</code> <br/>
			&nbsp;&nbsp;&nbsp;5. Right Align Secondary Menu - <code>[Right-Cat-Menu]</code> <br/>
			&nbsp;&nbsp;&nbsp;6. Center Align Secondary Menu - <code>[Center-Cat-Menu]</code> <br/></p>
			<p>To display<br/>
			Site Title use <code>[Site-Title]</code><br/>
			Site Tagline use <code>[Site-Tagline]</code></p>
		</td>
		<td style="padding-left:20px;width:50%;">
			<p>Example 1</p>
			<p>
				<code>[Left-Page-Menu]<br>
					&lt;a href=&quot;/&quot;&gt;&lt;img alt='sample-5.jpg' src='/wp-content/themes/thesis_18/custom/rotator/sample-5.jpg' 
/&gt;&lt;/a&gt;<br>
				[Left-Cat-Menu]</code>
			</p>
			<p>Example 2</p>
			<p>
				<code>[Left-Page-Menu]<br/>
				[Site-Title]<br/>
				[Site-Tagline]<br/>
				[Left-Cat-Menu]</code>
			</p>
		</td>
		</tr></table>
		</div>
			<p>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="utoptions[defa_header]" id="d-header" value="true"<?php if (ut_get_option( 'defa_header', true ) == true) echo ' checked'; ?>> Use Default Thesis Header (To use this custom Header uncheck this option) </p>
			<textarea id="ut_header_text" name="utoptions[header_text]" rows="10" cols="50" style="width:99%;margin-left:2px;"><?php ut_sanatize_option('header_text',''); ?></textarea>
		<?php ut_postbox_end(); ?>
		<p><input type="submit" name="submit" value="Save all Options" class="button-primary"/><a href="#site-heading" style="float: right;">GO TOP ^</a></p>

		<?php ut_postbox_start('pfooter','Footer Area (Insert HTML/PHP)'); ?>
		<div style="background-color: #F6F6F6;">
			<p>You can use both HTML and PHP code here.</p>
			<p>Example</p>
			<p><code>&lt;p&gt;Copyright &lt;?php echo date('Y'); ?&gt; - &lt;a href=&quot;&lt;?php echo get_bloginfo('url'); 
?&gt;&quot;&gt;&lt;?php echo get_bloginfo('name'); ?&gt;&lt;/a&gt;&lt;/p&gt;<br>
&lt;p&gt;<br>
&lt;a href=&quot;http://diythemes.com/thesis/&quot;&gt;Thesis WordPress Theme&lt;/a&gt; &amp; &lt;a href=&quot;http://letusbuzz.com/ultimate-thesis-options/&quot;&gt;Ultimate 
Thesis Options Plugin&lt;/a&gt;<br>
&lt;/p&gt;</code></p>
		</div>
		<p>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="utoptions[defa_footer]" id="d-footer" value="true"<?php if (ut_get_option( 'defa_footer', true ) == true) echo ' checked'; ?>> Use Default Thesis Footer (To use this custom Footer uncheck this option) </p>
			<textarea id="ut_footer_text" name="utoptions[footer_text]" rows="10" cols="50" style="width:99%;margin-left:2px;"><?php ut_sanatize_option('footer_text',''); ?></textarea>
		<?php ut_postbox_end(); ?>
		<p><input type="submit" name="submit" value="Save all Options" class="button-primary"/><a href="#site-heading" style="float: right;">GO TOP ^</a></p>
		
		<?php ut_postbox_start('widgeta','Create Widget Areas'); ?>
		<div style="background-color: #F6F6F6;">
		<table style="width: 100%; vertical-align: top;"><tbody><tr>
		<td style="width: 65%; vertical-align: top;">
			<h4>Above Header</h4> 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Columns <?php ut_dropdown_count("utoptions[headera_widg]",5,ut_get_option('headera_widg',0)); ?>
			<h4>Below Header </h4> 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Columns <?php ut_dropdown_count("utoptions[headerb_widg]",5,ut_get_option('headerb_widg',0)); ?>
			<h4>Footer</h4> 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Columns <?php ut_dropdown_count("utoptions[footer_widg]",5,ut_get_option('footer_widg',0)); ?>
			
		</td>
		<td style="vertical-align: top;">
			<h4>List of all registered widget areas</h4>
			<?php ut_list_all_widget(); ?>
			<p><a href="<?php echo site_url(); ?>/wp-admin/options-general.php?page=utoptions&clearwidgets=true" onclick = "if (! confirm('Do you really want to clear unused widget areas?')) return false;">Clear Unused Widget Areas</a></p>
		</td>
		</tr></tbody></table>
		
		</div>
		<?php ut_postbox_end(); ?>
		<p><input type="submit" name="submit" value="Save all Options" class="button-primary"/><a href="#site-heading" style="float: right;">GO TOP ^</a></p>
	</form>
	</div></div></div>
	<div style="width:30%;float:right;" class="postbox-container">
	<div class="metabox-holder">	
	<div class="meta-box-sortables">
	<?php ut_postbox_start('donate','Consider a donation'); ?>
		<div style="text-align: center;">
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_donations">
			<input type="hidden" name="business" value="isudipto@gmail.com">
			<input type="hidden" name="lc" value="US">
			<input type="hidden" name="item_name" value="Ultimate Thesis Options Plugin">
			<input type="hidden" name="no_note" value="0">
			<input type="hidden" name="currency_code" value="USD">
			<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
			<input type="image" src="https://www.paypalobjects.com/WEBSCR-640-20110401-1/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/WEBSCR-640-20110401-1/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
			<br /><p>If you think that this plugin has made your life easier then please consider a Donation and always remember that $X is always better than $0</p>
		</div>
	<?php ut_postbox_end(); ?>
	<?php ut_postbox_start('feeds','News Feeds'); ?>
		<?php ut_get_feeds(); ?>
	<?php ut_postbox_end(); ?>
	<?php ut_postbox_start('connect','Get Connected'); ?>
	<a href="http://twitter.com/letusbuzz" target="_blank"><img src="http://a0.twimg.com/a/1303316982/images/twitter_logo_header.png" /></a><br/><a href="http://facebook.com/letusbuzzz" target="_blank"><img src="https://secure-media-sf2p.facebook.com/ads3/creative/pressroom/jpg/b_1234209334_facebook_logo.jpg" height="38px" width="118px"/></a>
	<?php ut_postbox_end(); ?>
	</div></div></div>
<?php
}
/******************************************************************/
function ut_dropdown_count($name,$count,$selected)
{
	echo '<select name="'.$name.'"  style="width: 50px;">';
	for ($i = 0; $i <=$count; $i++) 
	{
?>
		<option <?php if($i==$selected)echo ' selected="selected"'; ?>><?php echo $i; ?></option>
<?php 	
	}
	echo '</select>';
}
/*******************************************************************/
//list of all registered widget areas
function ut_list_all_widget()
{
	$allwid=ut_get_option('all_widget','');
	$allwidarr=explode(",",$allwid);
	$i=1;
	foreach($allwidarr as $widg)
	{
		if(trim($widg)!='')
		{
			echo $i.". ".$widg.'<br />';
			$i=$i+1;
		}
	}

}
/****************************************************************/
// get option and save option
function ut_get_option( $name ,$defa = false) {
	$options = get_option( 'utoptions' );
	if ( isset($options[$name]) ) {
		return $options[$name];
	} else {
		return $defa;
	}
}
function ut_save_option( $name, $value ) {
	$options = get_option('utoptions');
	if ( $value != $options[$name] ) {
		$options[$name] = $value;
		return update_option( 'utoptions', $options );
	} else {
		return false;
	}
}
/*******************************************************************/
//save all options
function ut_save_all_options() {
	$new_options = $_POST['utoptions'];
	$old_options = get_option('utoptions');
	$check_box=array("defa_header","defa_footer");
	$text_area=array("header_text","footer_text");
	$drop_count=array("footer_widg|0","headera_widg|0","headerb_widg|0");
	$nm='';
	while ($t_area = current($text_area)) 
	{
        	if(!isset($new_options[$t_area]))
			ut_save_option( $t_area, '');
		else
			ut_save_option( $t_area, $new_options[$t_area]); 
    		next($text_area);
	}
	while($checks=current($check_box))
	{
		if(!isset($new_options[$checks]))
		{
			ut_save_option( $checks, false );
		}
		else
		{
			ut_save_option( $checks, $new_options[$checks] );
		}
		next($check_box);
	}
	while($dc=current($drop_count))
	{
		$dc1=explode("|",$dc);
		if(!isset($new_options[$dc1[0]]))
			ut_save_option( $dc1[0], $dc1[1] );	
		else
			ut_save_option( $dc1[0], $new_options[$dc1[0]] );
		next($drop_count);
	}

	ut_create_widget_list();

}
/**********************************************************************************/
/**********************************************************************************/


//Menu above header
function ut_nav_menu1($style = "margin: 0pt auto;")
{
$menu1='<div id="menu1wrap"><table cellspacing="0" cellpadding="0" style="'.$style.'"><tbody><tr><td><?php thesis_nav_menu(); ?></td></tr></tbody></table><div style="clear:both;"></div></div>';
return $menu1;
}

/***************************************************************/

//Menu below header
if (function_exists('register_nav_menus')) {
	register_nav_menus(array('secondary' => __('Secondary Menu', 'thesis')));
}
function ut_nav_menu2($style = "margin: 0pt auto;")
{
$menu2='<div id="menu2wrap"><table cellspacing="0" cellpadding="0" style="'.$style.'"><tbody><tr><td><?php wp_nav_menu("theme_location=secondary"); ?></td></tr></tbody></table><div style="clear:both;"></div></div>';
return $menu2;
}

/***************************************************************/

//Register all widget area
function ut_register_widgets()
{
	$allwid=ut_get_option('all_widget','');
	$allwidarr=explode(",",$allwid);
	foreach($allwidarr as $widg)
	{
		if(trim($widg)!='')
		register_sidebar(array('name'=>$widg,'before_title'=>'<h3>','after_title'=>'</h3>'));
	}
	
}
// Display Header above widgets
function ut_display_header_above_widget()
{
$col=ut_get_option('headera_widg','0');
if($col==0)return;
?>
<table cellspacing="0" cellpadding="0" border="0" style="table-layout:fixed;width:100%;text-align:left;" id="aheaderwidget" class="sidebar">
<colgroup><?php for($i=1;$i<=$col;$i++)echo '<col>'; ?></colgroup>
	<tr>
		<?php for($i=1;$i<=$col;$i++){ ?>
		<td valign="top" class="aheadercol" id="aheader<?php echo $i;?>"> 
			<ul class="sidebar_list">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("AboveHeader$i")){ } ?>
			</ul>
		</td>
		<?php } ?> 
	</tr>
</table>

<?php
}
// Display Header below widgets
function ut_display_header_below_widget()
{
$col=ut_get_option('headerb_widg','0');
if($col==0)return;
?>
<table cellspacing="0" cellpadding="0" border="0" style="table-layout:fixed;width:100%;text-align:left;" id="bheaderwidget" class="sidebar">
<colgroup><?php for($i=1;$i<=$col;$i++)echo '<col>'; ?></colgroup>
	<tr>
		<?php for($i=1;$i<=$col;$i++){ ?>
		<td valign="top" class="bheadercol" id="bheader<?php echo $i;?>"> 
			<ul class="sidebar_list">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("BelowHeader$i")){ } ?>
			</ul>
		</td>
		<?php } ?> 
	</tr>
</table>

<?php
}
// Display footer widgets
function ut_display_footer_widget()
{
$col=ut_get_option('footer_widg','0');
if($col==0)return;
?>
<table cellspacing="0" cellpadding="0" border="0" style="table-layout:fixed;width:100%;text-align:left;" id="footerwidget" class="sidebar">
<colgroup><?php for($i=1;$i<=$col;$i++)echo '<col>'; ?></colgroup>
	<tr>
		<?php for($i=1;$i<=$col;$i++){ ?>
		<td valign="top" class="footercol" id="footer<?php echo $i;?>"> 
			<ul class="sidebar_list">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer$i")){ } ?>
			</ul>
		</td>
		<?php } ?> 
	</tr>
</table>

<?php
}
/**********************************************************/
// Register widget area and add to hooks
function ut_register_widget()
{
	ut_create_widget_list();
	ut_register_widgets();
	add_action('thesis_hook_footer', 'ut_display_footer_widget',1);
	add_action('thesis_hook_before_header', 'ut_display_header_above_widget',1);
	add_action('thesis_hook_after_header', 'ut_display_header_below_widget',1);
}

add_action('init','ut_register_widget');
/******************************************************************/
//Create list of widget names
function ut_create_widget_list()
{
	$allwid=ut_get_option('all_widget','');
	$allwidarr=explode(",",$allwid);
	$fw=ut_get_option('footer_widg','0');
	$hwa=ut_get_option('headera_widg','0');
	$hwb=ut_get_option('headerb_widg','0');
	for($i=1;$i<=$fw;$i++)
	{
		$nm="Footer$i";
		if(!in_array($nm,$allwidarr))$allwid.=",".$nm;
	}
	for($i=1;$i<=$hwa;$i++)
	{
		$nm="AboveHeader$i";
		if(!in_array($nm,$allwidarr))$allwid.=",".$nm;
	}
	for($i=1;$i<=$hwb;$i++)
	{
		$nm="BelowHeader$i";
		if(!in_array($nm,$allwidarr))$allwid.=",".$nm;
	}
	ut_save_option( 'all_widget',$allwid ); 
}
/*****************************************************************/
//Function Thesis new header
function ut_thesis_header()
{
	$header_text=stripslashes(ut_get_option('header_text',''));
	$header_text=str_replace("[Center-Page-Menu]",ut_nav_menu1("margin: 0pt auto;"),$header_text);
	$header_text=str_replace("[Left-Page-Menu]",ut_nav_menu1("float:left;"),$header_text);
	$header_text=str_replace("[Right-Page-Menu]",ut_nav_menu1("float:right;"),$header_text);
	$header_text=str_replace("[Center-Cat-Menu]",ut_nav_menu2("margin: 0pt auto;"),$header_text);
	$header_text=str_replace("[Left-Cat-Menu]",ut_nav_menu2("float:left;"),$header_text);
	$header_text=str_replace("[Right-Cat-Menu]",ut_nav_menu2("float:right;"),$header_text);
	$header_text=str_replace("[Site-Title]",ut_site_title(),$header_text);
	$header_text=str_replace("[Site-Tagline]",ut_site_tagline(),$header_text);
	//$header_text.='<div style="clear:both;"></div>';
	echo ut_process_php($header_text);
}
/*****************************************************************/
//Function site title and tagline
function ut_site_title() 
{
	return "<h1 id=\"logo\"><a href=\"" . get_bloginfo('url') . "\">" . get_bloginfo('name') . "</a></h1>";
}
function ut_site_tagline() 
{
	return "<h1 id=\"tagline\">" . get_bloginfo('description') . "</h1>";
}

/*****************************************************************/
//Function Thesis new Footer
function ut_thesis_footer()
{
	$footer_text=stripslashes(ut_get_option('footer_text',''));
	echo ut_process_php($footer_text);

}
/***************************************************************/
//Function remove actions
function ut_add_remove_action()
{
	
	if(ut_get_option('defa_header',true)==false)
	{
		remove_action('thesis_hook_before_header', 'thesis_nav_menu');
		remove_action('thesis_hook_header', 'thesis_default_header');
		add_action('thesis_hook_header', 'ut_thesis_header');
	}
	if(ut_get_option('defa_footer',true)==false)
	{
		remove_action('thesis_hook_footer', 'thesis_attribution');
		add_action('thesis_hook_footer', 'ut_thesis_footer');
	}
}
add_action('wp_head', 'ut_add_remove_action',1);
/**************************************************************/

//Process PHP
function ut_process_php($custom_code) {
    if($custom_code != '') {
        if ( strpos($custom_code,'<?php ') !== FALSE ) {
            ob_start(); 
                eval('?>'.$custom_code); 
                $custom_code = ob_get_contents(); 
            ob_end_clean();
        }
    } 
    return $custom_code; 
}
/**************************************************************/
//Postbox
function ut_postbox_start($id, $title) 
{
?>
	<div id="<?php echo $id; ?>" class="postbox">
		<div class="handlediv" title="Click to toggle"><br /></div>
		<h3 class="hndle"><span><?php echo $title; ?></span></h3>
		<div class="inside">
			
<?php
}

function ut_postbox_end() 
{
	echo '</div></div>';
}

function ut_get_feeds() {
	include_once(ABSPATH . WPINC . '/feed.php');
	$rss = fetch_feed('http://feeds.feedburner.com/letusbuzz');
	if (!is_wp_error( $rss ) ){
		$rss5 = $rss->get_item_quantity(5); 
		$rss1 = $rss->get_items(0, $rss5); 
	}
?>
	<ul style="padding-left: 10px;">
	<?php if (!$rss5 == 0)foreach ( $rss1 as $item ){?>
		<li style="list-style-type:circle">
			<a target="_blank" href='<?php echo $item->get_permalink(); ?>'><?php echo $item->get_title(); ?></a>
		</li>
	<?php } ?>
	</ul>
<?php
}
?>