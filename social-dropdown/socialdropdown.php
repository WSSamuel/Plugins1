<?php
/*
Plugin Name: Social Dropdown
Plugin URI: http://www.tevine.com/projects/socialdropdown/
Description: Displays social bookmarks in a dropdown to reduce clutter. Remember to read the readme...
Author: Nicholas Kwan (multippt)
Author URI: http://www.tevine.com/
Version: 2.0.1
Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
*/

/*	Copyright 2007  Nicholas Kwan  (email : ready725@gmail.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
	Installation of this plugin requires you to upload the files into a directory, activate the plugin, and insert <?php Show_Dropdown(); ?> in your templates.
	Icons come with the package so that you don't have to go icon hunting.

	This plugin has minimal link leakage, so you need not worry about it screwing with your SEO.

	If there are problems with this plugin you can:
	1. Read the readme (seriously)
	2. Contact ready725@gmail.com

	You can suggest social bookmarks via the Wordpress page which this plugin can be found at
*/

//Optional configuration. You can edit these settings.
$overrideoptions = 'false'; //Set this to true if you want to override some options in the plugin, especially when migrating a manually configured plugin.
$usenonjavaset = 'false'; //Set this to true if you want to use the set of bookmarks for non-JavaScript users.

//The plugin version number
$dropdownversion = '2.0.0';

//A file that generates the bookmarks
include_once('generatebookmarks.php');

//Default values, they will be used in install. Do not change them here.
$dropdown_linkback = 'true';
$dropdown_configmode = 'advanced'; //preload advanced
//$dropdown_query = 'blinkbits|blinklist|bloglines|blogmarks|buddymarks|citeulike|comments|delicious|digg|diigo,fark|feedmelinks|furl|google|linkagogo|magnolia|misterwong|newsvine|propeller|rawsugar,reddit|rojo|simpy|sphinn|spurl|squidoo|stumbleupon|tailrank|technorati|yahoo';
$dropdown_query = 'delicious|digg|furl|google|misterwong|newsvine|propeller|reddit|slashdot|stumbleupon|technorati|yahoo';
$dropdown_all = 'blinkbits|blinklist|bloglines|blogmarks|buddymarks|bumpzee|citeulike|comments|delicious|digg|diigo|facebook|fark|faves|feedmelinks|furl|google|gravee|hugg|jeqq|live|linkagogo|magnolia|misterwong|netvouz|newsvine|onlywire|propeller|rawsugar|reddit|rojo|simpy|slashdot|sphinn|spurl|squidoo|stumbleupon|tailrank|taggly|tagtooga|technorati|yahoo';
$dropdown_width = '400px';
$usedropdown = 'true';
$dropdown_uselegacy = 'false';
$dropdown_autoembed = 'false';

//Install options
add_option('dropdown_allowlinkback', $dropdown_linkback, 'Allows a link back to the plugin page [Social Dropdown]');
add_option('dropdown_query', $dropdown_query, 'The saved dropdown items [Social Dropdown]');
add_option('dropdown_use', $usedropdown, 'Use the dropdown [Social Dropdown]');
add_option('dropdown_configmode', $dropdown_configmode, 'Use a configuration mode [Social Dropdown]');
add_option('dropdown_configmode', $dropdown_uselegacy, 'Use a old version [Social Dropdown]');
add_option('dropdown_autoembed', $dropdown_autoembed, 'Embed dropdown in posts [Social Dropdown]');

if (get_option('dropdown_allowlinkback') == '') {
	update_option('dropdown_allowlinkback', $dropdown_linkback);
}
if (get_option('dropdown_query') == '') {
	update_option('dropdown_query', $dropdown_query);
}
if (get_option('dropdown_width') == '') {
	update_option('dropdown_width', $dropdown_width);
}
if (get_option('dropdown_use') == '') {
	update_option('dropdown_use', $usedropdown);
}
if (get_option('dropdown_configmode') == '') {
	update_option('dropdown_configmode', $dropdown_configmode);
}
if (get_option('dropdown_uselegacy') == '') {
	update_option('dropdown_uselegacy', $dropdown_uselegacy);
}
if (get_option('dropdown_autoembed') == '') {
	update_option('dropdown_autoembed', $dropdown_autoembed);
}

if (get_option('dropdown_allowlinkback') != $dropdown_linkback) {
	$dropdown_linkback = get_option('dropdown_allowlinkback');
}
if (get_option('dropdown_query') != $dropdown_query) {
	$dropdown_query = get_option('dropdown_query');
}
if (get_option('dropdown_width') != $dropdown_width) {
	$dropdown_width = get_option('dropdown_width');
}
if (get_option('dropdown_use') != $usedropdown) {
	$usedropdown = get_option('dropdown_use');
}
if (get_option('dropdown_configmode') != $dropdown_configmode) {
	$dropdown_configmode = get_option('dropdown_configmode');
}
if (get_option('dropdown_uselegacy') != $dropdown_uselegacy) {
	$dropdown_uselegacy = get_option('dropdown_uselegacy');
}
if (get_option('dropdown_autoembed') != $dropdown_autoembed) {
	$dropdown_autoembed = get_option('dropdown_autoembed');
}


function Dropdown_header() {
global $dropdown_uselegacy;
if ($dropdown_uselegacy == 'true') {
?>
<link rel="stylesheet" href="<?php echo get_settings('siteurl'); ?>/<?php echo str_replace("\\","/", GetDropPluginPath()); ?>/style.css" type="text/css" />
<script type="text/javascript" src="<?php echo get_settings('siteurl'); ?>/<?php echo str_replace("\\","/", GetDropPluginPath()); ?>/dropdown_old.js"></script>
<?php } else { ?>
<link rel="stylesheet" href="<?php echo get_settings('siteurl'); ?>/<?php echo str_replace("\\","/", GetDropPluginPath()); ?>/dropdown.css" type="text/css" />
<!--[if lte IE 7]>
<link rel="stylesheet" href="<?php echo get_settings('siteurl'); ?>/<?php echo str_replace("\\","/", GetDropPluginPath()); ?>/dropie.css" />
<![endif]-->
<script type="text/javascript" src="<?php echo get_settings('siteurl'); ?>/<?php echo str_replace("\\","/", GetDropPluginPath()); ?>/dropdown.js"></script>
<?php } ?>
<?php
}

//Gives the path of the plugin for use in PHP
function GetDropPluginPath() {
	$cleanabs = str_replace("/","\\", ABSPATH);
	return str_replace($cleanabs, '', str_replace("/","\\", dirname(__FILE__)));
}

//A function for handling updating of options
function UpdateDropOptions() {
global $dropdown_all;
$all = explode("|",$dropdown_all);
if ($_POST) {
//the bookmarks
	if ($_POST['dropdown_configmode'] == 'basic') {

		$booklineexit = '';
		$offset = (integer) $_POST['offset'];
		$validoff = 0;
		$offsetno = 1;
		for ($counter = 0; $counter < count($all); $counter += 1) {
		$value = (string) $_POST[$all[$counter]];
			if ($value=="1"){
				if ($booklineexit != '') {
					if ($validoff == ($offset * $offsetno)) {
						$separate = ',';
						$offsetno += 1;
					} else {
						$separate = '|';
					}
					$booklineexit .= $separate.$all[$counter];
				} else {
					$booklineexit = $all[$counter];
				}
				$validoff += 1;
			}
		}
		update_option('dropdown_query',$booklineexit);
	} else {
		update_option('dropdown_query',$_POST['dropdown_query']);
	}

//updates checkboxes in check_options input
	if($_POST['check_options'] != '') {
		$options = explode(',', $_POST['check_options']);
		for ($counter = 0; $counter < count($options); $counter += 1) {
			if ($_POST[$options[$counter]]=="1"){
				update_option($options[$counter], 'true');
			} else {
				update_option($options[$counter], 'false');			
			}
		}

	}

//updates other options like what wordpress would do, i.e. via page_options input
	if($_POST['page_options'] != '') {
		$options = explode(',', $_POST['page_options']);
		for ($counter = 0; $counter < count($options); $counter += 1) {
			if ($_POST[$options[$counter]] != '')
				update_option($options[$counter], $_POST[$options[$counter]]);
		}

	}

//When everything is done...
	echo '<div id="message" class="updated fade"><p><strong>Options saved.</strong></p></div>';
}
}

function Dropdown_optionspage() {
global $dropdown_all;
	switch ($task) {
	case '':
	//Options page
?>
<div class="wrap">
<h2><?php _e('Social Dropdown configuration'); ?></h2>
<?php
@include('ping.php');
if (!function_exists('Dropdown_CheckIntegrity')) {
echo '<p>The plugin may not be installed properly as certain files are missing.</p>';
}
?>
<?php
error_reporting(0); //Don't show errors
UpdateDropOptions();
?>
<form method="post">
<?php wp_nonce_field('update-options'); ?>
<h3><?php _e('Main options'); ?></h3>
<table class="form-table" border="0">
<tr valign="top">
<th scope="row" style="text-align: left;">Link to the plugin's homepage</th>
<td>
<p><input type="radio" name="dropdown_allowlinkback" id="dropdown_allowlinkback" value="true" <?php if (get_option('dropdown_allowlinkback') == 'true') { echo ' checked="checked"'; } ?> /><?php _e('Yes'); ?><br />
<input type="radio" name="dropdown_allowlinkback" id="dropdown_allowlinkback" value="false" <?php if (get_option('dropdown_allowlinkback') != 'true') { echo ' checked="checked"'; } ?> /><?php _e('No'); ?><br />
A link back is certainly appreciated. Default: <code>Yes</code></p>
</td></tr>
<th scope="row" style="text-align: left;">Use old version</th>
<td>
<p><input type="radio" name="dropdown_uselegacy" id="dropdown_uselegacy" value="true" <?php if (get_option('dropdown_uselegacy') == 'true') { echo ' checked="checked"'; } ?> /><?php _e('Yes'); ?><br />
<input type="radio" name="dropdown_uselegacy" id="dropdown_uselegacy" value="false" <?php if (get_option('dropdown_uselegacy') != 'true') { echo ' checked="checked"'; } ?> /><?php _e('No'); ?><br />
If you do not like the new styles, you could always use the old one. Default: <code>No</code></p>
</td></tr>
<tr valign="top">
<th scope="row" style="text-align: left;">Show Bookmarks as Dropdown</th>
<td>
<p><input type="radio" name="dropdown_use" id="dropdown_use" value="true" <?php if (get_option('dropdown_use') == 'true') { echo ' checked="checked"'; } ?> /><?php _e('Yes'); ?><br />
<input type="radio" name="dropdown_use" id="dropdown_use" value="false" <?php if (get_option('dropdown_use') != 'true') { echo ' checked="checked"'; } ?> /><?php _e('No'); ?><br />
Setting this to <code>No</code> will show bookmarks without the dropdown, making it similar to other bookmarking plugins. Default: <code>Yes</code></p>
<?php if (get_option('dropdown_use') == 'true') { ?>
</td></tr>
<tr valign="top">
<th scope="row" style="text-align: left;">Dropdown width</th>
<td><p><input type="text" name="dropdown_width" id="dropdown_width" value="<?php echo get_option('dropdown_width'); ?>" /><br />
Default: 400px</p>
<?php } else { ?>
<input type="hidden" name="dropdown_width" id="dropdown_width" value="<?php echo get_option('dropdown_width'); ?>" />
<?php } ?>
</td>
</tr>
</table>
<h3>Customize bookmarks</h3>
<?php include('configinterface.php'); ?>


<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="dropdown_uselegacy,dropdown_allowlinkback,dropdown_use,dropdown_configmode,dropdown_width" />



<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options &raquo;') ?>" />
</p>
<h3>Other information</h3>
<p>Don't forget to put in <code>&lt;?php Show_Dropdown(); ?&gt;</code> into the Wordpress loop which usually resides in your index.php file in your Wordpress theme if you are not automatically embedding the dropdown in your posts.</p>
<p>You can split up the HTML version of the plugin (shown to non-JavaScript users) and the Dropdown link by using <code>&lt;?php Dropdown_html(true); ?&gt;</code> for the HTML portion and <code>&lt;?php Dropdown_javascript(); ?&gt;</code> for the JavaScript portion.
<p>This plug-in does not interfere with your site's search engine optimisation (SEO) as most links are &quot;nofollowed&quot;.</p>
<?php Dropdown_Updatecheck(); ?>
</form>

</div>
<?php
	break;
	}
}

function Dropdown_Updatecheck() {
global $dropdownversion;
//Checks for an update
$fp = @fsockopen("www.tevine.com", 80, $errno, $errstr, 30); //suppress errors
if (!$fp) {
    echo "<p>The current revision of the plugin is ".$dropdownversion.". Updates can be found at the <a href=\"http://www.tevine.com/projects/socialdropdown/\" title=\"Social Dropdown\">plugin page</a>.</p>\n";
} else {
    $out = "GET /projects/socialdropdown/latest.txt HTTP/1.1\r\n";
    $out .= "Host: www.tevine.com\r\n";
    $out .= "Connection: Close\r\n\r\n";

    fwrite($fp, $out);
$fitm = '';
    while (!feof($fp)) {
        $fitm .= fread($fp, 128);
    }
    fclose($fp);
}
      // strip the headers
      $pos      = strpos($fitm, "\r\n\r\n");
      $response = substr($fitm, $pos + 4);
	$response = (string) $response;
if (Dropdown_Checkversion($response)) {
	echo '<p>A newer version is available - '.$response.'. Please <a href="http://www.tevine.com/projects/socialdropdown/" title="Social Dropdown">update</a>.</p>';
} else {
	echo '<p>You are currently using the latest version.</p>';
}
}

//A function that mimics how wordpress deals with version numbers
//Modified to work with higher version numbers
function Dropdown_Checkversion($version) {
global $dropdownversion;
$verfrag = explode('.',$version);
$plufrag = explode('.',$dropdownversion);
//Check 3 levels only
if (((int) $verfrag[0]) < ((int) $plufrag[0])) {
	return false;
} else {
	if (((int) $verfrag[1]) < ((int) $plufrag[1])) {
		return false;
	} else {
		if (((int) $verfrag[2]) < ((int) $plufrag[2])) {
			return false;
		} else {
			return true;
		}
	}
}
}

function Dropdown_options() {
	if (function_exists('add_options_page')) {
		add_options_page("Social Dropdown", "Social Dropdown", 8, "dropdownconfig", "Dropdown_optionspage");
	}
}


function GenerateAll() {
//Makes it easier to handle the links and images
//Put GenerateLink('separator'); to separate the links into another line

//These will be generated in the dropdown area if $overrideoptions (found in generatebookmarks.php) is set to true.
//If $overrideoptions is set to false, the bookmarks displayed will use those from the options.

global $overrideoptions;

if ($overrideoptions == 'true') {

GenerateLink('blinkbits');
GenerateLink('blinklist');
GenerateLink('bloglines');
GenerateLink('blogmarks');
GenerateLink('buddymarks');
GenerateLink('citeulike');
GenerateLink('comments');
GenerateLink('delicious');
GenerateLink('digg');
GenerateLink('diigo');
GenerateLink('separator'); //Separator
GenerateLink('fark');
GenerateLink('feedmelinks');
GenerateLink('furl');
GenerateLink('google');
GenerateLink('linkagogo');
GenerateLink('magnolia');
GenerateLink('misterwong');
GenerateLink('newsvine');
GenerateLink('propeller');
GenerateLink('reddit');
GenerateLink('separator'); //Separator
GenerateLink('rawsugar');
GenerateLink('rojo');
GenerateLink('simpy');
GenerateLink('sphinn');
GenerateLink('spurl');
GenerateLink('squidoo');
GenerateLink('stumbleupon');
GenerateLink('tailrank');
GenerateLink('technorati');
GenerateLink('yahoo');

} else {
DisplayBookmarks();
}
}

function NoJavaGenerateAll() {
//Makes it easier to handle the links and images
//Put GenerateLink('separator'); to separate the links into another line

//Set $usenonjavaset = 'true' to use this. Otherwise it will use the bookmarks you configured in the administration panel.
//This will be generated if the user has no JavaScript - keep it as few as possible
GenerateLink('blinkbits');
GenerateLink('blinklist');
GenerateLink('bloglines');
GenerateLink('blogmarks');
GenerateLink('citeulike');
GenerateLink('comments');
GenerateLink('delicious');
GenerateLink('digg');
GenerateLink('diigo');
GenerateLink('feedmelinks');
GenerateLink('separator'); //Separator
GenerateLink('furl');
GenerateLink('google');
GenerateLink('reddit');
GenerateLink('sphinn');
GenerateLink('spurl');
GenerateLink('squidoo');
GenerateLink('stumbleupon');
GenerateLink('tailrank');
GenerateLink('technorati');
GenerateLink('yahoo');
}

$isfirst = '';

function Show_Dropdown() {
global $dropdown_uselegacy;
if ($dropdown_uselegacy != 'true') {
Dropdown_html();
} else {
global $isfirst, $usedropdown, $usenonjavaset, $dropdown_width;
?>
<div id="dropdisp<?php the_ID(); ?>"><div class="nojavadropcontent" style="text-align: center;"><p>Bookmark this article!<?php if (get_option('dropdown_allowlinkback') != 'false') { ?> <span><a style="color: #CCCCCC;"  rel="<?php if ($isfirst == '' && is_home()) { $isfirst = 'false'; } else { echo 'nofollow'; } ?>" href="http://www.tevine.com/projects/socialdropdown/" title="About Social Dropdown">[?]</a></span><?php } ?></p><p><?php
if ($usenonjavaset == 'true') {
NoJavaGenerateAll();
} else {
//Default case
GenerateAll();
}
?></p></div></div>
<?php if($usedropdown == 'true') { ?>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
var menu<?php the_ID(); ?>=new Array()
menu<?php the_ID(); ?>[0]= '<div class="dropcontent"><p>Bookmark this article!<?php if (get_option('dropdown_allowlinkback') != 'false') { ?> <span><a style="color: #CCCCCC;" href="http://www.tevine.com/projects/socialdropdown/" rel="nofollow" title="Social Dropdown">[?]</a></span><?php } ?></p><p><?php
GenerateAll();
?></p><?php if (get_option('dropdown_allowlinkback') != 'false') { ?><?php } ?></div>';
var droptext = "<p class=\"taskbuttoncontainer\"><span class=\"booktaskbutton\"><a class=\"bookbutton\" id=\"bookbutton<?php the_ID(); ?>\" href=\"javascript:void(0);\" onclick=\"return dropdownmenu(document.getElementById('bookbutton<?php the_ID(); ?>'), event, menu<?php the_ID(); ?>, '<?php echo $dropdown_width; ?>', document.getElementById('bookdropbutton<?php the_ID(); ?>'))\" onmouseout=\"\" title=\"Bookmarking options\">Bookmark This</a><a class=\"dropdownbutton\" id=\"bookdropbutton<?php the_ID(); ?>\" href=\"javascript:void(0);\" onclick=\"return dropdownmenu(document.getElementById('bookbutton<?php the_ID(); ?>'), event, menu<?php the_ID(); ?>, '<?php echo $dropdown_width; ?>', document.getElementById('bookdropbutton<?php the_ID(); ?>'))\" onmouseout=\"\" title=\"Bookmarking options\">&nbsp;</a></span> </p>";
var itemdrop = document.getElementById('dropdisp<?php the_ID(); ?>');
itemdrop.innerHTML = droptext;
//--><!]]>
</script>
<?php
}

}

}

function GenerateLink($type) {
if ($type != 'separator') {
?><a class="link" rel="nofollow" title="<?php GenerateName($type); ?>" href="<?php GenerateURL($type) ?>"><img alt="<?php GenerateName($type); ?>" src="<?php echo get_settings('siteurl'); ?>/<?php echo str_replace("\\","/", GetDropPluginPath()); ?>/icons/<?php echo $type; ?>.png" /></a><?php
} else {
echo "</p><p>";
}
}

function GenerateName($type) {
//Helps allocate a proper name for the social bookmarking site
switch ($type) {
case 'blinkbits':
echo 'Blinkbits';
break;
case 'blinklist':
echo 'BlinkLists';
break;
case 'bloglines':
echo 'BlogLines';
break;
case 'blogmarks':
echo 'Blogmarks';
break;
case 'buddymarks':
echo 'Buddymarks';
break;
case 'bumpzee':
echo 'BumpZee';
break;
case 'citeulike':
echo 'CiteULike';
break;
case 'comments':
echo 'Co.mments';
break;
case 'delicious':
echo 'Del.icio.us';
break;
case 'digg':
echo 'Digg';
break;
case 'diigo':
echo 'Diigo';
break;
case 'facebook':
echo 'Facebook';
break;
case 'feedmelinks':
echo 'Feed Me Links';
break;
case 'fark':
echo 'Fark';
break;
case 'faves':
echo 'Faves';
break;
case 'furl':
echo 'Furl';
break;
case 'gravee':
echo 'Gravee';
break;
case 'google':
echo 'Google';
break;
case 'hugg':
echo 'Hugg';
break;
case 'jeqq':
echo 'Jeqq';
break;
case 'linkagogo':
echo 'Linkagogo';
break;
case 'live':
echo 'Windows Live';
break;
case 'magnolia':
echo 'ma.gnolia';
break;
case 'misterwong':
echo 'Mister Wong';
break;
case 'netvouz':
echo 'Netvouz';
break;
case 'newsvine':
echo 'Newsvine';
break;
case 'onlywire':
echo 'OnlyWire';
break;
case 'propeller':
echo 'Propeller';
break;
case 'reddit':
echo 'Reddit';
break;
case 'simpy':
echo 'Simpy';
break;
case 'slashdot':
echo 'SlashDot';
break;
case 'sphinn':
echo 'Sphinn';
break;
case 'spurl':
echo 'Spurl';
break;
case 'squidoo':
echo 'Squidoo';
break;
case 'stumbleupon':
echo 'StumbleUpon';
break;
case 'tagthat':
echo 'Tagthat';
break;
case 'tagtooga':
echo 'Tagtooga';
break;
case 'taggly':
echo 'Taggly';
break;
case 'tailrank':
echo 'Tailrank';
break;
case 'technorati':
echo 'Technorati';
break;
case 'rojo':
echo 'Rojo';
break;
case 'rawsugar':
echo 'Rawsugar';
break;
case 'yahoo':
echo 'Yahoo';
break;
default:
echo ucfirst($type);
break;

}
}

function GenerateURL($type) {
$socialuri = '';
switch ($type) {
case 'blinkbits':
echo htmlentities('http://www.blinkbits.com/bookmarklets/save.php?v=1&source_url='.get_permalink().'&Title='.get_the_title());
break;
case 'blinklist':
echo htmlentities('http://www.blinklist.com/index.php?Action=Blink/addblink.php&Url='.get_permalink().'&Title='.get_the_title());
break;
case 'bloglines':
echo htmlentities('http://www.bloglines.com/sub/'.get_permalink());
break;
case 'blogmarks':
echo htmlentities('http://www.blogmarks.net/my/new.php?mini=1&title='.get_the_title().'&url='.get_permalink());
break;
case 'buddymarks':
echo htmlentities('http://www.buddymarks.com/add_bookmark.php?bookmark_title='.get_the_title().'&bookmark_url='.get_permalink());
break;
case 'bumpzee':
echo htmlentities('http://www.bumpzee.com/bump.php?u='.get_permalink());
break;
case 'comments':
echo htmlentities('http://co.mments.com/track?url='.get_permalink());
break;
case 'citeulike':
echo htmlentities('http://www.citeulike.org/posturl?url='.get_permalink().'&title='.get_the_title());
break;
case 'delicious':
echo htmlentities('http://del.icio.us/post?url='.get_permalink().'&title='.get_the_title());
break;
case 'digg':
echo htmlentities('http://www.digg.com/submit?phase=2&url='.get_permalink().'&title='.get_the_title());
break;
case 'diigo':
echo htmlentities('http://www.diigo.com/post?url='.get_permalink().'&title='.get_the_title());
break;
case 'feedmelinks':
echo htmlentities('http://www.feedmelinks.com/categorize?from=toolbar&op=submit&name='.get_the_title().'&url='.get_permalink());
break;
case 'facebook' :
echo htmlentities('http://www.facebook.com/share.php?u='.get_permalink());
break;
case 'fark':
echo htmlentities('http://cgi.fark.com/cgi/fark/edit.pl?new_url='.get_permalink().'&new_comment='.get_the_title());
break;
case 'faves':
echo htmlentities('http://www.faves.com/Authoring.aspx?u='.get_permalink().'&t='.get_the_title());
break;
case 'furl':
echo htmlentities('http://www.furl.net/storeIt.jsp?t='.get_the_title().'&u='.get_permalink());
break;
case 'google':
echo htmlentities('http://www.google.com/bookmarks/mark?op=edit&bkmk='.get_permalink().'&title='.get_the_title());
break;
case 'gravee':
echo htmlentities('http://www.gravee.com/account/bookmarkpop?u='.get_permalink().'&t='.get_the_title());
break;
case 'hugg':
echo htmlentities('http://www.hugg.com/node/add/storylink?edit[title]='.get_the_title().'&edit[url]='.get_permalink());
break;
case 'jeqq':
echo htmlentities('http://www.jeqq.com/submit.php?url='.get_permalink().'&title='.get_the_title());
break;
case 'linkagogo':
echo htmlentities('http://www.linkagogo.com/go/AddNoPopup?title='.get_the_title().'&url='.get_permalink());
break;
case 'live':
echo htmlentities('http://favorites.live.com/quickadd.aspx?marklet=1&mkt=en-sg&url='.get_permalink().'&title='.get_the_title().'&top=0');
break;
case 'magnolia':
echo htmlentities('http://ma.gnolia.com/bookmarklet/add?url='.get_permalink().'&title='.get_the_title());
break;
case 'misterwong':
echo htmlentities('http://www.mister-wong.com/index.php?action=addurl&bm_url='.get_permalink().'&bm_description='.get_the_title());
break;
case 'netvouz':
echo htmlentities('http://www.netvouz.com/action/submitBookmark?url='.get_permalink().'&title='.get_the_title().'&popup=no');
break;
case 'newsvine':
echo htmlentities('http://www.newsvine.com/_wine/save?popoff=0&u='.get_permalink().'&h='.get_the_title());
break;
case 'onlywire':
echo htmlentities('http://www.onlywire.com/b/?u='.get_permalink().'&t='.get_the_title());
break;
case 'propeller':
echo htmlentities('http://www.propeller.com/submit/?U='.get_permalink().'&T='.get_the_title().'C=');
break;
case 'reddit':
echo htmlentities('http://www.reddit.com/submit?url='.get_permalink().'&title='.get_the_title());
break;
case 'simpy':
echo htmlentities('http://www.simpy.com/simpy/LinkAdd.do?note='.get_the_title().'&href='.get_permalink());
break;
case 'slashdot':
echo htmlentities('http://www.slashdot.org/slashdot-it.pl?op=basic&url='.get_permalink());
break;
case 'sphinn':
echo htmlentities('http://www.sphinn.com/submit.php?url='.get_permalink().'&title='.get_the_title());
break;
case 'spurl':
echo htmlentities('http://www.spurl.net/spurl.php?url='.get_permalink().'&title='.get_the_title());
break;
case 'squidoo':
echo htmlentities('http://www.squidoo.com/lensmaster/bookmark?'.get_permalink());
break;
case 'stumbleupon':
echo htmlentities('http://www.stumbleupon.com/submit?url='.get_permalink().'&title='.get_the_title());
break;
case 'tagthat':
//German bookmarking site as requested, but this is not enabled by default
echo htmlentities('http://www.tagthat.de/bookmarken.php?action=neu&url='.get_permalink().'&title='.get_the_title());
break;
case 'tagtooga':
echo htmlentities('http://www.tagtooga.com/tapp/db.exe?c=jsEntryForm&b=fx&title='.get_the_title().'&url='.get_permalink());
break;
case 'taggly':
echo htmlentities('http://www.taggly.com/bookmarks.php/pass?action=add&address='.get_permalink());
break;
case 'tailrank':
echo htmlentities('http://www.tailrank.com/share/?title='.get_the_title().'&link_href='.get_permalink());
break;
case 'technorati':
echo htmlentities('http://www.technorati.com/faves?add='.get_permalink());
break;
case 'rawsugar':
echo htmlentities('http://rawsugar.com/home/extensiontagit/?turl='.get_permalink().'&tttl='.get_the_title());
break;
case 'rojo':
echo htmlentities('http://www.rojo.com/add-subscription/?resource='.get_permalink());
break;
case 'yahoo':
echo htmlentities('http://myweb2.search.yahoo.com/myresults/bookmarklet?t='.get_the_title().'&u='.get_permalink());
break;
}

}

include('dropdown.php');

//Runs the plugin
add_action('wp_head', 'Dropdown_header');
add_action('admin_menu', 'Dropdown_options');

?>