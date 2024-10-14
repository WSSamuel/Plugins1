=== Plugin Name ===
Contributors: dawid88
Donate link: 
Tags: teamSpeak
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Widget for entering team speek from your website

== Description ==

Add "enter team speak" button to your website with ease.
Plugin contains widget for entering team speak straight from your website.
Just click on image and your browser will opens team speak for you!

**features**
* title
* image (default or your own)
* nickname (if user is logged in then teamspeak3 nickname = wordpress username)
* bookmarks
* chanel


version 1.0 please report any problems.

== Installation ==

1. Upload plugin to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. DONE! now you can add widget from apperance > Widgets

== Frequently Asked Questions ==

= no action after click =

reason unknown, probably antivirus, (nead to investigate this problem)

for team speak3 to start from website windows registry must contain data below: (this data is added automatically while instalig team speak3)

[HKEY_CLASSES_ROOT\ts3server]
@="URL:TeamSpeak 3 file"
"URL Protocol"=""

[HKEY_CLASSES_ROOT\ts3server\shell\open\command]
@="\"C:\\Program Files (x86)\\TeamSpeak 3 Client\\ts3client_win32.exe\" \"%1\""

more info: http://msdn.microsoft.com/en-us/library/ie/aa767914(v=vs.85).aspx

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.png

== Changelog ==

= 1.0 =
* first version
