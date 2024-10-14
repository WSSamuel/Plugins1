=== author-avatar ===
Contributors: g-kanoufi
Donate link: http://lostwebdesigns.com
Tags: user profile, profile picture, custom user profile picture, gravatar, author avatar, author-avatar, avatar, author, image de profil utilisateur
Requires at least: 3.5.1
Tested up to: 3.8
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add an upload field in the user profile admin to add a custom profile picture into usermeta table.

== Description ==

Add an upload field in the user profile admin - Don't want to use gravatar profile picture, or just don't have one, just download this plugin. It will add a custom field in the user admin with the possibility to upload your own. Once uploaded, it will add the picture url inside the usermeta table so you can easily display it with ` get_the_author_meta ` .

Translation ready and already available in French.

- Easy to use, once activated and your picture uploaded, grab the source url with:

 ` <?php $user_meta_image = esc_attr( get_the_author_meta( 'user_meta_image', get_the_id() ) ); ?> `

Just add an image tag where you want the picture to be displayed like so:

` <img src="<?php echo $user_meta_image;?>" alt="My Custom user Profile Picture"> `

Et voilà!

== Installation ==

1. Upload `` to the `/wp-content/plugins/` directory
2. Activate the plugin through the "Plugins" menu in WordPress
3. grab the source url with ` $user_meta_image = esc_attr( get_the_author_meta( 'user_meta_image', get_the_id() ) ); `. Just add an image tag where you want the picture to be displayed like so: ` <img src="<?php echo $user_meta_image;?>" alt="My Custom user Profile Picture"> `
4. Style as you wish.

== Frequently Asked Questions ==

= What about if i want to use a user profile picture outside of it's author page? =

It's pretty easy, just change the last parameter "get_the_id()" wjth the id of the user you want to show, as follow:
 ` $user_meta_image = esc_attr(get_the_author_meta('user_meta_image', 1)); `


== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 1.0 =
* Initial Commit


== Upgrade Notice ==

= 1.0.2 =
Removed `screen_icon` as deprecated with wordpress 3.8

= 1.0.1 =
Updated ` update_usermeta() ` with ` update_user_meta() ` as update_usermeta is deprecated since v3.0

= 1.0 =
No upgrade notice yet, first version of this plugin.
