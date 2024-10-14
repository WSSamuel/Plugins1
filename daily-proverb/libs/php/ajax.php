<?php
###################################
## 
##	File: ajax.php
##	Path: libs/php/ajax.php
##	Author: Joshua Wieczorek (http://www.joshuawieczorek.com)
##      Date Created: October 7th, 2015 16:13 EDT
##      Date Modified: January 7th, 2016 15:20 EDT
##
##	-- File Description -- 
##	This file provides this plugin with the necessary functions to 
##	process ajax calls.
##
###################################

###################################
## AJAX - Get Single Verse
###################################
/**		-- Description --
*   This function returns a single verse for
* verse change in the dashboard.
*/
function jwdpv0001_ajax_get_admin_verse() 
{		
        ## Get and clean the day/chapter
        $day            = (int) filter_input( INPUT_POST , 'day' , FILTER_SANITIZE_NUMBER_INT );
        ## Get and clean the verse
        $verse          = (int) filter_input( INPUT_POST , 'verse' , FILTER_SANITIZE_NUMBER_INT );
        ## Get the book
        $book           = json_decode( jwdpv0001_get_current_version() , 1 );
        ## Default return text
        $text 		= __( 'No verse found!' , 'daily-proverb' );
        ## Default return response
        $response	= 'N';
        ## If verse exists, then return it.
        if( isset( $book[$day][$verse] ) ) :                
            ## Set response to Y for yes
            $response   = 'Y';
            ## Set text to verse
            $text	= $book[$day][$verse];
        endif;
        ## Return the json to the jQuery caller.
        echo json_encode( array( 'response' => $response , 'text' => $text ) ); wp_die();
        ## Kill the function
        wp_die();
}

###################################
## AJAX - Get Version
###################################
/**		-- Description --
*   This function returns a specified version.
*/
function jwdpv0001_ajax_get_admin_version() 
{	
    ## Get posted version
    $version    = filter_input( INPUT_POST , 'version' );
    ## Get version file
    $v_file     = JWDPV0001_BIBLE_PATH . $version;
    ## If file exists
    if(file_exists( $v_file ) ) :
        ## Update the bible version option
        update_option( 'jwdpv0001_bible' , $version );
        ## Update the Verses of The Day to current version
        jwdpv0001_create_vod();
        ## Print json decoded file
        print_r( json_decode( file_get_contents( $v_file ) , 1 ) );
    else:
        ## Print failed text
        _e( 'Something went worng, please try again! Error: JSON file not found.' , 'daily-proverb' );
    endif;
    ## Kill wordpress
    wp_die();
}

###################################
## AJAX - Save VOD
###################################
/**		-- Description --
*   This function saves the Verses Of The Day.
*/
function jwdpv0001_ajax_admin_vod_save()
{    
    ## Get and clean action type
    $action = filter_input( INPUT_POST , 'method' , FILTER_DEFAULT );
    ## Get and clean verses array
    $verses = filter_input( INPUT_POST , 'verses' , FILTER_DEFAULT , FILTER_REQUIRE_ARRAY );    
    ## If action is "save"
    if( $action=='save' ) :                
        ## Create
        $save_array = array();    
        ## Loop through verses array
        foreach ( $verses as $num => $verse ):           
            ## Populate "save array"
            $save_array[($num+1)] = array( 'num'=>$verse[0] , 'txt'=>$verse[1] );
        endforeach;        
        ## Update verses of the day with newly created array
        update_option( 'jwdpv0001_otd' , $save_array );
        ## Print success text
        _e( 'Verse updated successfully!' , 'daily-proverb' );
        ## Kill wordpress
        wp_die();
    ## If action os "reset"
    elseif( $action=='reset' ) :        
        ## Reset verses of the day
        jwdpv0001_create_vod();        
        ## Print success text
        _e( 'Verses successfully reset!' , 'daily-proverb' );
        ## Kill wordpress
        wp_die();        
    endif;
}

###################################
## AJAX - Save "Proverbs" Text
###################################
/**		-- Description --
*   This function saves the "Proverbs" text.
*/
function jwdpv0001_ajax_admin_prv_txt_save()
{
    ## Proverbs cleaned
    $text = filter_input( INPUT_POST , 'prvtxt' , FILTER_SANITIZE_STRING );
    ## Update text
    update_option( 'jwdpv0001_proverbs' , $text );
    ## Success message
    _e( 'Successfully Saved!' , 'daily-proverb' );
    ## Kill wordpress
    wp_die();
}