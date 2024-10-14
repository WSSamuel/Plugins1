=== Social Buttons ===
Contributors: alexpooley
Tags: social networks, digg, reddit, delicious, sphinn, dzone, stumbleupon
Stable tag: 1.1
Tested up to: 2.2.5
Requires at least: 2.0.2
Donate link: http://www.alexpooley.com

Selectively add social network buttons to your posts, or theme design.

== Description ==

Selectively add social network buttons such as digg, sphinn, etc to your posts or theme design.

I wrote this plugin because I wanted finer control over where and which buttons
were placed on my site and in my posts.

Sometimes I have marketing posts so I want to link to Sphinn, but sometimes I have
technical posts so Reddit would be a better choice. This plugin is flexible enough that
if you want the same button in every post, then you can still modify your theme very easily
to accomplish this.

You may place as many buttons, in as many places in your posts as you like.

This plugin handles:
- Digg
- Reddit (all button styles)
- Delicious
- Sphinn
- Dzone (all button styles)
- StumbleUpon

= For Your Posts =

Use the following in your posts: [SB button 1, ..., button N]

Here's an example post...
-----------------------------------------------------
	Hey, check out my new buttons!
	Here they are: [SB digg, delicious, reddit]
	And look
	Here's some more:
	[SB reddit, sphinn]
-----------------------------------------------------

The different button types are:
- digg
- delicious
- reddit
- reddit1 (same as reddit)
- reddit2
- reddit3
- sphinn
- dzone
- dzone1 (same as dzone)
- dzone2
- stumbleupon
- stumble (same as stumbleupon)


= For Your Themes =

`<?php echo sb_make_button('digg', 'http://www.alexpooley.com') ?>`
`<?php echo 'I'm in a post now:'.sb_make_button('reddit', get_permalink()) ?>`


== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `social-buttons.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

There are so many other social networks that I could add to this plugin. If you want something
added then please contact me through [my blog](http://www.alexpooley.com "Freelance Web Developer").

Enjoy!

== Frequently Asked Questions ==

Please feel free to ask questions by contacting me through my blog.

== Screenshots ==

1. You can see examples on my blog post that announced the plugin: [http://www.alexpooley.com/2008/05/09/release-social-buttons-wordpress-plugin/](http://www.alexpooley.com/2008/05/09/release-social-buttons-wordpress-plugin/)
