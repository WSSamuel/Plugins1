=== Side by Side ===
Contributors: damiarita
Tags: css, javascript, jQuery, shortcode, style, comparing, before, now, before-now, responsive
Stable tag: trunk
Requires at least: 1.0.2
Tested up to: 4.8.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allows you to put two images next to each other. When you move your mouse over them, the line that separates them will move with it!

== Description ==

This plugin allows you to put two images next to each other. When you move your mouse over them, the line that separates them will move with it! It's perfect to compare "before" and "now" images.

This plugin will use jQuery to detect when your mouse gets into the box and move the white bar with it.

Simply use the shortcodes like this:
`[sidebyside]
  [sidebyside-left]
    Put here whatever content you want to be on the left side
  [/sidebyside-left]

  [sidebyside-right]
    This is the place for the content that goes to the right
  [/sidebyside-right]
[/sidebyside]`

= What should I put in the shortcodes? =
You can put whatever you want.

My suggestion is that you put two images with the same height

= Is it responsive? =
Yes!

All CSS properties are written with responsive design in mind. So it will look good in all kind of screen sizes.

== Installation ==

1. On the left side menu select Plugins > Add New
2. In "Search Plugins" field enter "side by side" and search
3. Press "Install Now" button of the "side by side"

== Frequently Asked Questions ==

= Do I need to be a programmer? =

No! All you need to do is using these shortcodes:

`[sidebyside]
  [sidebyside-left]
    Put here whatever content you want to be on the left side
  [/sidebyside-left]

  [sidebyside-right]
    This is the place for the content that goes to the right
  [/sidebyside-right]
[/sidebyside]`

= What should I put in the shortcodes? =
You can put whatever you want.

My suggestion is that you put two images with the same height

= Is it responsive? =
Yes!

All CSS properties are written with responsive design in mind. So it will look good in all kind of screen sizes.

== Screenshots ==


1. Default view of two pictures.

2. Once I move the mouse over the images, the separating bar moves with it.


== Changelog ==

=1.0.2=
*Minified script is loaded by default. Non minified if SCRIPT_DEBUG is set to true

=1.0.1=
*Script is loaded in the footer

= 1.0.0 =
* First release

== Upgrade Notice ==

= 1.0.1 =
* The JS file is loaded from the footer of the html to improve rendering speed