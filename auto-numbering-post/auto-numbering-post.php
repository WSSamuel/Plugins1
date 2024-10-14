<?php
/*
Plugin Name: Auto Numbering Post
Plugin URI: http://dev.coziplace.com/free-wordpress-plugins/auto-numbering-post 
Description:  Automatically numbering all published posts based on the publish date and display the number in front of all published post titles.  
Version: 1.3
Author: Narin Olankijanan
Author URI: http://dev.coziplace.com 
License: GPLv2
*/

/* Copyright 2012 Narin Olankijanan (email: narin@dekisugi.net)

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc. 51 Franklin St, Fifth floor, Boston MA 02110-1301 USA
*/

add_action( 'the_title', 'dk_auto_numbering' );

function dk_auto_numbering($title) {
 $post_ID = get_the_ID();
 $the_post = get_post($post_ID);
 $date = $the_post->post_date;
 $maintitle = $the_post->post_title;
 $count='';
 
 if ($the_post->post_status == 'publish' AND $the_post->post_type == 'post' AND in_the_loop()) {
     global $wpdb;
     
     $count = $wpdb->get_var("SELECT count(*) FROM $wpdb->posts  WHERE post_status='publish' AND post_type='post' AND post_date<'{$date}'");
    if ($maintitle==$title) {
     $count = $count.': ';  
    } else {
     $count ='';
    }
 } 
 
 return $count.$title;
 
}
/* EOF */