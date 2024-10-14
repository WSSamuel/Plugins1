<?php defined( 'ABSPATH' ) or die( 'No direct script access!' );
###################################
## 
##	File: functions.php
##	Path: libs/php/functions.php
##	Author: Joshua Wieczorek (http://www.joshuawieczorek.com)
##      Date Created: October 7th, 2015 16:13 EDT
##      Date Modified: January 7th, 2016 15:44 EDT
##
##	-- File Description -- 
##	This file provides this plugin with the necessary functions to 
##	properly function and run.
##
###################################

###################################
## Plugin Initiate Function
###################################
/**		-- Description --
*   This function runs on page load to initiate
*   plugin functions.
*/
function jwdpv0001_init()
{
    ## If is ajax do ajax
    if ( defined('DOING_AJAX') && DOING_AJAX ) :
        ## Do ajax 
        add_action( 'wp_ajax_get_admin_verse', 'jwdpv0001_ajax_get_admin_verse' );
        add_action( 'wp_ajax_get_admin_version', 'jwdpv0001_ajax_get_admin_version' );
        add_action( 'wp_ajax_admin_vod_save', 'jwdpv0001_ajax_admin_vod_save' );
        add_action( 'wp_ajax_admin_prv_txt_save', 'jwdpv0001_ajax_admin_prv_txt_save' );
    endif;
    ## If is admin panel
    if( is_admin() ) :        
        ## Include admin files
        require_once JWDPV0001_PHP_PATH . 'admin.php';     
    ## Otherwise
    else :        
        ## Do shortcodes in text widget
        add_filter('widget_text', 'do_shortcode');
    endif;
}

###################################
## Plugin Install Function
###################################
/**	-- Description --
*   This function runs on plugin install and sets 
*   default bible into WordPress option.
*/
function jwdpv0001_install()
{
    update_option( 'jwdpv0001_bible' , 'en_kjv.ltr.json' );
    update_option( 'jwdpv0001_proverbs' , 'Proverbs' );
    jwdpv0001_create_vod();
}

###################################
## Plugin Uninstall Function
###################################
/**	-- Description --
*   This function runs on plugin uninstall and deletes 
*   plugin data.
*/
function jwdpv0001_uninstall()
{
    ## Delete bible version
    delete_option( 'jwdpv0001_bible' );
    ## Delete verses of the day
    delete_option( 'jwdpv0001_otd' );
    ## Delete Proverbs translation
    delete_option( 'jwdpv0001_proverbs' );
}

###################################
## Create Admin Verses Page
###################################
/***   	-- Description --
*   This function creates the admin verses page.
*/
function jwdpv0001_admin_verses_page()
{    
    ## Get preset Bible
    $jwdpv0001_bible        = get_option( 'jwdpv0001_bible' );
    ## Get proverbs from Bible version
    $jwdpv0001_vod          = json_decode( file_get_contents( JWDPV0001_JSON_PATH . 'vod.json' ) , 1 );    
    ## Include admin html
    include JWDPV0001_HTML_PATH . 'admin.verses.html.php';
}

###################################
## Create Admin Versions Page
###################################
/***   	-- Description --
*   This function creates the admin versions page.
*/
function jwdpv0001_admin_version_page()
{
    ## Get all bibles 
    $jwdpv0001_all_bibles   = glob( JWDPV0001_BIBLE_PATH . '*.json' );
    ## Get preset Bible
    $jwdpv0001_bible        = get_option( 'jwdpv0001_bible' );
    ## Text direction
    $jwdpv0001_txt_dir      = explode('.', $jwdpv0001_bible);
    $jwdpv0001_txt_dir      = $jwdpv0001_txt_dir[1];
    ## Get proverbs from Bible version
    $jwdpv0001_bible_json   = file_get_contents( JWDPV0001_BIBLE_PATH . $jwdpv0001_bible );
    ## Bible decoded
    $chapters               = json_decode( $jwdpv0001_bible_json , 1 );
    ## Include admin html
    include JWDPV0001_HTML_PATH . 'admin.version.html.php';
}

###################################
## Get Current Version
###################################
/***   	-- Description --
*   This function returns the current version of Proverbs.
* after creating the array.
*/
function jwdpv0001_get_current_version()
{
    ## Get current version
    $version = get_option( 'jwdpv0001_bible' ) ? get_option( 'jwdpv0001_bible' ) : 'en_kjv.ltr.json' ;
    ## Return JSON
    return file_get_contents( JWDPV0001_BIBLE_PATH . $version );
}

###################################
## Insert/Update VOD
###################################
/***   	-- Description --
*   This function inserts/updates the verse of the day
* after creating the array.
*/
function jwdpv0001_create_vod()
{
    ## Get current version
    $bible      = json_decode( jwdpv0001_get_current_version() , 1 );
    ## Get VOD
    $vod        = json_decode( file_get_contents( JWDPV0001_JSON_PATH . 'vod.json' ) , 1 );
    ## Vod Array
    $votd       = array();
    ## Loop through vods
    foreach( $vod as $day=>$verse ) :
        ## Set day/verse into array
        $votd[$day] = array( 'num'=>$verse , 'txt'=>$bible[$day][$verse] );
    endforeach;
    ## Update VOD option
    update_option( 'jwdpv0001_otd' , $votd );    
}

###################################
## Render VOD's in admin panel
###################################
/***   	-- Description --
*   This function renders the verse of the day
* in the admin panel so they can be changed.
*/
function jwdpv0001_admin_render_verses()
{
    ## Verses 
    $verses = get_option( 'jwdpv0001_otd' );
    ## HTML for output
    $html = '';
    ## Loop through verses
    foreach ( $verses as $day=>$verse ) :
        ## Create html for each verse
        $html .= "<tr class=\"dpv-admin-vc\">";
        $html .= "<td class=\"day\">" . __( 'Daily Chapter' , 'daily-proverb' ) . " <strong>{$day}</strong>:</td>";
        $html .= "<td class=\"day\"><strong>#</strong> <input id=\"dpv-num-{$day}\" class=\"dpv-num-change\" type=\"number\" class=\"verse\" value=\"{$verse['num']}\" name=\"dpv-verses[{$day}][num]\" style=\"width:50px\"/></td>";
        $html .= "<td><input type=\"text\" class=\"jwdpv0001-vod-verse\" value=\"{$verse['txt']}\" id=\"dpv-num-change-{$day}\" class=\"dpv-num-change-txt disabled\" name=\"dpv-verses[{$day}][txt]\" style=\"width:100%;background:#eee;cursor:not-allowed\" onClick=\"this.setSelectionRange(0, this.value.length)\"></td>";
    endforeach;
    ## Return html
    return $html;
}

###################################
## Render Chapter's Verses
###################################
/***   	-- Description --
*   This function renders the verses for a specific chapter
* of Proverbs.
*/
function jwdpv0001_admin_render_verse_tabs( $num , $verses , $txt_dir='ltr' )
{
    ## HTML for output
    $html = '<div id="chapter-tab-'.$num.'">';
    ## Heading
    $html .= '<h3>' . __( 'Chapter' , 'daily-proverb' ) . ' ' . $num . '</h3>';
    ## Loop through verses
    foreach ( $verses as $num=>$txt ) :
        ## Create html for each verse
        $html .= ( $txt_dir=='ltr' ) ? '<p class="verse-left">' : '<p class="verse-right">';
        $html .= ( $txt_dir=='ltr' ) ? '<span class="vnum">' . $num . '</span> ' . $txt : '<span class="vtxt">' . $txt . '</span>' . ' <span class="vnum">' . $num . '</span>';
        $html .= '</p>';        
    endforeach;
    ## Close html container
    $html .= '</div>';
    ## Return html
    return $html;
}