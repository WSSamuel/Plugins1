=== WP Count Down Timer ===
Contributors: sitedin
Tags: countdown, timer, count down, time
Donate link: https://www.paypal.com/paypalme2/Sitedin/10usd
Requires at least: 3.5
Tested up to: 5.3
Requires PHP: 5.3
Stable tag: 1.0.1
License: GNU 2
License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html

Countdown timer to a specified date. A simple plugin with a shortcode that makes it super simple to use.

== Description ==
This plugin allows the user to set a countdown timer to a specified date. The user can add a target date in the future (i.e: Dec 30, 2099) in the shortcode provided with the plugin. Pasting the shortcode on any page, post or widget area will show a countdown timer counting from the current time towards the target date specified earlier. The user can set the target date in the parameter date="" (i.e: date="Dec 30 2099 13:00:00 UTC+1"). The following date formats are accepted: 
 - Dec 12 2099
 - Dec,12,2099
 - Dec 12,2099
 - Dec/12/2099
And the month name Dec can be replaced with the month number (12) in all of the above.
The user has some more feature to customize the appearance of the timer. The user can set the text that should show after the counting is over. By default it is Time Out. The user can set the color of the counter. By default it is blue. The color parameter works exact same is color attribute in CSS, so it could be color:black, or color:#000. The user can set the alignment of the timer text left, center or right. By default it is center.  

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress

== Frequently Asked Questions ==
= How do i set a countdown timer? =

Use the shortcode [wp_countdown_timer date="Dec,12,2020 23:55:00 UTC+1" text="This offer has expired" color="red"] where date is the target date we count down to, text is the text to show after the counting is over and color is the text color.

= I copied the shortcode, but it is not working! =
Try typing the double quotation ("") marks in the shortcode yourself.

= I need custom work done on this plugin to extend its functionality =
Feel free to contact us through our website [sitedin.com](https://sitedin.com/).

== Screenshots ==
1. Adding the shortcode

== Changelog ==

= 1.0.1 =
* Bug fix - Timer content always shows on top.

= 1.0.0 =
* First release.