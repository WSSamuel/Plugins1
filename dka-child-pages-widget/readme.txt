=== DKA Child pages widget ===
Contributors: dainius.kaupaitis
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=rositos%40gmail%2ecom&lc=LT&item_name=Dainius%20Kaupaitis&no_note=0&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest
Tags: widget, page, navigation
Requires at least: 2.0.2
Tested up to: 4.6
Stable tag: 0.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Widget which shows child pages.

== Description ==

When navigating on pages widget shows links to child pages. If there are no child pages – widget shows „brother“ pages.
Link of currently viewed page can be styled through CSS. Widget shows nothing if user is browsing Posts (not Pages).
Admin can configure:

* widget title
* which pages must be excluded

Widget can be localized.

== Installation ==

1. Extract plugin to `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Apearence → Widgets. You'll se this widget at „Available widgets“. Drag-n-drop it to desired place (e.g. Sidebar). Note: your theme template must be widgetized.

== Frequently Asked Questions ==

= i18n =

For translation file see „languages“ folder

= How to „catch“ current page =

A list item has `current_page_item` class – just style it through CSS e.g. : `.current_page_item { background-color:silver }`

== Changelog ==

= 0.7 =
Fixed missing UL tag
Confirmed WP 4.0 compatibility

= 0.6 =
Confirmed WP 3.9 compatibility

= 0.5 =
Shows „brother“ pages when page has no childs.

= 0.4 =
Added drop-down to select excluded page(s) by title.

= 0.3 =
Tested with WP v.3.4.1

= 0.2 =
Lithuanian translation added

= 0.1 =
* Initial version released

== Screenshots ==

1. Backend
2. Frontend

== Upgrade Notice ==

= 0.1 =
Initial version

