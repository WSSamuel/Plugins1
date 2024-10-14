<?php
/*
Plugin Name: Custom Word Cloud
Plugin URI: 
Description: Creates custom word cloud images based on page content or POST variable named content.
Version: 0.3
Author: Bryan Nielsen
Author URI: 

Copyright 2010 Bryan Nielsen
bnielsen1965@gmail.com

This script is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This script is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/


/**
 * Shortcode usage for pages.
 *
 * simple use, [cwcimage] will be replaced with an <img> tag
 * referencing the new word cloud image created with the page
 * content:
 * [cwcloud]
 * [cwcimage]
 * page content
 * [/cwcloud]
 *
 * attributes:
 * id - specify an id to use for this word cloud image
 * old_age - number of seconds before old images are removed from the cache
 * seconds_to_live - seconds before the cached image will be redrawn
 * width - width of the cloud image
 * height - height of the cloud image
 * post - set to "true" if data will be posted from a form
 * palette - color palette in web hex codes
 * angle - the angle to tilt each word, "random" or 0 to 360
 * double_angle - randomly flip words to the opposite angle
 * word_limit - maximum number of words in cloud
 * font_file - the ttf font file in the fonts directory to use
 * word_margin - margin around each word in cloud
 * exclude_words - words to exclude from counting
 * charlist - list of additional extra characters to accept in words
 *
 * shortcodes:
 * [cwcloud] [/cwcloud] - must always be used as an enclosed short code
 * [cwcid] - the id of the cloud image, useful in forms
 * [cwcform] - provides cloud parameter form elements ready to use in a form
 * [cwcform_angle] - provides the angle form input element
 * [cwcform_double_angle] - provides the double_angle form checkbox
 * [cwcform_font_file] - provides the form font file select
 * [cwcform_width] - provides the form width input
 * [cwcform_height] - provides the form height input
 * [cwcform_word_margin] - provides the word margin input
 * [cwcform_palette] - provides the form input for the color palette
 * [cwcform_word_limit] - provides the form input for the word limit
 * [cwcform_exclude_words] - provides the form input for excluded words
 * [cwcpostcontent] - provides the posted content, useful for a form textarea
 * [cwimage] - provides an <img> tag pointing to the cloud image
 * [cwcdownloadlink] - creates an HTML Download link to download the current cloud image
 * [cwcdownloadbutton] - creates an HTML form button to download the current cloud image
 *
 * advanced example, form to accept input:
 * [cwcloud post="true" id="mycloud"]
 * [cwcimage]
 * <form method="post"><textarea cols="40" rows="10" name="content">[cwcpostcontent]</textarea>
 * [cwcform]
 * <input type="submit" value="Build Cloud" />
 * </form>
 * [/cwcloud]
 * 
 * @uses word_cloud, wordle_tags()
 * @param    array    $atts     Shortcode attributes.
 * @return   string             A string of the modified page content.
 */
function cwcloud_shortcode($atts, $content=NULL, $code="") {
  // extract attributes
  extract(shortcode_atts(array(
    'id' => NULL,
    'old_age' => 604800,
    'seconds_to_live' => 5,
    'width' => 500,
    'height' => 500,
    'post' => '',
    'palette' => '#ffffff,#000000',
    'angle' => '0',
    'double_angle' => 'false',
    'word_limit' => 10,
    'font_file' => 'DejaVuSansMono-Roman.ttf',
    'word_margin' => 5,
    'exclude_words' => NULL,
    'charlist' => ''
    ), 
    $atts));

  // clean the cache directory
  $cd = dir(dirname(__FILE__).'/cache/');
  while( ($entry = $cd->read()) !== FALSE ) {
    if( preg_match('/^\./', $entry) == 0 ) {
      if( time() - filemtime(dirname(__FILE__).'/cache/'.$entry) > intval($old_age) ) unlink(dirname(__FILE__).'/cache/'.$entry);
    }
  }
  $cd->close();

  // post overrides on attributes
  if( $post == 'true' ) {
    if( isset($_POST['width']) ) $width = $_POST['width'];
    if( isset($_POST['height']) ) $height = $_POST['height'];
    if( isset($_POST['palette']) ) $palette = $_POST['palette'];
    if( isset($_POST['angle']) ) $angle = $_POST['angle'];
    if( isset($_POST['double_angle']) ) $double_angle = $_POST['double_angle'];
    if( isset($_POST['word_limit']) ) $word_limit = $_POST['word_limit'];
    if( isset($_POST['font_file']) ) $font_file = $_POST['font_file'];
    if( isset($_POST['word_margin']) ) $word_margin = $_POST['word_margin'];
    if( isset($_POST['exclude_words']) ) $exclude_words = $_POST['exclude_words'];
    if( isset($_POST['charlist']) ) $charlist = $_POST['charlist'];
  }

  // if exclude words was passed then form into an array
  if( $exclude_words ) $exclude_words = explode(',', $exclude_words);

  // make sure we have an id before continuing
  if( is_null($id) ) {
    // check for form post first
    if( isset($_POST['cwc_id']) ) {
      $pi = pathinfo($_POST['cwc_id']);
      $id = $pi['filename'];
    }
    else {
      // create a new id
      $r = rand(0, 9999);
      $id = date('Y-m-d-H-i-s').substr('000', 0, 4 - strlen($r)).$r;
    }
  }

  // make sure id is cleaned up for use as a filename
  $id = str_replace(array('..', '/'), '', $id);

  // make sure font file is cleaned up for use as a filename
  $font_file = str_replace(array('..', '/'), '', $font_file);

  // assume we will have a cloud
  $havecloud = TRUE;

  // if an image map is requested then force a new image
  if( preg_match('/\[cwcmap\]/', $content) ) $makemap = TRUE;
  else $makemap = FALSE;
  $map = "";

  // if the file for this id does not exist or has passed its seconds to live then create a new image
  clearstatcache();
  if( $makemap || !file_exists(dirname(__FILE__).'/cache/'.$id.'.png') || 
      time() - filemtime(dirname(__FILE__).'/cache/'.$id.'.png') > intval($seconds_to_live) && 
      !is_null($content) ) {

    include('wordcount.php');
    $countobj = new wordcount();

    include('wordcloud.php');
    $cloudobj = new wordcloud();

    // determine what will be used as the word count content, either posted data or the page
    $wc = '';
    if( $post === 'true' && isset($_POST['content']) ) $wc = ( get_magic_quotes_gpc() ? stripslashes_deep($_POST['content']) : $_POST['content']);
    else if( $post !== 'true' ) $wc = $content;

    if( strlen($wc) > 0 ) {
      // strip any HTML formating tags
      $wc = strip_tags($wc);

      // set up parameters for the word count and word cloud
      $parameters = array();
      $parameters['fontfile'] = $font_file;
      $parameters['filename'] = dirname(__FILE__).'/cache/'.$id.'.png';
      $parameters['width'] = $width;
      $parameters['height'] = $height;
      $parameters['palette'] = $palette;
      $parameters['angle'] = $angle;
      $parameters['double_angle'] = $double_angle;
      $parameters['margin'] = intval($word_margin);
      $parameters['word_limit'] = intval($word_limit);
      if( $exclude_words ) $parameters['exclude_words'] = $exclude_words;
      $parameters['charlist'] = $charlist;

      // try making the cloud
      $havecloud = $cloudobj->makecloud($countobj->countwords($wc, $parameters), $parameters);

      if( $makemap && is_array($havecloud) ) {
        $map = '<map name="wordcloudmap">'."\r\n";
        foreach( $havecloud as $polygon ) {
          $map .= '<area shape="poly" coords="';
          for( $i = 0; $i < 8; $i++ ) $map .= ($i > 0?',':'').$polygon[$i];
          $map .= '" href="http://google.com?q='.$polygon['word'].'" title="'.$polygon['word'].'">'."\r\n";
        }
        $map .= "</map>\r\n";
      }
    }
    else $havecloud = FALSE;
  }

  // create form input elements for post form in case requested
  $inputangle = '<input name="angle" type="text" value="'.$angle.'" />';

  $inputdouble_angle = '<input name="double_angle" type="checkbox" value="true"';
  if( $double_angle == 'true' ) $inputdouble_angle .= ' checked';
  $inputdouble_angle .= ' />';

  $inputfont_file = '<select name="font_file">';
  $cd = dir(dirname(__FILE__).'/fonts/');
  while( ($entry = $cd->read()) !== FALSE ) {
    if( preg_match('/^\./', $entry) == 0 && preg_match('/.*\.ttf$/i', trim($entry)) > 0 ) {
      $inputfont_file .= '<option value="'.$entry.'"';
      if( $font_file == $entry ) $inputfont_file .= ' selected';
      $inputfont_file .= '>'.$entry.'</option>';
    }
  }
  $cd->close();

  $inputfont_file .= '</select>';
  $inputwidth = '<input name="width" type="text" value="'.$width.'" />';
  $inputheight = '<input name="height" type="text" value="'.$height.'" />';
  $inputword_margin = '<input name="word_margin" type="text" value="'.$word_margin.'" />';
  $inputpalette = '<input name="palette" type="text" value="'.$palette.'" />';
  $inputword_limit = '<input name="word_limit" type="text" value="'.$word_limit.'" />';
  $inputexclude_words = '<input name="exclude_words" type="text" value="'.($exclude_words && is_array($exclude_words) ? implode(',', $exclude_words) : '').'" />';
  $inputcharlist = '<input name="charlist" type="text" value="'.$charlist.'" />';

  $inputform = '<table class="form-table">';
  $inputform .= '<tr valign="top"><th scope="row">'.__("Angle").'</th><td>'.$inputangle.' "random" or a number</td></tr>';
  $inputform .= '<tr valign="top"><th scope="row">'.__("Double Angle").'</th><td>'.$inputdouble_angle.'</td></tr>';
  $inputform .= '<tr valign="top"><th scope="row">'.__("Font File").'</th><td>'.$inputfont_file.'</td></tr>';
  $inputform .= '<tr valign="top"><th scope="row">'.__("Width").'</th><td>'.$inputwidth.'</td></tr>';
  $inputform .= '<tr valign="top"><th scope="row">'.__("Height").'</th><td>'.$inputheight.'</td></tr>';
  $inputform .= '<tr valign="top"><th scope="row">'.__("Word Margin").'</th><td>'.$inputword_margin.' extra space around each word</td></tr>';
  $inputform .= '<tr valign="top"><th scope="row">'.__("Palette").'</th><td>'.$inputpalette.' color values, e.g. #ffffff, #000000</td></tr>';
  $inputform .= '<tr valign="top"><th scope="row">'.__("Word Limit").'</th><td>'.$inputword_limit.' maximum number of words</td></tr>';
  $inputform .= '<tr valign="top"><th scope="row">'.__("Character List").'</th><td>'.$inputcharlist.' additional word characters</td></tr>';
  $inputform .= '</table>';


  // insert id in content
  $content = str_replace('[cwcid]', $id, $content);

  // insert form elements and values
  $content = str_replace('[cwcform]', $inputform, $content);
  $content = str_replace('[cwcform_angle]', $inputangle, $content);
  $content = str_replace('[cwcform_double_angle]', $inputdouble_angle, $content);
  $content = str_replace('[cwcform_font_file]', $inputfont_file, $content);
  $content = str_replace('[cwcform_width]', $inputwidth, $content);
  $content = str_replace('[cwcform_height]', $inputheight, $content);
  $content = str_replace('[cwcform_word_margin]', $inputword_margin, $content);
  $content = str_replace('[cwcform_palette]', $inputpalette, $content);
  $content = str_replace('[cwcform_word_limit]', $inputword_limit, $content);
  $content = str_replace('[cwcform_exclude_words]', $inputexclude_words, $content);

  // insert content into content
  if( $post == 'true' && isset($_POST['content']) ) $content = str_replace('[cwcpostcontent]', $wc, $content);
  else $content = str_replace('[cwcpostcontent]', '', $content);

  // if we have a cloud image then insert content
  if( $havecloud ) {
    // insert a download link
    $content = str_replace('[cwcdownloadlink]', '<a href="'.get_option('siteurl').'/wp-content/plugins/custom-word-cloud/downloadcloud.php?id='.$id.'">Download</a>', $content);

    // insert a download button
    $content = str_replace('[cwcdownloadbutton]', '<input type="button" value="Download" onclick="window.location=\''.get_option('siteurl').'/wp-content/plugins/custom-word-cloud/downloadcloud.php?id='.$id.'\'" />', $content);

    // create img tag
    $imgtag = '<img src="'.get_option('siteurl').'/wp-content/plugins/custom-word-cloud/cache/'.$id.'.png"'.
    (strlen($map) > 0?' usemap="#wordcloudmap"':'').
    ' />';

    // insert cloud image into content
    $content = str_replace('[cwcimage]', $imgtag, $content);

    // insert cloud image map
    $content = str_replace('[cwcmap]', $map, $content);
  }
  else {
    $content = str_replace('[cwcdownloadlink]', '', $content);
    $content = str_replace('[cwcdownloadbutton]', '', $content);
    $content = str_replace('[cwcimage]', '', $content);
    $content = str_replace('[cwcmap]', '', $content);
  }

  return $content;
}

add_shortcode('cwcloud', 'cwcloud_shortcode');
?>
