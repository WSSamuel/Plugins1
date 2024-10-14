=== Zen Dash ===
Contributors: versluis
Donate link: https://ko-fi.com/wpguru
Tags: dashboard widgets, zen, remove, disable, clutter, update notifications, menu item, admin footer, jetpack
Requires at least: 3.3
Tested up to: 6.1
Stable tag: 1.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Disable dashboard widgets, menu items and update notifications. Declutter your dashboard with Feng Shui magic. Less is more. 

== Description ==

Remove individual widgets from the WordPress Dashboard, hide Menu Items and disable Update Notifications. Many of my clients find the sheer volume of information in the WordPress Admin Area a bit intimidating. I wanted to create an easy to use, codeless, great looking solution to toggle such items on and off, to make it easier for casual users and newcomers alike.

This Plugin was inspired by Joseph Lowery when he kindly explained how to remove dashboard widgets. After getting into coding, I added several other options.

Special thanks to Kushagara Agarwal for the wonderful CSS.

== Installation ==

1. The easiest way: from Plugins - Add New, search for "Zen Dash", find this plugin and hit "install"
1. Or: Upload the entire folder to the `/wp-content/plugins/` directory. Please do not rename this folder
1. Or: Download the ZIP file, then head over to Plugins - Add New - Install, then browse to your file
1. Then: Activate the plugin through the 'Plugins' menu in WordPress
1. Under Dashboard - Zen Dash you find an admin interface with tabs. Toggle at leisure.


== Frequently Asked Questions ==

= How to I use this plugin? =
Simply activate it, then head over to Dashboard - Zen Dash where an admin interface is waiting for you. Use the sliders to activate or deactivate an, then hit "Save Changes".
You can also choose to enable or disable all widgets at once.

= Can I still access removed Menu Items? =
Yes. Zen Dash only hides them, but if you know the direct URL you can still call it. 
For example, to access the Dashboard, you can still navigate to yourdomain.com/wp-admin/index.php

= Can I still update WordPress Core / Themes / Plugins with disabled notifications? =
Yes indeed. Zen Dash only hides the notifications at the top, not the fact that an update is available.
When you're ready to update, activate notifications again, then head over to Dashboard - Updates. 

= HELP! I've disabled the Dashboard Menu Item, and now I can't access Zen Dash options to bring it back! =
You can access the Zen Dash options by hovering over the Admin Footer. Please do not disable both.

= HELP! I've disabled BOTH the Dashboard menu AND the Zen Dash footer link... =
You can still call the Zen Dash menu directly by appending "index.php?page=zendash" to your admin area.
For example, if your URL in the admin area is "mydomain.com/wp-admin", head over to "mydomain.com/wp-admin/index.php?page=zendash".
If that doesn't work for you, please disable and uninstall the plugin, then re-install it. This will reset all your options.

= How to I remove the Jetpack Feedback option? =
It's a tad tricky, but can be done under Jetpack - Settings. Towards the bottom you'll find a Debug option. Select it and look for a link that reads "Access the full list of Jetpack Modules on this site". After clicking it, find an option to disable the Contact Form. This will remove the Feeback Tab as well as the Jetpack Contact Form. I only recommend this if you have another Contact Form solution in place (such as Gravity Forms).


== Screenshots ==

1. disable the default WordPress widgets selectively (under Dashboard - Zen Dash)
2. disable Menu Items you don't want to see
3. disable Update Notifications
4. disable Footer Links

== Changelog ==

= 1.6 =
* updated social links
* verified compatibilty with WordPress 5.0
* added documentation about hiding the Feedback Tab

= 1.5 =
* the option to hide the Jetpack menu now only shows when the plugin is activated
* verified compatibility with WordPress 4.4 

= 1.4 =
* added option to hide Jetpack menu item

= 1.3 =
* hiding update notifications now works under WordPress 3.8 and 3.9

= 1.2 =
* renamed options under Dashboard Widgets to reflect changes made in WordPress 3.8
* fixed a small bug to reflect the state of the Appearance slider
* tested up to WordPress 3.9

= 1.1 =
* added options to remove Menu Items
* added options to remove Update Notifications
* added options to remove Admin Footer Items
* added shortcut to Zen Dash options in Admin Footer
* modified presentation and option tabs

= 1.0 =
* Initial Release
