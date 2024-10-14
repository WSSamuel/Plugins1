=== en_GB (British English) Translation ===
Contributors: kawauso
Donate link: http://adamharley.co.uk/buy-me-a-coffee/
Tags: en_GB, translation, localisation, british english
Requires at least: 3.0
Tested up to: 3.3
Stable tag: 1.0.2.1

Fixes those little things in WordPress like misplaced vowels and over-use of the letter Z.

== Description ==

<strong>Changes:</strong>

* Trash -> Bin
* Color -> Colour (and similar)
* Categorize -> Categorise (and similar)
* Howdy -> greeting based on the time of day (in 3.2 and higher)

== Installation ==

1. Upload `en-gb-localisation.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Optionally set your locale (`WPLANG`) to en_GB in `wp-config.php`

== Frequently Asked Questions ==

= Are you serious? =
Reasonably so. Seeing 'Trash' too often sent me over the edge.

= Why isn't this a mo/po file? =
Since en_GB is quite similar to en_US, it would be rather unnecessary to use full string translations that may require updating for each version.

= Using -ize isn't an Americanism =
While I'm aware of this, I loathe [Oxford spelling](http://en.wikipedia.org/wiki/American_and_British_English_spelling_differences#-ise.2C_-ize_.28-isation.2C_-ization.29) with a passion.

== Changelog ==

= 1.0.2.1 =
* Added lowercase 'trash'

= 1.0.2 =
* Added missing 'gettext_with_context' filter

= 1.0.1 =
* First public release
* Made strings static (thanks dd32)

= 1.0 =
* First version

== Upgrade Notice ==

= 1.0.2.1 =
Adds lowercase 'trash'

= 1.0.2 =
Adds missing filter