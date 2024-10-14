=== Comment License ===
Tags: comment, comments, license, release, disclaimer
Contributors: alexkingorg, crowdfavorite
Requires at least: 1.5
Tested up to: 6.0
Stable tag: 1.4.1

Add license terms to your comment form.

== Description ==

Comment License shows a license with terms of your choosing in your comments form. You can edit the terms of your license in the options page.

== Installation ==

1. Download the plugin archive and expand it (you've likely already done this).
2. Upload the comment-license.php file to your wp-content/plugins directory (not in a sub-folder).
3. Go to the Plugins page in your WordPress Administration area and click 'Activate' for Comment License.
4. Congratulations, you've just installed Comment License.
5. Optional: go to Options > Comment License to change the terms of your license.
6. Optional: set a CSS class for `comment_license` to style the banner.

== Frequently Asked Questions ==

= Why doesn't the license show in my theme? =

This plugin relies on the `comment_form` to be present in your comments.php template. If this does not exist, you will want to add it:

`<?php do_action('comment_form', $post->ID); ?>`

= Anything else? =

That about does it - enjoy!

--Alex King

http://alexking.org/projects/wordpress
