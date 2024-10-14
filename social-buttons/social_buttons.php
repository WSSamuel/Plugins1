<?php
/*
Plugin Name: Social Buttons
Plugin URI: http://www.alexpooley.com
Description: Selectively add social network buttons to your posts, or theme design.
Version: 1.0
Author: Alex Pooley
Author URI: http://www.alexpooley.com
*/


define('APSB_REGEXP', '%\[SB (.+)\]%i');


/**
 * Return HTML of a button that can be placed anywhere on a site.
 *
 * Here's the list of supported networks, and where to find more detail for each network.
 *
 * SPHINN: http://sphinn.com/tools.php
 * DIGG: http://digg.com/tools/integrate
 * REDDIT: http://reddit.com/buttons
 * DELICIOUS: http://del.icio.us/help/savebuttons
 * DZONE: http://www.dzone.com/links/buttons.jsp
 * STUMBLE UPON: http://www.stumbleupon.com/buttons.php?pgtype=blog
 * 
 * TODO
 * - Have configurable button text/images.
 * - Pass descriptions through for some buttons.
 *
 */
function sb_make_button($type, $url, $title)
{
	$type = strtolower(trim($type));
	$button = '';
  switch ($type) {
		case 'sphinn':
			$button = "<script type='text/javascript'>submit_url = '$url';</script><script type='text/javascript' src='http://sphinn.com/evb/button.php'></script>";
			break;
		case 'digg':
			$button = "<script type='text/javascript'>digg_url = '$url';</script><script src='http://digg.com/tools/diggthis.js' type='text/javascript'></script>";
			break;
		case 'reddit':
		case 'reddit1':
		case 'reddit2':
		case 'reddit3':
		  list($version) = sscanf($type, 'reddit%d');
			if (!$version) $version = 1;
			$button = "<script>reddit_url='$url'; reddit_title='$title';</script><script type='text/javascript' src='http://reddit.com/button.js?t=$version'></script>";
			break;
		case 'delicious':
			$button = "<a href='http://del.icio.us/post' onclick=\"window.open('http://del.icio.us/post?v=4&noui&jump=close&url='+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title), 'delicious','toolbar=no,width=700,height=400'); return false;\">Save To Delicious</a>";
			break;
		case 'dzone':
		case 'dzone1':
		case 'dzone2':
		  list($version) = sscanf($type, 'dzone%d');
			if (!$version) $version = 1;
			$button = "<script type='text/javascript'>var dzone_url = '$url';</script>";
			$button .= "<script type='text/javascript'>var dzone_title = '$title';</script>";
			# <script type="text/javascript">var dzone_blurb = '[description]';</script>
			$button .= "<script type='text/javascript'>var dzone_style = '$version';</script>";
			$button .= "<script language='javascript' src='http://widgets.dzone.com/widgets/zoneit.js'></script>";
			break;
		case 'stumble':
		case 'stumbleupon':
			$button = "<a href=\"http://www.stumbleupon.com/submit?url=$url&title=$title\">Stumble it!</a>";
			break;
		default:
			$button = null;
			break;
	}
	return $button;
}


/**
 * Filter the post for any [SB .*] text and replace with button HTML.
 */
function ap_process_sb_tag_callback($match)
{
	$buttons = array();

	// Parse to find which buttons the user wants added to their post.
	$types = split(',', $match[1]);

	global $wp_query;
	foreach($types as $type) {
		array_push($buttons, sb_make_button($type, $wp_query->post->guid, $wp_query->post->title));
	}
	return join('', $buttons);
}



function ap_process_sb_tag($content)
{
	$content = preg_replace_callback(APSB_REGEXP, 'ap_process_sb_tag_callback', $content);
	return ($content);
}


add_filter('single_post_title', 'ap_process_sb_tag');
add_filter('the_content', 'ap_process_sb_tag');
add_filter('the_content_rss', 'ap_process_sb_tag');
add_filter('the_excerpt', 'ap_process_sb_tag');
add_filter('the_excerpt_rss', 'ap_process_sb_tag');
add_filter('the_title', 'ap_process_sb_tag');
add_filter('the_title_rss', 'ap_process_sb_tag');
add_filter('wp_title', 'ap_process_sb_tag');

?>
