<?php defined( 'ABSPATH' ) or die( 'No direct script access!' );
###################################
## 
##	File: init.php
##	Path: init.php
##	Author: Joshua Wieczorek (http://www.joshuawieczorek.com)
##      Date Created: January 3rd, 2016 11:47 EDT
##      Date Modified: January 3rd, 2016 13:46 EDT
##
##	-- File Description -- 
##	This file provides this plugin with the configuration and files
##	needed to function and run properly.
##
###################################

###################################
## Define constants
###################################

## Define Plugin Url
defined( 'JWDPV0001_URL' ) || define( 'JWDPV0001_URL' , plugins_url( '' , __FILE__ ) . '/' ) ;
## Define Base plugin directory path
defined( 'JWDPV0001_PATH' ) || define( 'JWDPV0001_PATH' , dirname( __FILE__ ) . '/' ) ;
## Define Libs PHP path
defined( 'JWDPV0001_PHP_PATH' ) || define( 'JWDPV0001_PHP_PATH' , JWDPV0001_PATH . 'libs/php/' ) ;
## Define Libs JSON path
defined( 'JWDPV0001_JSON_PATH' ) || define( 'JWDPV0001_JSON_PATH' , JWDPV0001_PATH . 'libs/JSON/' ) ;
## Define Libs HTML path
defined( 'JWDPV0001_HTML_PATH' ) || define( 'JWDPV0001_HTML_PATH' , JWDPV0001_PATH . 'libs/html/' ) ;
## Define Libs Biblepath
defined( 'JWDPV0001_BIBLE_PATH' ) || define( 'JWDPV0001_BIBLE_PATH' , JWDPV0001_PATH . 'libs/bibles/' ) ;

## Define Libs Biblepath
defined( 'JWDPV0001_DAY' ) || define( 'JWDPV0001_DAY' , (int) date( "d", current_time( 'timestamp' ) ) ) ;

###################################
## Load Dependencies 
###################################

##-------------------------------##
##--      libs/php files      -- ##
##-------------------------------##

## Load functions.php
include JWDPV0001_PHP_PATH . 'functions.php';
## Load shortcodes.php
include JWDPV0001_PHP_PATH . 'shortcodes.php';
## Load ajax.php
include JWDPV0001_PHP_PATH . 'ajax.php';