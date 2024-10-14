=== Forms with chart from VAB ===
Plugin Name: Forms with chart from VAB
Contributors: vabtopic
Donate link: https://it-vab.ru/vab-forms-with-chart#donate
Tags: feedback, form, contact form, forms with chart, forms with csv
Requires at least: 5.5.1
Requires PHP: 5.6.20
Tested up to: 6.6
Stable tag: 1.2.3
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Simple Plugin for creating forms, inquirer and questionnaires with the ability to display the results in the form of charts.

== Description ==

Forms with chart from VAB can manage numerous contact forms where you can flexibly customize the content of the forms with fairly simple markup. The main direction of the plugin is polls and questionnaires with the output of results in the form of diagrams of such fields as «Check boxes», «Radio buttons», «Drop-down list» in pure css, but it is also suitable for creating other options for feedback forms, including those with the ability to send attachments , as well as write data to CSV files. Forms have built-in spam protection and more.

= Docs and support =

You can find more detailed information about Forms with chart from VAB on [it-vab.ru](https://it-vab.ru/vab-forms-with-chart/).

= Forms with chart from VAB needs your support =

It is hard to continue development and support for this free plugin without contributions from users like you. If you enjoy using Forms with chart from VAB and find it useful, please consider [making a donation](https://it-vab.ru/vab-forms-with-chart#donate). Your donation will help encourage and support the plugin's continued development and better user support.

= Privacy notices =

With the default configuration, this plugin, in itself, does not:

* track users by stealth;
* write any user personal data to the database;
* send any data to external servers;
* use cookies.

In the form settings, you can activate the plugin actions:

* logs the entered form data to a file for displaying the results of diagrams.
* logs the entered form data to a CSV files.


= Recommended plugins =

None

= Translations =

The plugin supports the ability to translate into any language. You can use special programs for translation, such as «Poedit». By default, the plugin is only translated into Russian.

== Installation ==

1. Download the plugin, unzip it and move the unzipped folder to the "wp-content/plugins" directory in your WordPress installation.
2. In your admin panel, go to **Plugins** screen (**Plugins > Installed Plugins**) and you'll find Forms with chart from VAB in the plugins section
3. Click on the 'Activate' button to use your new plugin right away.
4. Done  ¯\_(ツ)_/¯
5. PS: Remember to click the **Enable auto-updates** link for this plugin so that you don't miss cool new features as they come in.

You will find **Contact** menu in your WordPress admin screen.

For basic usage, have a look at the [plugin's website](https://it-vab.ru/vab-forms-with-chart/).

== Frequently Asked Questions ==

Do you have questions or issues with Forms with chart from VAB? Use these support channels appropriately.

1. [FeedBack](https://it-vab.ru/контактная-форма/)
2. [Plugin's website](https://it-vab.ru/vab-forms-with-chart/)

= Can I add id and class attributes to a form element? =

Yes. You can add any id and class to a form by adding the form_id and form_class attributes into a [VABFWC] shortcode.
For example:

`[VABFWC id="2228" form_id="ThisID" form_class="new-class two-new-class"]`

= How to display form results anywhere else using shortcode? =

To display the results of the form in any other place, you need to add the shortcode «VABFWC_Graphic».
For example.

**1.** For page and post editor

`[VABFWC_Graphic id="2228" title="Title for shortcode" tag="h4" class="my_class"]`

**2.** PHP code

`echo do_shortcode( '[VABFWC_Graphic id="2228" title="Title for shortcode" tag="h4" class="my_class"]' );`

Where:

* id - form identifier (required);
* title - text before displaying form results (optional);
* tag - the tag in which the title will be wrapped (optional). Allowed tags - h1, h2, h3, h4, h5, h6, div, p, center;
* class - Sets the style class for the tag (optional);

= What filters exist? =

* VABFWC_validate_filter - Returns either true or false. If any condition returns true, the form will stop working (message will not be sent)
* VABFWC_fields_filter - Returns a string to display on the screen. Allowed HTML  tag <input> with attributes «type», «id», «class», «name», «value», «checked», «onfocus», «onchange»
* VABFWC_message_filter - Returns a string to display as text (message)
* VABFWC_message_after_filter - Returns a string to display as text (message). Fires after a successful email has been sent.

= How to use filters? =

Examples of using filters:

**1.** VABFWC_fields_filter.
The code below will add a hidden field via the "formInput" class, which will be with a default value of "WordPress". Only the <input> tag without the <label> will be output (see description above for VABFWC_fields_filter)

`add_filter( 'VABFWC_fields_filter', 'VABFWC_fields_filter', 10 );
if ( !function_exists(	'VABFWC_fields_filter'	) ){
 function VABFWC_fields_filter( $str ){
  $str	= '<label for="new_field" >' .
           '<input id="new_field" name="new_field" type="text" class="formInput" value="WordPress"/>' .
          '</label>';
  return $str;
 }}`

**2.** VABFWC_validate_filter. The code below will stop the form from submitting if at least one condition returns «true».

`
add_filter( 'VABFWC_validate_filter', 'VABFWC_filter_function', 10 );
if ( !function_exists( 'VABFWC_filter_function' ) ) {
 function VABFWC_filter_function( $str ){
  if ( !isset( $_COOKIE['my_cookie_agree'] ) || $_COOKIE['my_cookie_agree'] !== 'agree'	) { // first
   return true;
  }
  if ( sanitize_text_field( $_POST['new_field'] ) !== 'WordPress' ) { // second
   return true;
  }
 }}
`

Where:

* The first condition checks for a «cookie» with a value of «agree» set. Let's say you have an "I agree" button on your site that, when clicked, sets a «cookie» with the value «agree», which means that the user has consented to the use of cookies. Thus, until the user clicks the "I agree" button, the form will not work, and the life of the bots will become more complicated;
* The second condition checks the value of the hidden field, if it is different from the default value («WordPress»), further processing of the form will be stopped;

**3.** VABFWC_message_filter. If a «cookie» with a value of «agree» is not present (the user has not consented to the use of the «cookie»), the code below will display a message to the user.

`add_filter( 'VABFWC_message_filter', 'VABFWC_message_filter', 10 );
if ( !function_exists(	'VABFWC_message_filter' ) ){
 function VABFWC_message_filter( $str ){
  if ( !isset( $_COOKIE['my_cookie_agree'] ) || $_COOKIE['my_cookie_agree'] !== 'agree'	) {
   return $str = esc_html__( 'Использование cookie отключено в настройках безопасности Вашего браузера, либо не дано согласие на их использование', 'VAB' );
  }
 }}`

**4.** If we need to add filters for a particular form, we can use the global variable «post» and check the post/page id:

`add_filter( 'VABFWC_validate_filter', 'my_filter_function', 10 );
function my_filter_function( $str ){
 global $post;
 if ( $post->ID == 1652 ) {
  if ( !isset( $_COOKIE['my_cookie_agree'] ) || $_COOKIE['my_cookie_agree'] !== 'agree' ) {
   return true;
  }}}`

**5.** VABFWC_message_after_filter. After successfully sending an email, we can perform any of our calculations and display their results on the screen

`
add_filter( 'VABFWC_message_after_filter', 'VABFWC_message_after_filter', 10 );
if ( !function_exists('VABFWC_message_after_filter') ){
	function VABFWC_message_after_filter( $str ){
	 global $post;
	 if ( $post->ID == 11057 ) {
		// do something
		$str .= 'Hellow';

	 }
	 if ( $post->ID == 11052 ) {
		// do something
		$str .= 'World';
	 }
		return $str ;
}}
`

= Where are of the log files? =

The log files are in the uploads folder. Folder structure example:

`...
├── your.site.com
	...
	├── wp-content
	│		├── languages
	│		├── plugins
	│		├── themes
	│		├── upgrade
	│		├── uploads
	│		│		...
	│		│		├── VABFWC
	│		│		│		├── your-site-com
	│		│		│		│		└── Diagram
	│		│		│		│				├── «form ID»
	│		│		│		│				│		├── .htaccess
	│		│		│		│				│		...
	│		│		│		│				│		├── «log files»
	│		│		│		│				│		...
	│		│		│		│				│		└── index.php
	│		│		...
	│		└── index.php
	├── wp-config.php
	...`

== Donate link: ==
<a href="https://www.paypal.me/vladimirbrumer" target="_blank">PayPal</a>
<a href="https://yoomoney.ru/to/4100110059331346" target="_blank">YandexMoney</a>


== Demo video ==

Only Russian language

https://www.youtube.com/watch?v=efQ3uovLQSY

== Screenshots ==

1. General view of the list of questions, editing and adding new ones
2. General view of diagrams on the frontend
3. General view of additional options
4. General view of an incoming E-mail message
5. Questionnaire for personal qualities with Additional Styles
6. Questionnaire of personal qualities. We calculate points using VABFWC_message_after_filter and issue a characteristic / recommendation
7. Screenshot of blocks gutenberg
8. CSV log file saved in xlsx format

== Changelog ==

= 1.2.3 - 04.07.2024 =

* Fixes for compatibility with Wordpress 6.6;
* Fixes for compatibility with PHP 8.1 and higher (replacing FILTER_SANITIZE_STRING);
* Fixed the work of the form option (sending the form by default to the Email field in the completed form);

= 1.2.2 - 26.10.2022 =

* Small changes for better compatibility with Wordpress 6.1;

= 1.2.1 - 30.09.2022 =

* Small changes in HTML markup;
* Added the ability to upload data to a CSV file. Files will automatically be split by month;
* Added options: «Manage the display of CSV files for users»;
* Added the ability to hide/show the chart to specific users (optional);
* Added option: «Show the number of answers for each question above the pie chart»;

= 1.2.0 - 19.06.2022 =

* Styling additional options;
* Added option - ability to change table header;
* Fixed - small edits for better compatibility of gutenberg blocks;

= 1.1.9 - 07.06.2022 =

* Added an option that cancels sending emails;
* Added classes and IDs to the form elements;
* Added the ability to send a copy of an email to a user;
* Added Gutenberg blocks for quick and easy output of forms and charts;

= 1.1.8 - 02.06.2022 =

* Fixed - notification about undefined variable;
* Added a submenu where you can read about the current release;
* Added attributes for shortcode. Now you can add any id and class to a form;

= 1.1.7 - 30.05.2022 =

* Minor styles tweaks;
* Bugfix - table reset for administrator was performed without checkbox set;

= 1.1.6 - 10.05.2022 =

* Added a new filter to be able to add a message when the email is successfully sent;

= 1.1.5 - 07.05.2022 =

* Added an option to show charts to admins only;
* Added filters for the ability to add (check) fields, as well as display a message;

= 1.1.4 - 02.05.2022 =

* Added shortcode to display form results anywhere;
* Include wp-color-picker;
* Now the name of the log files depends on the form ID;

= 1.1.3 - 20.04.2022 =

* Added the ability to move form elements (swap questions);

= 1.1.2 - 14.04.2022 =

* Loading plugin

== Upgrade Notice ==

None