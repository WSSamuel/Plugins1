<?php
/*
Plugin Name: WP Javascript Detect
Plugin URI:  http://www.daddydesign.com/wordpress/javascript-detect-wordpress-plugin/
Description: This plugin will display a warning message if the browser's Javascript is disabled. No set up is required, just install and activate. Turn your browser's Javascript off to test.
Version: 1.0
Author: DaddyDesign
Author URI: http://www.daddydesign.com
License: GPL2 license name e.g. GPL2
	
	Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : daddydesign@gmail.com)

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

function wp_javascript_detect() {
  $content = '<noscript><div id="nojavascript"><p><span>WARNING:</span> We have detected that you currently have Javascript disabled. This website requires the use of Javascript, for the best possible viewing experience we highly recommend that you enable Javascript via your browser\'s options.</p></div></noscript>';
  echo $content;
}
add_action('wp_footer', 'wp_javascript_detect');


function wp_javascript_detect_style()
{

	$plugin_path=get_bloginfo('url').'/wp-content/plugins/WP-Javascript-Detect/';
	?>

	<style type="text/css">
		#nojavascript
{
	text-align:left;
	background:#F7F619;
	color:#000000;
	position:fixed;
	left:0;
	top:0;
	font-size:12px;
	padding:0px 8% 10px 8%;
	width:84%;
	line-height:16px;
	border-bottom:2px solid #000000;
}
    #nojavascript p
	{
	padding:10px 0px 10px 40px;
	margin:0px;
	overflow:hidden;
	background:url(<?php echo $plugin_path; ?>warning_symbol.png) no-repeat left;
	}
#nojavascript span
	{
	color:#FC4D00;
	font-weight:bold;
	}
    </style>
	<?php
}

add_action('wp_head', 'wp_javascript_detect_style');
?>
