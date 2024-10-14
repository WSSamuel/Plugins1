=== Plugin Name ===
Contributors: davidanaxagoras
Donate link: http://davidanaxagoras.com/whizmatronic/#donate
Tags: screenwriting, writing, progress, meter, bar, sidebar, widget, track,
Requires at least: 2.8
Tested up to: 3.0.1
Stable tag: 0.3.0

The Scribometer allows writers to track and display their writing progress in their sidebar.

== Description ==
*Dave's Whizmatronic Widgulating Calibrational Scribometer* allows writers
to display fully customizable progress meters in their sidebar which track
the status of their current works in progress.

== Installation ==
**NOTE:** *The Scribometer is a widget and requires a compatible, widgetized WordPress theme.*
1. Upload `scribometer.php` to the `/wp-content/plugins/` directory of your WordPress blog.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Add Scribometer widgets to your sidebar through the Widgets menu.
4. Customize your Scribometer settings in the 'Widgets' menu and enjoy!

= Options =
**Widget Heading**
What to call the widget in your sidebar. Try "My Scribometer" if you find the official title a bit lengthy.

**Title of work**
The title of your screenplay, novel, short story, etc. If you haven't decided, "Untitled LastName Project" is standard.

**Project phase**
"Outline", "First Draft", "Polish", "Revision", etc.

**Units of measure**
How do you want to measure your progress? "Words", "Pages", "Scenes", etc. 

**Units complete**
How many pages, words, etc., have you writen so far? Enter a number only, such as 5, 21, or 11,323.

**Total units goal**
Unfortunately, in order to display a progress bar, you will have to estimate how long the script, novel, or short story will
be when you finish it. Yeah, you can't be certain. Just make your best guess, and adjust along the way. Numbers only, here.

**Height of progress meter in pixels**
Allows you to adjust the thickness of your progress meter. I suggest 15. Numbers only, DO NOT include
any text such as "px".

**Color of progress meter border**
The border defines the length of the progress bar. It will "fill up" as you update your writing progress. Choose
any color that works well with your theme (or not, it's up to you). You may enter any valid CSS Color Value such as `#000000`, or `#0000FF`.
You can also use any valid CSS Color Name, such as `Black`, `Navy`, `Pink`, or `Salmon`. Check your theme's style sheet for some ideas.

**Color of progress meter bar**
The actual bar that will measure your progress as it grows to 100%. Same color options as above.

== Frequently Asked Questions ==

= Can I hide the widget title? =
The elements of the Scribometer are highly selectable using CSS. You can edit your stylesheet and use `display: none` to hide almost
any element of the Scribometer. For instance, if you don't want to display the widget title, try this (assuming your theme uses `h2` for your titles):

`#scribometer h2 { display: none; }`


= I'd like to give you credit, but the link looks so ugly in my sidebar =
Thanks. I think. Try styling the link by editing your stylesheet. Cut and paste the CSS code below to start with:

`#scribometer-link { 
	font-size: small;
	font-style: italic;
	text-align: right;
}`

That's a little more tasteful, isn't it?

== Screenshots ==
1. Your Scribometer progress meter's appearance will depend on your settings. This is one possible styling.
2. You can change several options in the widget menu.

== Release Notes ==
= 0.3.0	-	Beta release =
* Multiple Scribometer widgets now supported. Just drag and drop as many as you need into your sidebar.

= 0.2.1	-	Beta release =
* Now checks to see if your sidebar uses header level `<h3>` for widget titles, and if so, uses `<h4>` for the 
**Title of Work**. Otherwise, **Title of Work** defaults to `<h3>`. This improves readability in most sidebars. 

= 0.2.0	-	Beta release =
* Added user-defined units of measure.
* Added option to dislpay a link to the plugin's home page.

= 0.1.1	-	Alpha release =
* First public release

== References ==
1. http://davidanaxagoras.com/whizmatronic/