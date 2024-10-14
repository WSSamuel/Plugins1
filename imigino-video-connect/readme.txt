=== Imigino Video Connect ===
Contributors: publisherstoolbox, johan101, kaylalampsa
Tags: publishers, websuite, imigino, video, video rendering
Requires at least: 5.6
Tested up to: 6.1.1
Requires PHP: 7.1
Stable tag: 1.1.8
Version: 1.1.8
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Imigino video player integration plugin. Embed your fully customisable Imigino video player into your WordPress content.

== Description ==

Do you need help rendering Imigino videos natively from within WordPress? With this plugin, developed by [Publishers Toolbox](https://www.publisherstoolbox.com/imigino "Publishers Toolbox"), you have the power to render your video short-codes on posts and pages as the powerful Imigino video player, with full adaptive bitstream and video monetisation support.

== Installation ==

To install, search for 'Imigino Video Connect' under plugins, download and activate.

On the plugin settings page, set the Customer ID (CID) and Imigino video service URL obtained from your Imigino support representative. That's it!

Any video short-codes added will render as your branded Imigino Video player. For support queries please get in touch via our product website at [publisherstoolbox](https://www.publisherstoolbox.com/imigino "Publishers Toolbox").

= Usage =

Use the shortcode in your content area: `[imigino_video url="https://yourvideourl.com/id/1234"]`

== Changelog ==

= 1.1.8 =
* Added lazy loading functionality.
* Added limit to carousel slides.

= 1.1.7 =
* Check for `get_the_title()` when adding the video title.

= 1.1.6 =
* Default to the WP Post title.

= 1.1.5 =
* URL encode the title.

= 1.1.4 =
* Fix envelope checker.
* Add optional title field to the imigino_video shortcode.

= 1.1.3 =
* Added video sharing for carousels.
* Fixed minor bugs.
* WordPress latest version tests.

= 1.1.2 =
* Fixed cache busting option.
* Fixed horizontal cropping feature.

= 1.1.1 =
* Fixed carousel options.
* Added better cropping.
* Cleaned up GUI.

= 1.1.0 =
* Fixed carousel cid options.

= 1.0.9 =
* WordPress Version 5.6 test.
* Added option to crop images.
* Added cache busting options for sites with caching plugins.

= 1.0.8 =
* Add video playlist carousel.
* Updated scripts to PHP 7.4 compatibility.
* Fixed minor script issues.
* Cleaned up legacy code.

= 1.0.7 =
* Updated shortcode parameters.

= 1.0.6 =
* Update authenticated streams.
* Tested with Wordpress 5.5.3

= 1.0.5 =
* Added optional CID option.
* Added live streaming shortcode for player.

= 1.0.4 =
* Tested with Wordpress 5.5.1

= 1.0.3 =
* Updated core loading.
* Tested with Wordpress 5.4.2

= 1.0.2 =
* Tested WP Update.

= 1.0.1 =
* Updated URL string for testing.

= 1.0.0 =
* Initial plugin code.
* Adds Imigino shortcode to WordPress.

== Upgrade Notice ==

= 1.1.2 =
* Fixed cache busting option.
