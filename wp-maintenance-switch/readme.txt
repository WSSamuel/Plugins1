=== WP Maintenance Switch ===
Contributors: lowest
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2VYPRGME8QELC
Tags: maintenance, maintenance mode, maintenance switch, switch, wp maintenance
Requires at least: 2.9
Tested up to: 4.7
Stable tag: 1.2

A light-weight tool to turn on maintenance mode with just one click.

== Description ==

WP Maintenance Switch makes it easy to turn on maintenance mode while you are modifying your website.

This light-weight plugin is designed for small operations, such as switching a theme.

If you would like to set up your own custom maintenance page, please [see the FAQ](faq/).

== Installation ==

1. Upload the 'wp-maintenance-switch' folder to the /wp-content/plugins/ directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Donzo! The switch has been added to your admin bar and you're ready to go.

== Frequently Asked Questions ==

= Is there a way to set up my own custom maintenance page? =

If you want to set up your own maintenance page, log in using FTP and make your way over to `wp-content/` directory. From there, create a new file called `maintenance.php`. In `maintenance.php`, you can add whatever you want and it'll display when you activate maintenance mode.

Please note you have to set up your own 503 headers in your custom maintenance file.

= Does this plugin have any configuration options? =

No, WP Maintenance Switch does not have options to configure.

= Which user roles have the ability to switch on maintenance mode? =

Only administrators have the ability to switch on maintenance mode. Administrators also have access to the website while its under maintenance.

== Screenshots ==

1. Switch button
2. Maintenance page

== Changelog ==

= 1.0.1 =
* Added security measures
* CSS fixes to maintenance page
* The front-end switch button is now small
* Lots of coding fixes

= 1.0 =
* Initial release