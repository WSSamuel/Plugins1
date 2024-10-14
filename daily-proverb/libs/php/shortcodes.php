<?php defined('ABSPATH') or die('No direct script access!');
###################################
## 
##	File: shortcodes.php
##	Path: libs/php/shortcodes.php
##	Author: Joshua Wieczorek (http://www.joshuawieczorek.com)
##      Date Created: October 7th, 2015 16:13 EDT
##      Date Modified: January 7th, 2016 15:26 EDT
##
##	-- File Description -- 
##	This file provides this plugin with shortcodes.
##
###################################
###################################
## Returns The Daily Verse
###################################
/** 		-- Description --
 *   This function returns the Verse Of The Day
 *  by shortcode.
 */
function jwdpv0001_shortcode_verse($atts)
{
    ## Get day
    $day            = JWDPV0001_DAY;    
    ## Get bible version 
    $bVersion       = substr( array_shift( explode( '.', get_option( 'jwdpv0001_bible' ) ) ) , 3 );
    ## Get all verses
    $verses         = get_option( 'jwdpv0001_otd' );
    ## Verse
    $dpv_verse      = isset( $verses[$day]['txt'] ) ? $verses[$day]['txt'] : false;
    ## Verse safety check
    if (!$dpv_verse) :  return false; endif;
    ## Setup shortcode atts
    $a              = shortcode_atts(array(
        'class'     => 'dpv_class',
        'id'        => 'dpv_id',
        'tag'       => 'p',
        'color'     => 'inherit',
        'bcolor'    => 'inherit',
        'rcolor'    => 'inherit',
        'rbcolor'   => 'inherit',
        'version'   => 'show',
            ), $atts);
    ## Begin html
    $html           = '<div class="dpv-daily-bible-chapter">';
    ## Create html tag
    $html           .= '<' . $a['tag'] . ' id="' . $a['id'] . '" class="' . $a['class'] . '" style="color:' . $a['color'] . '; background-color:' . $a['bcolor'] . '">';
    ## Verse
    $html           .= '"' . $dpv_verse . '"';
    ## End html tag
    $html           .= '</' . $a['tag'] . '>';
    ## Add verse citation
    $html           .= "<p style=\"text-align:right;padding-right:0px;font-style:italic;color:{$a['rcolor']}; background-color:{$a['rbcolor']}\">&#8212;". get_option( 'jwdpv0001_proverbs' ) ." {$day}:{$verses[$day]['num']}";
    ## Show version show/hide
    $html           .= ( $a['version']=='show' ) ? " ({$bVersion})</p>" : '</p>';
    ## Close containing "div"
    $html           .= '</div>';
    ## Do shortcode
    $rendered = do_shortcode($html);
    ## Return rendered html
    return $rendered;
}
## Add shortcode
add_shortcode( 'dpv-verse' , 'jwdpv0001_shortcode_verse' );