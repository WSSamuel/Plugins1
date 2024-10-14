=== sidebarAutomizer ===
Contributors: damiroquai
Donate link: http://wordpress.transformnews.com/contact
Tags: twentythirteen, twenty-thirteen, plugin, sidebar, jquery
Requires at least: 3.5.1
Tested up to: 4.7
Stable tag: 1.0
License: GPLv2 or later

This little plugin will remove last widget or widgets from sidebar if content area height is smaller than sidebar area height. 

== Description ==
Plugin will prevent sidebar height to overgrown content height and as a result we got a equalized content and sidebar heights. It is based on javascript that will remove last widget from sidebar while sidebar height is higher than content height. Settings are localized and by default work with Twenty Thirteen theme. Plugin unique settings approach to choose css class for content and sidebar allow us to set it up and use on any theme, and possibly in different ways that was originally meant to be used.

Settings are located in Dashboard / Settings / sidebarAutomizer:

Content Class or ID - This must be content CSS class or ID which will define max height for your sidebar area.

Sidebar Class or ID - CSS class or ID of the sidebar element that contains widgets.

Add extra height to Sidebar - In some cases you want your sidebar a bit higher than content. If that is the case add number of pixels here.

Define Element to remove -  It can be aside, div, or whatever HTML element that your theme uses to display single widget. Wrong setting can cause unresponsive script behavior in front end.

Plugin Home: http://wordpress.transformnews.com/plugins/sidebarautomizer-equalize-content-and-sidebar-heights-664 

== Installation ==
Install like any other plugin. After install activate. If using template other than Twenty Thirteen go to Settings / sidebarAutomizer and add your custom classes/ ID's and element..


== Screenshots ==

1.  screenshot-1.png shows administration settings.
2.  screenshot-2.png shows plugin in action, left is before and right is after activation.


== Changelog ==

= 1.0 =
* First release of plugin