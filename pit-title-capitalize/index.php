<?php
/*
Plugin Name: PiT Title Capitalize
URI: http://www.webingnet.com
Description: This Plugin can Modify Your Website/Blog's Title Automatically Capitalize if you forgot to do that.
Version: 1.2
Author: Pantho Bihosh
Author URI: http://www.bihosh.com
*/


add_filter('the_title','pit_modify_title');
function pit_modify_title($content)
{
return ucwords($content);
}
?>
