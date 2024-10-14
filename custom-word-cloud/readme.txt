=== Plugin Name ===
Contributors: bnielsen
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=EC26C3EBFD8A8
Tags: cloud, image
Requires at least: 3.0
Tested up to: 3.0
Stable tag: 0.4

Creates custom word cloud images based on page content or POST variable named content.

== Description ==

The custom word cloud plugin will generate word cloud images based on page
content or the contents of a form POST input named "content". The cloud is
specified using shortcode tags on the page where the content or form exist.

#### Example 1
As an example the following entered into a WordPress page will result in a
page with a word cloud image displayed above the paragraph that is a link
map with google searches for each word in the cloud:
<code>
[cwcloud]  
[cwcimage]  
[cwcmap]

We the People  of the United States, in Order to form a more perfect Union,
establish Justice, insure domestic Tranquility, provide for the common
defence, promote the general Welfare, and secure the Blessings of Liberty to
ourselves and our Posterity, do ordain and establish this Constitution for the
United States of America.

[/cwcloud]
</code>

#### Example 2
Another example where a user may enter their own paragraph of text and
generate a custom word cloud:
<code>
[cwcloud post="true" id="mycloud"]  
[cwcmap]  
[cwcimage]  
<form method="post">  
<textarea cols="40" rows="10" name="content">[cwcpostcontent]</textarea>  
[cwcform]  
<input type="submit" value="Build Cloud" />
</form>
[/cwcloud]  
</code>

#### Example 3
An example of a form with attributes set to some custom default settings and
the id attribute is not set so a fresh id will be generated for each user
created word cloud:
<code>
[cwcloud post="true" palette="#046, #fe0, #2f2, #82f" width="500" height="250"
word_limit="30"]
[cwcimage]
[cwcdownloadlink]
<form method="post"><textarea cols="40" rows="10"
name="content">[cwcpostcontent]</textarea>
<input type="submit" value="Build Cloud" /> [cwcform]
</form>
[/cwcloud]
</code>


#### Attributes
The [cwcloud] tag accepts multiple attributes and there are some custom
shortcode tags that can be used inside the enclosed [cwcloud][/cwcloud] tags:

attributes:  
id - specify an id to use for this word cloud image  
i.e. "mycloud"  

old_age - number of seconds before old images are removed from the cache (default old age is one week)  
i.e. "86400"  

seconds_to_live - seconds before the cached image will be redrawn (default seconds to live is 5 seconds)  
i.e. "60"  

width - width of the cloud image  
i.e. "300"

height - height of the cloud image  
i.e. "200"

post - set to "true" if data will be posted from a form  
i.e. "true"

palette - color palette in web hex codes, minimum of two colors, they can be 3 digit or 6 digit web type hex codes  
i.e. #fff, #0ef582, #00f

angle - the angle to tilt each word, "random" or 0 to 360  
i.e. "45"

double_angle - randomly flip words to the opposite angle  
i.e. "true"

word_limit - maximum number of words in cloud  
i.e. "40"

font_file - the ttf font file in the fonts directory to use  
i.e. "Dustismo_Roman.ttf"

word_margin - margin around each word in cloud  
i.e. "5"

exclude_words - words to exclude from counting  
i.e. "this,that,them,you"

charlist - additional characters to accept within words, i.e. accent
characters  
i.e. "üöäß"



#### Shortcodes
shortcodes:  
[cwcloud] [/cwcloud] - must always be used as an enclosed short code  

[cwcid] - the id of the cloud image, useful in forms  

[cwcform] - provides cloud parameter form elements ready to use in a form  

[cwcform_angle] - provides the angle form input element  

[cwcform_double_angle] - provides the double_angle form checkbox  

[cwcform_font_file] - provides the form font file select  

[cwcform_width] - provides the form width input  

[cwcform_height] - provides the form height input  

[cwcform_word_margin] - provides the word margin input  

[cwcform_palette] - provides the form input for the color palette  

[cwcform_word_limit] - provides the form input for the word limit  

[cwcform_exclude_words] - provides the form input for excluded words  

[cwcpostcontent] - provides the posted content, useful for a form textarea  

[cwcimage] - provides an <img> tag pointing to the cloud image  

[cwcmap] - provides a <map> that maps the image to a google search  


#### Notes
The cached images are stored in a subdirectory of the plugin's directory named
cache.

Font files for the cloud are stored in a subdirectory of the plugin's
directory named fonts.


== Installation ==

Unzip the custom-word-plugin.zip file and copy the resulting custom-word-cloud directory to your
WordPress plugins directory.

Make sure the web server can write to the custom-word-cloud/cache/ directory.

And upload any TTF font files you want to use into the custom-word-cloud/fonts/ directory.

Activate the plugin and create a page with the appropriate shortcode tags.

Enjoy. ;)


== Frequently Asked Questions ==

= Why are some of the letters in some words are covering up other words and letters? =

There is a long running bug in the PHP imagettfbbox() function that calculates
the coordinates of the box around a string drawn with a TTF font where the
letters that drop below the baseline, like the lower case letter p, fall
outside the bounding box. This has been fixed in recent versions of PHP but
for older versions you can create a larger word margin in the attributes to as
a temporary fix.


== Screenshots ==

1. Word cloud from page content.
2. Word cloud from a form.

== Changelog ==

= 0.2 =  
* Added stripping of slashes from $_POST['content'] if magic quotes is on.  
* Fixed a bug where colors used exceeded the number in the palette and resulted in black words even though the color was not specified in the palette.  
* Added the siteurl to image and link URLs so the plugin will work with mod_rewrite.  

= 0.3 =
* Added an image map function that links words in the image to a google search  

= 0.4 =  
* Added the charlist attribute that will enable UTF8 accent characters  


== Upgrade Notice ==

= 0.2 =  
Fixed major bug where use of mod_rewrite rules for pretty URLs caused the relative links for images and download to fail.  

