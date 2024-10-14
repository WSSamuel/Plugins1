=== Remove Wordpress to WordPress filter ===
Contributors: tomthewebmaster
Tags: filter, filters, WordPress, Wordpress
Requires at least: 3.0
Tested up to: 5.7
Stable tag: trunk

This turns off the default filter that changes all instances of "Wordpress" to "WordPress".

== Description ==

In WordPress 3.0 and later, <a href="https://core.trac.wordpress.org/changeset/14996">a default filter</a> changes all instances of "Wordpress" (note the small "p") in posts, titles, and comments to "WordPress". <a href="https://core.trac.wordpress.org/ticket/13583">For various reasons</a>, such as preserving spelling in existing posts and comments, a blog owner may want to turn this filter off. That is what this plugin does.

Simply upload the plugin files to your WordPress plugins folder, activate it on your blog's Plugin administration page, and you are set!

== Changelog ==

= Version 1.3 =
* Turn filter off for wp_title.
* Minor code cleanup.

= Version 1.2 =
* Some priority levels for this function have changed yet again in WordPress 3.1, making it again necessary to change the filters. This plugin now removes the filter for all possible priority levels. Thanks to <a href="http://subscribe2.wordpress.com/">Matt Robinson</a> for suggesting this method and providing code that is used in the plugin. This change makes the plugin compatible with WordPress 3.1, and it is still compatible with the WordPress 3.0 branch.
* Additional technical documentation has been added.

= Version 1.1 =
* The filters were changed slightly in WordPress 3.0.1. This update is compatible with these new filters.

= Version 1.0 =
* Initial release

== Technical Details ==

This plugin seeks to disable the capital_P_dangit function, which is the WordPress function that disallows "Wordpress" to be used on blogs.

The filter is defined in <a href="https://core.trac.wordpress.org/browser/trunk/src/wp-includes/default-filters.php">wp-includes/default-filters.php</a> and is applied in <a href="https://core.trac.wordpress.org/browser/trunk/src/wp-includes/formatting.php">wp-includes/formatting.php</a> of the core WordPress code.

The remove_filter function is used in this plugin to undo the add_filter function applied in wp-includes/formatting.php. In versions 1.0 and 1.1 of this plugin, the function was removed for certain priority levels. As of version 1.2, this plugin removes the filter for all possible priority levels. Thanks to <a href="http://subscribe2.wordpress.com/">Matt Robinson</a> for suggesting this method and providing code that is used in the plugin. 

For more information regarding how this function is applied in WordPress, the following are the relevant changesets to the core WordPress code regarding this function:

* <a href="https://core.trac.wordpress.org/changeset/14996/">Changes made for WordPress 3.0</a>
* <a href="https://core.trac.wordpress.org/changeset/15377/">Changes made for WordPress 3.0.1</a>
* <a href="https://core.trac.wordpress.org/changeset/15877/">Changes made for WordPress 3.1</a>
* <a href="https://core.trac.wordpress.org/changeset/21242/">Changes made for WordPress 3.5</a>
* <a href="https://core.trac.wordpress.org/changeset/25093/">Changes made for WordPress 3.7</a>
* <a href="https://core.trac.wordpress.org/changeset/26122/">Changes made for WordPress 3.8</a>