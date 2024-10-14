=== Filter Anything ===
Contributors: vardaamkalrav
Tags: filter, directory, ajax pagination, advance filters, post filter, user filter, search, advance search, filter results
Requires at least: 4.9
Tested up to: 6.2
Stable tag: 0.1.4
Requires PHP: 7.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Filter Anything allows you to create custom filters & it can filter all types of posts and users data.

== Description ==

Filter Anything offers Advance filters for any POST or USER data. You can instantly create any type of Directory with your choice of filters in different layout options using a simple shortcode.

At a glance, this plugin adds the following:

* Instant Directory creation using shortcode
* Ajax pagination
* Multiple Layouts like: Fullwidth or Sidebar
* Adjustable Grid column count in results
* Filter any post type by: Meta field, Taxonomy, Title & Content, Post Date, Author or your own custom query
* Filter any user type by: Meta field, Display Name, Email, Username, Registration date, Role or your own custom query
* Supports changing Directory wise Label & button Titles
* Set Order By and Per page count of the resulted data
* customize look and feel by adding Quick CSS

Filter Anything acts as a standalone Directory to show your advance custom filters and results in your own choice of format.

== Advance Usage (For Advance Users) ==
It's very easy to modify result item template and to add your own custom query by using Filters:

= Filter for modifying entry html (xx is filter id) =
`function example_callback( $html, $entry ) {
    ...
    return $html;
}
add_filter( 'wfa_directory_entry_html_xx', 'example_callback', 10, 2 );`

= Filter for modifying filter query args (xx is filter id) =
`function example_callback( $args, $filters, $form_data ) {
    ...
    return $args;
}
add_filter( 'wfa_directory_query_args_xx', 'example_callback', 10, 3 );`

= Form submit to another page =
For showing only form and submitting on another url use following shortcode example
`
[wfa_filter id="xx" submit_url="https://www.example.com/some-other-page"]
`

== Changelog ==

= 0.1 =
Initial release.

= 0.1.1 =
* Feature: Sort by and Total records counter added
* Improvement: Prevent shortcode from being used multiple time on same page
* Fix: Allow results to show even when no filters are selected
* Fix: jQuery issues in Traditional themes is fixed, Now Filter will work even if jquery is added in footer

= 0.1.2 =
* Fix: Taxonomy and Post type selection on filter is now lazy loaded. So, all the lately registered post types and Taxonomies can be selected
* Fix: Hooks are modified to avoid conflicts
* Fix: css changes applied to better support Enfold theme

= 0.1.3 =
* Improvement: To show only child terms in filter you just need to enter slug instead of termID*
* Fix: Multiple checkbox filter was only applying last selected entry, This is fixed now*
* Fix: Added suppress_filters is query to prevent other plugins from interfering the results*

= 0.1.4 =
* Improvement: Added post html classes on each article for better CSS flexibility*
* Improvement: Added Taxonomy Pre Filters support to restrict directory results for selected taxonomy terms*

== Screenshots ==
1. Full width horizontal filter layout
2. Sidebar filter layout
3. Filter query settings edit
4. Filter layout settings edit
5. Filter fields edit
6. Filter directory default text edit
7. List of Filters in admin
