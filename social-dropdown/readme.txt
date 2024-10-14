=== Social Dropdown ===
Contributors: multippt
Tags: post, social bookmark, bookmark, accessibility
Requires at least: 1.5
Tested up to: 2.5.1
Stable tag: 2.0.1
Donate link: http://www.tevine.com/donate.php

This plugin displays several social bookmarks in a dropdown. Unlike other social bookmarking displays, this does not cause clutter.

== Description ==

This plugin displays several social bookmarking options in a dropdown. Unlike other social bookmarking displays, this does not cause clutter.

**Whats new in 2.0**

Version 2.0 features a new fresh look which is much easier to use and is extremely search engine friendly. Nonetheless, if you do not like the new layout, you can always use the old one via the administration panel. The new layout should go well with most layouts.

The new version also takes into consideration of non-JavaScript users and would downgrade gracefully to allow non-JavaScript users to utilize every other feature (exception of dropdown).

Integration with an external [Social Bookmarking API](http://www.tevine.com/social/ "Bookmark and Share API") allows your blog users to enjoy all bookmarks that are available even if you have not upgraded your plugin past version 2.0.

**Supported Social Bookmarks**

* BlinkBits
* BlinkList
* BlogLines
* BlogMarks
* Buddymarks
* BumpZee
* CiteULike
* Co.mments
* Del.icio.us
* Digg
* Diigo
* Facebook
* Fark
* Faves
* Feed Me Links
* Furl
* Gravee
* Google Bookmarks
* Hugg
* Jeqq
* Linkagogo
* Ma.gnolia
* Mister Wong
* NetVouz
* Newsvine
* OnlyWire
* Propeller
* RawSugar
* Reddit
* Rojo
* Simpy
* Slashdot
* Sphinn
* Spurl
* Squidoo
* StumbleUpon
* Taggly
* Tagtooga
* TailRank
* Technorati
* Windows Live
* Yahoo MyWebs

In addition, you can customize the order of the bookmarks or choose to remove some of them without editing a file.

If you do not like Dropdowns, this plugin has the ability to show the bookmarks without the dropdown - similar to what other plugins display.

Remember to **read the readme file** to ensure that you have done what is needed.

== Installation ==

By installing the plugin, you agree to [Tevine's policies](http://www.tevine.com/policies.php "Tevine's Policies").

1. Upload the **"social-dropdown"** (actually, any directory will do) folder into the "/wp-content/plugins/" directory. 

2. Login to your Wordpress Dashboard Panel and activate the "Social Dropdown" plug-in from the plugins tab. If there are no error messages (e.g. in the options panel or else-where), the plugin is properly installed.

3. Insert `<?php Show_Dropdown(); ?>` at where you want the social bookmarks to be displayed. This line of code should be placed within the Wordpress loop (i.e. the place where your posts appear).

4. You can rearrange, add and remove bookmarks that are displayed via the `Settings > Social Dropdown` panel in Wordpress 2.5 and above, or in the `Options > Social Dropdown` panel in earlier versions of Wordpress.

Feel free to poke around the internals of the plug-in.

== Updating ==

You can check what version the plug-in is at via visiting the `Options > Social Dropdown` panel.

1. Deactivate the `Social Dropdown` plug-in. You may want to back-up your existing plug-in files just in case if there are any errors while updating.

2. Replace the files in the `social-dropdown` directory located in the Wordpress plug-ins directory.

3. Re-activate the `Social Dropdown` plug-in from the administration dashboard.

If you have modified the `GenerateAll()` function, copy the modified area and set `$overrideoptions` to `true` to preserve your changes. `$overrideoptions` can be found in `generatebookmarks.php`.

== Requirements ==

1. A working Wordpress install

2. Your WordPress theme must contain a call to the `get_header()` function

3. Your WordPress theme must contain the Wordpress loop

Most Wordpress installs and templates have these, so you need not worry about these.

To be able to use the dropdown, one must have JavaScript enabled in the browser. 
Fortunately, users without JavaScript enabled will see a list of social bookmarks at where the dropdown is.

== Customizing ==

Within `socialdropdown.php`, these are some areas you can edit to influence how the dropdown appears.

In the `GenerateAll()` function, you can re-arrange how the items appear, add new items or remove them (after setting `$overrideoptions` to `true`). You can already do this using the `Options > Social Dropdown panel`.

**Creating bookmarks**
Each social bookmark is generated using the `GenerateLink()` function, and the URLs used are created using the `GenerateURL()` function. The parameters are as followed: GenerateLink($type), where $type is the name of the social bookmark (e.g. Digg is represented as 'digg').
In order to add a new bookmark, add the following lines of code after an item [i.e. after `break;`] in the **GenerateURL()** function. An example is shown:

	case '[name of social bookmarking site]':
	?>
	[URL to social bookmark page]
	<?php
	break;

In this example, when you call `GenerateURL('yahoo')`, the link for this item is generated. The link is the direct link to the submitting URL, usually available as an API on the social bookmarking site. Within the URL, there is some PHP code. `the_title()` represents the post title, while `echo get_the_permalink()` represents the URL of the post.

Within `generatebookmarks.php`, find a variable called `$all`. Add '|[your bookmark name here]' to the end of the string. For example, in the case of Yahoo, if $all contains "google", then the result will be "google|yahoo".

== Frequently Asked Questions ==

**How do you re-arrange bookmarks?**
Version 1.30 and above of this plug-in supports the customization of bookmarks via administration panel. In order to customize your bookmarks, use the drag and drop feature in `Options > Social Dropdown`.

**There's something wrong with your plugin**
If you found any problems, please reach me at ready725 at gmail. 

**What happens when a user with JavaScript disabled views the dropdown?**
A box containing a list of bookmarks will replace the Bookmark link at where the dropdown would be so that the user won't miss out of the bookmarking option entirely.

**What browsers do the plugin support?**
The plugin validates properly under the XHTML validator, hence it should looks fine on most browsers which follows standards. The plugin has been tested on Internet Explorer 7 and Firefox.

== Screenshots ==

1. Bookmarks displayed in a dropdown.

2. Bookmarks displayed in non-Javascript mode.

3. Drag and drop to arrange bookmarks

4. Legacy support for older dropdown.

== Credits ==

Several images are created or taken from the corresponding social bookmarking sites and edited to suit the plug-in. The dropdown javascript is taken from http://www.dynamicdrive.com/ and modified. The drag-drop library is provided by http://script.aculo.us/.

== Changelog ==

* 2.0.1 - Bug fix. Relocated now defunct ApiThis service to Tevine service.
* 2.0.0 - Changed dropdown style, now it is based on Wordpress guidelines. The dropdown link is now totally customizeable via CSS, and can even be made to resemble an ordinary link (hence will go well with most page layouts). Administration panel changed to fit Wordpress guidelines. A new hover system makes it easier to identify the bookmarks. New external API to ensure that non-JavaScript users will not get to miss out on the full capabilities of the plugin.
* 1.5.0 - Added support for BumpZee, Faves, Hugg, Jeqq, Windows Live. Some changes to the icons used.
* 1.4.9 - Added support for Mister Wong social bookmarking site. Several minor changes. Added uninstallation file.
* 1.4.8 - Bug fixes related to styles. Added Facebook. Thanks to Eric Fehrenbacher for his help.
* 1.4.7 - IMPORTANT FIX. This fix fixes a problem found in linux servers. [Most stable]
* 1.4.6 - Edited file check so that it works on all environments.
* 1.4.5 - Added ability for non-JavaScript users to customize the plugin via admin panel. Plugin now has another mode of customization where bookmarks can be simply enabled and disabled (this mode of customization does not allow rearranging of plugins). The dropdown can also be disabled in this version, making it look similar to other social bookmarking plugins. Fixed version number check. Fixed no link option.
* 1.4.0 - Added 5 bookmarks. The plugin can now be installed into any directory. Some minor changes to Dropdown to make it slightly more customizeable by style.css. Non-JavaScript users will see the same bookmarks normal users view. The link to plugin page now links to a help page to help users new to social bookmarking.
* 1.3.3 - Fixed RawSugar links. Thanks to phprocket for informing the problem.
* 1.3.2 - Fixed path problems.
* 1.3.1 - Added file checks.
* 1.3.0 - Allowed for configuration of bookmarks via `Options > Social Dropdown`. [Testing.]
* 1.2.2 - Link optimisation. Now allows for the disabling of the link back to the plugin's homepage.
* 1.2.1 - Link optimisation; now the plugin has little negative impact on the site's SEO and has reduced link leakage. Fixed the link to point to plugin's main page. Added customization of styles. Allowed for a customized dropdown "on" state. Added black colored theme.
* 1.2.0 - Link optimisation. Addition of 10 other social bookmarks. Addition of update notification
* 1.1.0 - Bug-fixes in layout which may cause problems to users viewing the plugin without JavaScript. Plugin now validates in W3 validator. 
* 1.0.0 - Initial
