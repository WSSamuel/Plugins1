=== WordPress Alert Bar ===
Contributors: braceomatic88
Donate Link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=ryanplugindonations@gmail.com&lc=US&no_note=0&item_name=Support+this+developer&cn=&curency_code=USD
Tags: notification, alert, notification bar, alert bar, attention bar, floating bar, message, notice, sticky header, offer bar, hello bar
Requires at least: 4.7.0
Tested up to: 6.0.3
Requires PHP: 5.4
Stable tag: trunk
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Fully customizable alert bar for your WordPress website.

== Description ==

WordPress Alert Bar allows you to quickly and easily add an alert bar to your WordPress website. 

All content and styles are fully customizable through the WordPress Customizer, allowing you to easily match the alert bar to your sites branding with no coding necessary, and with real time preview you can see what you're doing before publishing. WordPress Alert Bar also gives you the ability modify the way the alert bar displays with options to have the alert bar appear across your entire site or just the homepage, or include a close button. This gives you the power to use WordPress Alert Bar in a way that best fits your message.

WordPress Alert Bar also applies unique classes to the body tag and all elements of the alert bar making it easy for developers to further modify the styles to fit the needs of your WordPress website. 

== Features ==
* Custom Colors to match your site branding
* Custom title, message and call to action ( all items are optional and fully conditional )
* Ability to display banner across your entire site or just the homepage
* Body class added to pages where WordPress Alert Bar is visible

== Screenshots ==

1. WordPress Alert Bar section in customizer

2. Sub sections in customizer for Styles, Content, and Display

3. Styles section to customize colors and font size. Options are editable from the customizer with real time preview

4. Content section to add custom messaging and call to action. Options are editable from the customizer with real time preview

2. Display section to customize where the alert displays on your site. Options are editable from the customizer with real time preview

== FAQ ==

= My WordPress site has a sticky header that uses position fixed causing it to cover the WordPress Alert Bar, how can I fix this? =

**WordPress Alert Bar** comes with a filter that allows you to define your sites fixed header so that it can account for the alert bar. Simply navigate to the functions.php file in your child theme and paste in the following code snippet, making sure to replace .site-header with the class or ID of your sites fixed position header.

`
// Define fixed header for Wordpress Alert Bar
add_filter( 'mbwpab_fixed_header_selector', 'mbwpab_define_fixed_header' );
function mbwpab_define_fixed_header( $header ) {
	$header 	=	'.site-header';
	return $header;
}
`

== Changelog ==

= 1.0.2 =
*Release Date - April 4 2023*

* Fix - Tested plugin against the most recent version of WordPress.

= 1.0.2 =
*Release Date - May 10 2021*

* Fix - Adjusted hook priority for WordPress Alert Bar to prevent conflict with favicons set through the WordPress Customizer.

= 1.0.1 =
*Release Date - Jun 12 2020*

* New - Added class to WordPress Alert Bar when close button is active.
* Fix - Gave unique class selector to WordPress Alert Bar call to action.
* Fix - Removed extra right padding on mobile when close button is not active.
* Fix - Cleaned up erroneous styles from style.css.
* Fix - Enqued WordPress Alert Bar style.css eairler to allow plugin stlyes to be overridden using theme stylesheet, without the need for important tags.

= 1.0.0 =
*Release Date - May 31 2020*

* New - Added WordPress Alert Bar to repository.