=== Simple Login SC ===
Contributors: Ghyslain Drolet
Tags: login, shortcode, widget, WPML
Requires at least: 3.0 
Tested up to: 4.3
Stable tag: 0.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds a simple login form via a shortcode and does not add any extraneous code to slow your website. It just uses the core functions of WordPress.

== Description ==

Simple Login SC does just what it means

Simple Login SC does not mess with other plugins because it does just login or logout a user. Nothing more. Nothing less.
It uses the core functions of WordPress thus not slowing down your site. No fancy stuff or hard settings. This is just a login plugin!
	
Using Simple Login SC is absolutely easy

Just type the shortcode where you want a login form to show.
Use [sl_shortcode] shortcode to add a login form to a page, post or in a text/html widget.
You can optionally set the labels for "username", "password", the submit button and/or the welcome message, the logout text. Just by adding text to the shortcode.

Usage

Example: [sl_shortcode username_label="What is your name?" password_label="Password Please!" button_text="Let me in!" welcome_text="Hello" logouttext="Let's go outside!"]

This is very useful if the language pack is not available in your language or if you have a multilangual site running WPML.
If you do not set one or all of the optional text, the default text of WordPress and the plugin will be used.


== Installation ==

This section describes how to install the plugin and get it working.

1. Upload and decompress `simple-login-sc.zip` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the menu Tools -> Simple Login SC for the usage instructions

== Frequently Asked Questions ==

= Do I have to use all the shortcodes attributes? =

Nope! Any number you need and it starts at zero.

= Is the plugin have redirect functionality? = 

Nope! It only logs in or logs out a user. If you need a redirect on log in and/or log out, we suggest you to install 'Peter's Login Redirect' plugin too. They work great together.
Two plugins that each focus on one thing and doing it right!

== Screenshots ==

1. These screenshots show which label can be set with the shortcode attributes. eg username_label, password_label, button_text,
2. welcome_text, logouttext.

== Changelog ==

= 0.8 =
* First public release

== Upgrade notice ==

* None
