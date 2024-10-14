=== Category Page Extender ===
Contributors: grpsmglr00
Tags: admin, pages, category, formatting, plugin, categories, integration, page, theme
Requires at least: 2.2
Tested up to: 2.8.4
Stable tag: 1.0.3

Inserts posts into pages corresponding to category.  Add on plugin for Category Page by pixline.net. Requieres an active installation of Category Page 2.5 or greater by pixline.net.

== Description ==

This plugin builds on the Category Page plugin making it possible to automatically insert posts into pages and subpages based on categories.  You must have a current version of <a href="http://wordpress.org/extend/plugins/page2cat/">Category Page</a> installed in order to function.
. 
Visit plugin page [here](http://categorypageextender.wordpress.com/)


== Installation ==

***Requires a current installation of Category Page: http://wordpress.org/extend/plugins/page2cat/

1. Download the plugin Zip archive.
2. Upload `Category Page Extender` folder to your `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Setup some relationship between Categories and Pages using the Category Page plugin
5. Tweak `page.php` in your theme folder (please [read here](http://categorypageextender.wordpress.com) to learn how).
1. Enjoy!

== Changelog ==

1.0.3 - Fixed Firefox display error due to html comments in category-page-extender.php file
<br />
1.0.2 - Fixed page navigation
<br />
1.0.1 - Fixed header output error
<br />
1.0 - Original Release

== Usage ==

To view complete instructions [read here](http://categorypageextender.wordpress.com)

Open up page.php in your template folder (you may also set up a seperate a Page Template)

For the most basic setup, insert the following below the loop statement in the page.php file:

<pre>&lt;?php if( function_exists(page2cat_pages)){ page2cat_pages($post->ID);} ?&gt;</pre><br /><br />


I recommend you wrap the function in your standard post class.  For example:
<pre>&lt;div class="post"&gt;
&lt;?php if( function_exists(page2cat_pages)){ page2cat_pages($post->ID);} ?&gt;
&lt;/div&gt;</pre><br /><br />

Plugin Options

<code><?php if( function_exists(page2cat_pages)){ page2cat_pages($post->ID, posts per page, number of pages);} ?></code><br /><br />

Posts per page: (default = 10) set to 0 to show all
This sets the number of posts to show at one time on the page.

Number of pages: (default = 15) set to 0 to show all
This tells how many page numbers to show at a time on the page navigation bar.

Example of Category Page Extender with variables:
<pre>&lt;?php if( function_exists(page2cat_pages)){ page2cat_pages($post->ID, 5, 10);} ?&gt;</pre><br /><br />
This will list 5 posts and up to 10 page numbers at a time on the page navigation bar.

[Plugin Homepage](http://categorypageextender.wordpress.com/)