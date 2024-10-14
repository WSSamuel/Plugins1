=== Lottery Number Supplier ===
Contributors: Living Fossil 
Author URI: http://wordaster.com/About.html 
Plugin URL: http://wordaster.com/lottery-number-supplier.html 
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5SKUE2KK3H4ML 
Tags: lottery, lottery number, quick pick, sweepstake, random number, fortune cookie numbers, fun numbers, game of chance, loterie, mise éclair, tombola 
Requires at least: 3.3
Tested up to: 5.6.2 
Stable tag: trunk 
License: GPLv2 or later 
License URI: http://www.gnu.org/licenses/gpl-2.0.html 

Enables you to draw numbers for use in some of the most popular lotteries by inserting in your blog a mini-box of an easy, quick pick selector 

== Description ==

Use this free plugin to add to your WordPress blog a mini-box that presents your readers with a lottery numbers' supplier. By choosing within it a lottery from a selection of the ten most popular games and then clicking a button, they will get in response a row of 'quick pick' numbers tailored to the requirements of their chosen lottery. Then to get more rows all they need do is to click the button again. 

Liven up your WP site with this fun and easy-to-use feature that will help increase user engagement and attract more repeat visits.

You can locate this mini-box in any place on your pages or posts you want by inserting in that place the shortcode  **[lotsup cycles='n']** where **'cycles'** is an **optional**  argument.

Under certain conditions you can insert a condensed form in a sidebar. (More details can be found in the 'Frequently Asked Questions' section.) 

(A noter que cette extension est disponible aussi en **Francais**.) 

Please note that this is not an application that will also enter the numbers it supplies into any lottery, as its functions do not extend to enabling your readers to actually play a lottery.

When using this **'Quick Picker'**, your readers are given a choice of lotteries from a selection of some ten of the most popular multi-state games of North America and Europe. (Please refer for their names to the snapshots.) 

The plugin can rapidly provide as many lines of quick picks as your visitors request within reasonable limits, while at the same time taking up a bare minimum of your page's real estate with an attractive, compact box that is at most only four rows deep and narrower than 300 pixels. (For an example please see the snapshots.) 

This is a relatively fast application leaving a small footprint that has been built in part with AJAX technology to enhance its dynamic operation, while also preventing multiple pages reloads on each next click of its button for another line of quick picks.

It is a secure plugin that has built into it a number of safety measures that shield you from unwelcome intrusions and abuse without interference to the rest of your site's operation.

= How do my readers and I stand to benefit from this plugin? = 

This is a free plugin that should help make your WordPress blog a more fun and useful destination for your subscribers.

In particular, it will give your site's regular visitors the ability to pick lottery numbers from the convenience of their own tablet or home computer, without them needing to rely on a terminal operator at the store for obtaining random numbers to play.

This plugin is able to provide this service, as it functions independently of lottery game operators with whom we haven't any affiliations or relationships at all. 

Lending further support to the unbiased nature of these quick pick numbers, is that their generator is driven by a rapid and highly-rated algorithm that is one of the rare few in being the closest to a true randomizer. 

= To use this plugin = 

Insert where you want the "Quick Picker" to appear in a page or post this shortcode: 

*[lotsup]*

This will result in the appearance at each such place of a mini-box that displays within it a title line, a drop-down list of lotteries with alongside it a 'Pick' button and a next row containing a text-area that will hold upon its arrival a response line of as many as eight distinct numbers.

When your site's visitor clicks the 'Pick' button after having selected a lottery, a row of numbers will be supplied in the response line. That user will then be able to repeat this five more times to get more rows of numbers for the same lottery selection or for any other one chosen in place of the prior selection. 

The same user will be able to resume with a  further round of six picks after a 12-second pause or intermission. This total of six lines obtained corresponds to the amount of times that rows of numbers will be supplied by default between each intermission.

To change this default, supply a value for the shortcode's optional argument 'cycles'.

=  Example: =

Insert in a page the following:  

*[lotsup cycles='9']*

Here by supplying the shortcode an argument 'cycles' with a value of '9' specified for it, you over ride the standard default of '6'. From hereon, all the users of the plugin will be able to go for 9 continuous rounds of pickings at a time.

= Caution = 

If you supply the argument 'cycles' with the shortcode, ensure that you give it a value only from within the numbers' range from 1 to 12.  Were you to give it any other value, the plugin will respond with the error message:  
                                                          
*Omit cycles or give a number 1..12*   

= To sum up; = 

To apply the plugin, use the shortcode **[lotsup cycles='n']** where **'cycles'** is an **optional** parameter.  If omitted, the value of 'cycles' defaults to the number six.  If used, 'cycles' must be given the value of one of the numbers from 1 to 12.
=
= Living Fossil can use your Support =

Please show your approval by giving this plugin a star rating and by recommending this plugin to friends and acquaintances. 

If you enjoyed this plugin you might then consider treating me to a cappucino? You rewarding me with a donation for such a purpose would be appreciated. It would help compensate in some small way for all the effort that went into building this and for the many hours I toiled to learn how to build practical and functional plugins with PHP :-)  

== Installation ==

The quickest method for installing the lottery Number Supplier is to do so from within WordPress, using the Plugin/Add New feature.  

Otherwise, if you would prefer to do things manually then follow these instructions:

1. Download the 'lotterynumbersupplier' folder using our plugin URL listed above. 
2. Unzip this downloaded folder. 
3. Upload the un-zipped lotterynumbersupplier folder to the ./wp-content/plugins/  directory. 
4. Activate the plugin through the Plugins menu in WordPress. 

== Frequently Asked Questions ==

=  How can I reach you? =

Should you wish to give us your feedback or would like to either extend 
this plugin, or its later versions, then please forward your comments and suggestions to: 
                     webmasterwordaster@gmail.com 

= Can I change the appearance of the 'Quick Pick Box' to make its colour scheme and dimensions blend in better with that of the theme I use for my WP blog? =

Yes, sure. Result will vary depending on the combination of theme and browser that you happen to be using. To do your changes, navigate to your  plugin's directory at:

*wordpress/wp-content/plugins/lotto-number-supplier/*

Located under that directory is a folder "stylings". You should find in it a css style sheet named "lns_pickformstyle.css".

After you have made a backup copy of it, open this original copy with your editor and find the line with:

*background-color:#F1F1F1*

Change this to the colour you prefer, make any other changes you need and save the stylesheet. 

With a few exceptions, such as this background colour, the style values for this plugin have been left at the default settings for the theme that is applicable. The one that was active when the snapshots shown below were taken, is the TwentyFourteen theme. 

= Can I include this "number supplier" in a sidebar? = 

Yes, you can if your blog's theme comes with a sidebar and you are willing to trade-off some of the form's esthetics against a reduction in size. Also, you will need to accept being able to insert the plugin ONLY in the sidebar, as one CANNOT USE IT BOTH in the main body (i.e. pages and posts) AND in the sidebar of the same blog or site.  It has to be only in the one or the other.

To do this select a **text widget** from the appearances' panel of your administration dashboard then drag and drop it where you want this to appear in your blog's sidebar. Next edit this to insert in the text the shortcode **[lotsup]**. When done, save and close the text widget. In  the majority of cases that will be all you need do to cause a compacted version of the Lottery Number Supplier to appear automatically in the sidebar when you next view your site.   

A best effort was made to fit the product to the most widely used default themes. But as already noted above, results may still vary depending on the particular combination of theme and browser that you happen to be using, so you might need to tweak the CSS styles.  (Please see the earlier Q. and A. regarding appearance.)

=  Can't you drop the requirement that my blog's visitors log in for them to be able to use this plugin? = 

The thinking behind this is that the attraction of benefitting from the use of this free "quick picker" would give the casual visitors to your site an incentive to make themselves known by registering with you, so as to then be able to log in and use this plugin. 

What is more to the point is that it usually takes a real, live human to first register with a site before an 'agent' can log in. 

This provides a valuable first line of defense against 'bots' and other 'hit-n-run' visitors who might be intent on doing mischief by abusing this plugin. (With regard to this last point, refer please also to the other questions here about performance and about the cycle-driven 'pause'.)

However, if many of your site's regular users insist on being able to use the plugin without having to first log in each time, it would be a simple enough matter to resolve. Just drop me a note at my contact address stating also your site's URL. I will be happy then to reply you with an e-mail that describes what you will need to do in order to lift this restriction from your blog.    

=  How did the lotteries that one can choose from the drop-down options get to make it onto that selections' list? I miss from there my favourite lottery.  =

When planning and building this plugin, I needed to keep in proportion the extent of its complexity and the effort going into building it, with the size of the likely following that the lotteries involved enjoy. Moreover, had I addressed the local and regional lotteries as well, it would have made the plugin too unwieldy.

Because of this I am much to my regret obliged to keep within the scope of this plugin only the biggest lotteries that have a continental or multi-state coverage.

But if by any chance I missed any one of the major inter-state lotteries that you are keen on, you are welcome to drop me a note and I will try and make a plan for you.

= I am concerned that users of this plugin might be turned off by the need to pause after every six picks of number rows. =

The justification for having included this default behaviour with the plugin was to add a local buffering mechanism for helping prevent very large numbers of user picks flooding the server with an excessive amount of requests. (Some more is said in regard to this in the reply below to the question on performance.)  

My understanding from informal surveys is that 70 percent of lottery consumers are estimated to habitually play nine or less rows of numbers at a time. 

You can plan for this by supplying with your shortcode for the plugin an explicit value of 9 for its argument to override the default of 6 as follows:

*[lotsup cycles='9']* 

The chances would be good then that the majority of your users will never even get to the point of being invited to take that interlude. 

Let us also remember that this is after all about a kind of entertainment.  And a twelve second period is slightly less long than an interval used to refill a cup of coffee, add cream and sugar, stir and take a first sip.

So you might be unduly concerned. 

= The interactive operation of this plugin leaves me in one of two minds about installing it. I have a large user base so that it might happen that many of them could use this plugin and subject my server to their requests all-together at the same time.  Also, I worry that some of them might repeat their picks an excessive number of times. Won't all of this add up to burden my site with a multitude of page loads and overload my server with requests? =

Most if not all the modern application and network servers in operation today do a good combined job of handling multiple concurrent transactions. 

Moreover, as extra insurance I have built several measures into the plugin to help prevent such a situation as you describe from arising. Just to mention a few of these:

Only your authenticated users will be able to use the plugin, which should help keep away from your site pranksters and other mischief-makers.

Next, use was made also of AJAX in building this application. So no page reload should result from making with it a pick, as AJAX will handle asynchronously each such request and refresh only the single line that receives the row of lottery numbers sent in response by the backend process on the server.

If you have, as you say a large user base, you have in all likelihood already seen the merits of implementing a caching mechanism.  The better ones among these readily accommodate the comparatively small overhead arising from the AJAX -managed traffic that will come from using this plugin. 

Finally, a simple additional buffering mechanism is made available to you through the plugin shortcode's 'cycles' argument. 

One of the purposes of this argument is to help dampen the impact of any user who might be inclined to hit the pick button incessantly like a woodpecker.  It does this by enabling a 12-second rest interval to be set after a given total of rounds picking, that you can regulate through the value you specify for this argument. (The default total that applies when you omit the cycles argument is 6 rounds.)

Its other purpose is to provide you a tool for helping you informally level across your users their demand for the plugin's services, so that they can each get to have a fair turn at using the "quick picker". 

My recommendation is that after starting up the plugin, you gradually adjust the cycles argument to different values until you attain a situation that works well for you. 

== Screenshots ==

1. Starting view of Quick Pick mini-form
2. View of Quick Pick form with pull-down selections
3. view of Quick Pick form after response of a numbers' line
4. Sample of the Quick Pick form's French version.
5. View of Quick Pick form's slimmer version in sidebar.
6. View of Quick Pick form's slimmer version in sidebar, French version.

== Changelog ==

= 1.2 =
current release -
Updated the readme.txt to reflect compatibility up to WP version 5.6.2 

= 1.2 =
current release -
Updated the readme.txt to reflect compatibility up to WP version 5.3.2 

= 1.2 =
current release -
Updated the readme.txt to reflect compatibility up to WP version 5.0.2 

= 1.2 =
current release -
Updated the readme.txt to reflect compatibility up to WP version 4.8.1 

= 1.2 =
current release - Updated the lns_lottoprofiles component to reflect the recent change of rules for Euromillions, that lifted from 11 to 12 the ceiling on the two 'bonus' or 'lucky star' values.
Also applied updates to readme.txt file to reflect compatibility up to WP version 4.7.1. 

= 1.2 =
Edited the readme.txt to fix some typos, to correct the conributors name and to reflect compatibility up to WP version 4.6.1 
Edited the plugin's main code to update the author name. 

Extended processes to enable the insertion into a sidebar of an alternate, slimmer variation of the Quick Pick box. 

= 1.1 =
Added minimum set of french translations and emphasized validation error message; added a screenshot of form's french version.

= 1.0 = 
Fixed some typo's in readme.txt of initial release.

= 1.0 =
 Initial release 

== Upgrade Notice ==
..

== License ==

This file is part of lottery-number-supplier. 

'lottery Number Supplier' is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. 

'lottery Number Supplier' is distributed in the hope that it will be useful,  but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. 

A copy of the license is included in the root of the plugin's directory. The file is named `LICENSE`. 

You should have received a copy of the GNU General Public License. If you 
did not, see <http://www.gnu.org/licenses/>. 

== How to uninstall the Lottery Number Supplier ==

To uninstall 'Lottery Number Supplier', you merely need to de-activate and delete it from the plugins' list of your administrator dashboard. 