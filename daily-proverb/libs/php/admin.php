<?php defined( 'ABSPATH' ) or die( 'No direct script access!' );
###################################
## 
##	File: admin.php
##	Path: libs/php/admin.php
##	Author: Joshua Wieczorek (http://www.joshuawieczorek.com)
##      Date Created: October 7th, 2015 16:13 EDT
##      Date Modified: January 5th, 2016 06:11 EDT
##
##	-- File Description -- 
##	This file provides this plugin with the admin panel.
##
###################################

###################################
# Add admin menu pages
###################################
add_action( 'admin_menu' , function(){
    ## Add parent section page
    add_menu_page( __( 'Daily Proverb' , 'daily-proverb' ) , __( 'Daily Proverb' , 'daily-proverb' ) , 'administrator' , 'dpv-verses', 'jwdpv0001_admin_verses_page' , 'dashicons-book-alt' , 22 );
    ## Add options page
    add_submenu_page( 'dpv-verses' , __( 'Verses' , 'daily-proverb' ) , __( 'Verses' , 'daily-proverb' ) , 'administrator' , 'dpv-verses', 'jwdpv0001_admin_verses_page' );
    ## Add versions page
    add_submenu_page( 'dpv-verses' , __( 'Versions' , 'daily-proverb' ) , __( 'Versions' , 'daily-proverb' ) , 'administrator' , 'dpv-versions', 'jwdpv0001_admin_version_page' );
} );

###################################
# Load admin javascripts
###################################
add_action( 'admin_enqueue_scripts' , function(){
    ## Load plugin js file with jquery and jquery ui
    wp_enqueue_script( 'jwdpv0001_admin_script' , JWDPV0001_URL . 'libs/js/admin.js' , array( 'jquery' , 'jquery-ui-core' , 'jquery-ui-tabs' ) );
    ## Load plugin css file
    wp_enqueue_style( 'jwdpv0001_admin_style' , JWDPV0001_URL . 'libs/css/admin.css');
} );