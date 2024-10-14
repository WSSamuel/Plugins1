<?php
/**
Plugin Name: Top Contributors
Version: 1.4.1
Plugin URI: http://justmyecho.com/2010/07/top-contributors-plugin-wordpress/
Description: Display your top commenters/authors in a widget.
Author: Robin Dalton
Author URI: http://justmyecho.com
Changes:
	1.4.1 - Fixed bug with comment thresholds
	1.4 - Many new user requested features added
	1.3.1 - Fixed a bug with widget caching
	1.3 - Option to show top Authors instead of commenters, plus few other new options. Fixed language localization.
	1.2 - Added integration for 'Add Local Avatar' plugin. Reformatted text to support plugin localization, + other fixes and additions.
	1.1 - Added Time limit options, fixed some formatting/style issues.
	1.0 - Initial release.
**/

/**
 * Define plugin path, and load language directory for text localization
 */
define('JMETC_PLUGINPATH', WP_CONTENT_URL . '/plugins/'. plugin_basename(dirname(__FILE__)) . '/');
load_plugin_textdomain( 'jmetc', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );


/** 
 * Default values for plugin options
 */
$tcDefault['options'] = array(	
						'limit' => 10,
						'show_count' => 1,
						'show_avatar' => 1,
						'avatar_size' => 40,
						'exclude_author' => '',
						'format' => 1,
						'cache' => '',
						'time_limit_type' => 1,
						'time_limit_int' => 1,
						'time_limit_interval' => 3,
						'time_limit_this' => 2,
						'rel_links' => 0,
						'count_by' => 0,
						'widget_columns' => 1,
						'category_list' => array(),
						'cache' => '',
						'toplist' => array( array ( 'name' , 'post_count' ) ),
						'show_category' => 0,
						'cat_inc_exc' => 0,
						'keywordluv' => 0,
						'author_page' => 0
					);
$tcDefault['icon'] = array( 
						'show_icon' => 0,
						'icon' => 'star.png',
						'comment_limit' => 0
					);


/**
 * Check and set options for plugin
 */
if(get_option('jmetc_commenters')) {
	$jmetcop['comment'] = get_option('jmetc_commenters');
} else {
	add_option('jmetc_commenters',$tcDefault['options']);
	$jmetcop['comment'] = get_option('jmetc_commenters');
}
if(get_option('jmetc_authors')) {
	$jmetcop['author'] = get_option('jmetc_authors');
} else {
	add_option('jmetc_authors',$tcDefault['options']);
	$jmetcop['author'] = get_option('jmetc_authors');
}
if(get_option('jmetc_icon')) {
	$jmetcop['icon'] = get_option('jmetc_icon');
} else {
	add_option('jmetc_icon',$tcDefault['icon']);
	$jmetcop['icon'] = get_option('jmetc_icon');
}

require 'functions.inc.php';

function top_contributors_load_widgets() {
	register_widget( 'Top_Contributors_Widget' );
}

class Top_Contributors_Widget extends WP_Widget {

	function Top_Contributors_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'jmetc', 'description' => __('Display Top Contributor List.', 'jmetc') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'jmetc-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'jmetc-widget', __('Top Contributors', 'jmetc'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		echo $before_widget;
		if($instance['title'] != '') {
			echo $before_title . $instance['title'] . $after_title;
		}
		jme_top_contributors($instance['list_type']);
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		foreach($new_instance as $key => $val) {
			$instance[$key] = strip_tags( $new_instance[$key] );
		}
		$instance['list_type'] = ($new_instance['list_type'] == 1) ? 1 : 0;
		return $instance;
	}

	function form( $instance ) {
		
		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'list_type' => 0 );
							
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'jmetc'); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:225px;" />
		</p>
		<p>
			<?php _e('Show Top', 'jmetc'); ?>:<br />
			&nbsp; &nbsp; <label><input type="radio" id="<?php echo $this->get_field_id( 'list_type' ); ?>" name="<?php echo $this->get_field_name( 'list_type' ); ?>" value="0"<?php if($instance['list_type'] == 0) echo ' checked="checked"'; ?> /> <?php _e('Commenters', 'jmetc'); ?></label><br /> 
			&nbsp; &nbsp; <label><input type="radio" id="<?php echo $this->get_field_id( 'list_type' ); ?>" name="<?php echo $this->get_field_name( 'list_type' ); ?>" value="1"<?php if($instance['list_type'] == 1) echo ' checked="checked"'; ?> /> <?php _e('Authors', 'jmetc'); ?></label>
		</p>
		<p style="font-size:.9em;"><?php _e('Widget options can be found under Settings > Top Contributors.', 'jmetc'); ?></p>
		
	<?php
	}
}

function jme_tc_activate() {
	global $wpdb, $tcDefault;

	if (!get_option('jmetc_commenters')) add_option('jmetc_commenters', $tcDefault['options']);

	if (!get_option('jmetc_authors')) add_option('jmetc_authors', $tcDefault['options']);
	
	if (!get_option('jmetc_icon')) add_option('jmetc_icon', $tcDefault['icon']);

	@$wpdb->query("ALTER TABLE $wpdb->comments ADD INDEX `comment_author_email` ( `comment_author_email` )");
}
	
function jme_tc_deactivate() {
	global $wpdb;
	@$wpdb->query("ALTER TABLE $wpdb->comments DROP INDEX `comment_author_email`");
	
	/* delete old options from versions 1.3.1 and older */
	delete_option('jmetc');
	
	/* delete current options from version 1.4 and newer */	
	//delete_option('jmetc_commenters');
	//delete_option('jmetc_authors');
	//delete_option('jmetc_icon');
}

function jme_top_contributors($l=0) {
	global $jmetcop;

	if($l == 0 && $jmetcop['comment']['cache'] == '') {
		jmetc_refresh_comment_cache();
		$jmetcop['comment'] = get_option('jmetc_commenters');
	} else if ($l == 1 && $jmetcop['author']['cache'] == '') {
		jmetc_refresh_author_cache();
		$jmetcop['author'] = get_option('jmetc_authors');
	}
	
	echo ($l == 0) ? $jmetcop['comment']['cache'] : $jmetcop['author']['cache'];
}

function jme_add_options_page() {
	add_options_page( __('Top Contributors', 'jmetc'), __('Top Contributors', 'jmetc'), 'edit_themes', basename(__FILE__), 'jme_the_options_page');
}
	
function jme_the_options_page() {
	global $jmetcop;
	
	$jmevar['current'] = 0;
	
	if($_POST['save_settings']) {
		
		$lt = $_POST['list_type'];
		
		$jmetc_options['cache'] = '';
		$jmetc_options['limit'] = $_POST['limit'];
		$jmetc_options['show_count'] = ($_POST['show_count'] == 1) ? 1 : 0;
		$jmetc_options['exclude_author'] = $_POST['exclude_author'];
		$jmetc_options['show_avatar'] = ($_POST['show_avatar'] == 1) ? 1 : 0;
		$jmetc_options['avatar_size'] = $_POST['avatar_size'];
		$jmetc_options['format'] = $_POST['format'];
		$jmetc_options['widget_columns'] = $_POST['widget_columns'];
		$jmetc_options['time_limit_type'] = $_POST['time_limit_type'];
		$jmetc_options['time_limit_int'] = $_POST['time_limit_int'];
		$jmetc_options['time_limit_interval'] = $_POST['time_limit_interval'];
		$jmetc_options['time_limit_this'] = $_POST['time_limit_this'];
		$jmetc_options['author_page'] = ($_POST['author_page'] == 1) ? 1 : 0;
		$jmetc_options['count_by'] = ($_POST['count_by'] == 1) ? 1 : 0;
		$jmetc_options['rel_links'] = ($_POST['rel_links']) ? $_POST['rel_links'] : 0;
		$jmetc_options['show_category'] = ($_POST['show_category'] == 1) ? 1 : 0;
		$jmetc_options['keywordluv'] = ($_POST['keywordluv'] == 1) ? 1 : 0;
		
		$jmetc_options['category_list'] = array();
		$jmetc_options['cat_inc_exc'] = 0;	
		if($jmetc_options['show_category'] == 1) {
			if(is_array($_POST['category_id'])) {
				foreach($_POST['category_id'] as $key => $val) {
					$jmetc_options['category_list'][] = $val;
				}
			}
			$jmetc_options['cat_inc_exc'] = ($_POST['cat_inc_exc'] == 1) ? 1 : 0;
		}

		if($lt == 1) {
			$jmevar['current'] = 1;
			update_option('jmetc_authors', $jmetc_options);
			jmetc_refresh_author_cache();
		} else {
			update_option('jmetc_commenters', $jmetc_options);
			jmetc_refresh_comment_cache();
		}
		
		echo '<div id="message" class="updated fade"><p>Widget Options have been saved.</p></div>';
	}
	
	if($_POST['save_icon_settings']) {
		$jmetc_icon['show_icon'] = ($_POST['show_icon'] == 1) ? 1 : 0;
		$jmetc_icon['icon'] = $_POST['icon'];
		$jmetc_icon['comment_limit'] = $_POST['comment_limit'];

		update_option('jmetc_icon', $jmetc_icon);
		jmetc_refresh_comment_cache();		

		echo '<div id="message" class="updated fade"><p>Icon Options have been saved.</p></div>';
	}

	$jmetc_options_Author = get_option('jmetc_authors');
	$jmetc_options = get_option('jmetc_commenters');
	$jmetc_icon = get_option('jmetc_icon');	
	
	$rmbreaks = array("\n","\r","\r\n");
?>
<script type="text/javascript">
function loadjmetcAuthor() {

	f.list_type1.checked=true;
	
	f.limit.value='<?php echo $jmetc_options_Author['limit']; ?>';
	
	if(1 == <?php echo $jmetc_options_Author['show_count']; ?>) f.show_count.checked=true;
	else f.show_count.checked=false;
	
	if(1 == <?php echo $jmetc_options_Author['show_avatar']; ?>) f.show_avatar.checked=true;
	else f.show_avatar.checked=false;
	
	f.avatar_size.value='<?php echo $jmetc_options_Author['avatar_size']; ?>';
	
	f.time_limit_type<?php echo $jmetc_options_Author['time_limit_type']; ?>.checked=true;
	
	f.time_limit_int.value='<?php echo $jmetc_options_Author['time_limit_int']; ?>';
	
	f.time_limit_interval.value='<?php echo $jmetc_options_Author['time_limit_interval']; ?>';
	
	f.time_limit_this.value='<?php echo $jmetc_options_Author['time_limit_this']; ?>';
	
	f.format<?php echo $jmetc_options_Author['format']; ?>.checked=true;
	
	f.widget_columns.value='<?php echo $jmetc_options_Author['widget_columns']; ?>';
	
	f.exclude_author.value="<?php echo trim(str_replace($rmbreaks,"",$jmetc_options_Author['exclude_author'])); ?>";
	
	f.count_by<?php echo $jmetc_options_Author['count_by']; ?>.checked=true;
	
	f.rel_links<?php echo $jmetc_options_Author['rel_links']; ?>.checked=true;
	
	if(1 == <?php echo $jmetc_options_Author['author_page']; ?>) f.author_page.checked=true;
	else f.author_page.checked=false;
	
	if(1 == <?php echo $jmetc_options_Author['keywordluv']; ?>) f.keywordluv.checked=true;
	else f.keywordluv.checked=false;
	
	if(1 == <?php echo $jmetc_options_Author['show_category']; ?>) f.show_category.checked=true;
	else f.show_category.checked=false;
	
	f.cat_inc_exc<?php echo $jmetc_options_Author['cat_inc_exc']; ?>.checked=true;
	
	var catlist = [<?php echo implode(",",$jmetc_options_Author['category_list']); ?>];
	for( var i = 0; i < document.jme_options.elements["category_id[]"].length; i++ ) {
		if(in_array(document.jme_options.elements["category_id[]"][i].value,catlist)) {
			document.jme_options.elements["category_id[]"][i].checked=true;
		}
		else document.jme_options.elements["category_id[]"][i].checked=false;
	}
	
	showColumnfield();
	showCategories();
	ap.style.display="";
}
function loadjmetcCommenter() {

	f.list_type0.checked=true;
	
	f.limit.value='<?php echo $jmetc_options['limit']; ?>';
	
	if(1 == <?php echo $jmetc_options['show_count']; ?>) f.show_count.checked=true;
	else f.show_count.checked=false;
	
	if(1 == <?php echo $jmetc_options['show_avatar']; ?>) f.show_avatar.checked=true;
	else f.show_avatar.checked=false;
	
	f.avatar_size.value='<?php echo $jmetc_options['avatar_size']; ?>';
	
	f.time_limit_type<?php echo $jmetc_options['time_limit_type']; ?>.checked=true;
	
	f.time_limit_int.value='<?php echo $jmetc_options['time_limit_int']; ?>';
	
	f.time_limit_interval.value='<?php echo $jmetc_options['time_limit_interval']; ?>';
	
	f.time_limit_this.value='<?php echo $jmetc_options['time_limit_this']; ?>';
	
	f.format<?php echo $jmetc_options['format']; ?>.checked=true;
	
	f.widget_columns.value='<?php echo $jmetc_options['widget_columns']; ?>';
	
	f.exclude_author.value="<?php echo trim(str_replace($rmbreaks,"",$jmetc_options['exclude_author'])); ?>";
	
	f.count_by<?php echo $jmetc_options['count_by']; ?>.checked=true;
	
	f.rel_links<?php echo $jmetc_options['rel_links']; ?>.checked=true;
	
	if(1 == <?php echo $jmetc_options['keywordluv']; ?>) f.keywordluv.checked=true;
	else f.keywordluv.checked=false;

	f.author_page.checked=false;
	
	if(1 == <?php echo $jmetc_options['show_category']; ?>) f.show_category.checked=true;
	else f.show_category.checked=false;
	
	f.cat_inc_exc<?php echo $jmetc_options['cat_inc_exc']; ?>.checked=true;
	
	var catlist = [<?php echo implode(",",$jmetc_options['category_list']); ?>];
	for( var i = 0; i < document.jme_options.elements["category_id[]"].length; i++ ) {
		if(in_array(document.jme_options.elements["category_id[]"][i].value,catlist)) {
			document.jme_options.elements["category_id[]"][i].checked=true;
		}
		else document.jme_options.elements["category_id[]"][i].checked=false;
	}

	showColumnfield();
	showCategories();	
	ap.style.display="none";
}
function showCategories() {
	if(f.show_category.checked==true) t.style.display="";
	else t.style.display="none";
}
function in_array(string, array) {
	for (i = 0; i < array.length; i++) {
		if(array[i] == string) {
			return true;
		}
	}
	return false;
}
function showColumnfield() {
	if(f.format1.checked==true) c.style.display="";
	else c.style.display="none";
}
function showThresholdInfo() {
	document.getElementById('jme-advanced-threshold').style.display="";
}
function showAuthorSettings() {
	if(1 == <?php echo $jmevar['current']; ?>) loadjmetcAuthor();
}
</script>
<style type="text/css">
.wrap table.tbloptions td {padding:5px 0;line-height:1.3em;}
.wrap table.tbloptions td.tblbreak {padding:20px 0 5px 0;}
h4 {margin:0;}
#jme-advanced-threshold {
	border:1px solid #ccc;
	background-color:#f3f3f3;
	padding:6px;
	margin:5px 0;
	font-size:.9em;
}
#jme-category-list {
	padding:5px 7px;
	border:1px solid #ccc;
	background-color:#f3f3f3;
}
</style>
<div class="wrap">
<div id="poststuff">
	<form method="post" name="jme_options">
	
	<h2><?php _e('Top Contributors', 'jmetc'); ?></h2>
			
	<div class="postbox">
		<h3 class="hndle"><span><?php _e("How to Use Widget:",'jmetc'); ?></span></h3>
		<div class="inside">
			<p style="font-size:1.1em;"><?php _e('Use the <i>Top Contributors Widget</i> to add the widget to sidebar, or paste this code into your template where you want the widget to display:', 'jmetc'); ?> <br /><br />
			Commenter List: <code>&lt;?php if(function_exists('jme_top_contributors')) { jme_top_contributors(); } ?&gt;</code><br />
			Author List: <code>&lt;?php if(function_exists('jme_top_contributors')) { jme_top_contributors(1); } ?&gt;</code><br /><br />
			Give me feedback, suggest new features, and get more information about the plugin on the <a target="_blank" href="http://justmyecho.com/2010/07/top-contributors-plugin-wordpress/">plugin page</a>.</p>
		</div>
	</div>
	<div class="postbox">
		<h3 class="hndle"><span><?php _e("Top Contributors Options",'jmetc'); ?></span></h3>
		<div class="inside">	

		<table class="tbloptions">	
			<tr>
				<td width="200"><b><?php _e("Show Settings For",'jmetc'); ?>:</b></td>
					<td><label><input onclick="loadjmetcCommenter();" id="list_type0" type="radio" name="list_type" value="0" checked="checked" /> Commenters</label> &nbsp; &nbsp;
						<label><input onclick="loadjmetcAuthor();" id="list_type1" type="radio" name="list_type" value="1" /> Authors</label></td>	
				</td>
			</tr>
			<tr>
				<td><?php _e('Number of Contributors', 'jmetc'); ?>:</td>
				<td><label for="limit"><input style="width:50px;" type="text" id="limit" name="limit" value="<?php echo htmlentities($jmetc_options['limit']); ?>" /></label></td>
			</tr>
			
			<tr>
				<td><label for="show_count"><?php _e('Display Count', 'jmetc'); ?>:</td>
				<td><input type="checkbox" id="show_count" name="show_count" value="1"<?php if($jmetc_options['show_count'] == 1) echo ' checked="checked"'; ?> /></label></td>
			</tr>
			
			<tr><td colspan="2" class="tblbreak"><h4>Avatar Options:</h4></td></tr>
			
			<tr>
				<td><label for="show_avatar"><?php _e('Display User Avatar', 'jmetc'); ?>:</td>
				<td><input type="checkbox" id="show_avatar" name="show_avatar" value="1"<?php if($jmetc_options['show_avatar'] == 1) echo ' checked="checked"'; ?> /></label></td>
			</tr>
			
			<tr>
				<td><label for="avatar_size"><?php _e('Avatar Size', 'jmetc'); ?>:</td>
				<td><input style="width:50px;" type="text" id="avatar_size" name="avatar_size" value="<?php echo htmlentities($jmetc_options['avatar_size']); ?>" /></label> (pixels)</td>
			</tr>
			
			<tr><td colspan="2" class="tblbreak"><h4><?php _e("Time Options", 'jmetc'); ?>:</h4></td></tr>
			
			<tr>
				<td valign="top"><?php _e("Show comments/posts from", 'jmetc'); ?>:</td>
				<td>
					<label for="time_limit_type1"><input type="radio" id="time_limit_type1" name="time_limit_type" value="1"<?php if($jmetc_options['time_limit_type'] == 1) echo ' checked="checked"'; ?>> <?php _e('All Time', 'jmetc'); ?></label>
					<br />
					<label for="time_limit_type2"><input type="radio" id="time_limit_type2" name="time_limit_type" value="2"<?php if($jmetc_options['time_limit_type'] == 2) echo ' checked="checked"'; ?>> <?php _e('The Last', 'jmetc'); ?> </label>
					<input type="text" style="width:40px;" id="time_limit_int" name="time_limit_int" value="<?php echo $jmetc_options['time_limit_int']; ?>" /> 
						<select id="time_limit_interval" name="time_limit_interval">
							<option value="1"<?php if($jmetc_options['time_limit_interval'] == 1) echo ' selected="selected"'; ?>><?php _e('day(s)', 'jmetc'); ?> </option>
							<option value="2"<?php if($jmetc_options['time_limit_interval'] == 2) echo ' selected="selected"'; ?>><?php _e('week(s)', 'jmetc'); ?> </option>
							<option value="3"<?php if($jmetc_options['time_limit_interval'] == 3) echo ' selected="selected"'; ?>><?php _e('month(s)', 'jmetc'); ?> </option>
							<option value="4"<?php if($jmetc_options['time_limit_interval'] == 4) echo ' selected="selected"'; ?>><?php _e('year(s)', 'jmetc'); ?> </option>
						</select>
						<br />
					<label for="time_limit_type3"><input type="radio" id="time_limit_type3" name="time_limit_type" value="3"<?php if($jmetc_options['time_limit_type'] == 3) echo ' checked="checked"'; ?>> <?php _e('Only This', 'jmetc'); ?></label> 
						<select id="time_limit_this" name="time_limit_this">
							<option value="1"<?php if($jmetc_options['time_limit_this'] == 1) echo ' selected="selected"'; ?>><?php _e('week', 'jmetc'); ?> </option>
							<option value="2"<?php if($jmetc_options['time_limit_this'] == 2) echo ' selected="selected"'; ?>><?php _e('month', 'jmetc'); ?> </option>
							<option value="3"<?php if($jmetc_options['time_limit_this'] == 3) echo ' selected="selected"'; ?>><?php _e('year', 'jmetc'); ?> </option>
						</select>
				</td>			
			</tr>
		
			<tr><td colspan="2" class="tblbreak"></td></tr>
		
			<tr>
				<td valign="top"><h4><?php _e('Widget Format', 'jmetc'); ?>:</h4></td>
				<td>
				<div><div style="float:left;margin:0 20px 0 0;">
					<label for="format1"><input onclick="showColumnfield()" type="radio" id="format1" name="format" value="1"<?php if($jmetc_options['format'] == 1) echo ' checked="checked"'; ?> /> <?php _e('List Style', 'jmetc'); ?><br /><img src="<?php echo JMETC_PLUGINPATH; ?>images/list.png" /></label>
					</div>
					<div style="float:left;">
					<label for="format2"><input onclick="showColumnfield()" type="radio" id="format2" name="format" value="2"<?php if($jmetc_options['format'] == 2) echo ' checked="checked"'; ?> /> <?php _e('Gallery Style with tooltips', 'jmetc'); ?><br /><img src="<?php echo JMETC_PLUGINPATH; ?>images/gallery.png" /></label>
					</div>
					<div style="clear:both;"></div>
				</div>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><div id="jme-columns"><?php _e("Number of columns to display contributors", 'jmetc'); ?>: <?php if($jmetc_options['widget_columns'] == '') $jmetc_options['widget_columns'] = 1; ?>
					<label for="widget_columns"><input style="width:50px;" type="text" id="widget_columns" name="widget_columns" value="<?php echo $jmetc_options['widget_columns']; ?>" /></label><br />
					<label><input type="checkbox" id="keywordluv" name="keywordluv" value="1"<?php if($jmetc_options['keywordluv'] == 1) echo ' checked="checked"'; ?> /> <?php _e('Enable KeywordLuv on user names', 'jmetc'); ?></label>
					
					</div>
				</td>
			</tr>	
			
			<tr>
				<td valign="top"><?php _e('Exclude Users by their Email Address (separate by comma)', 'jmetc'); ?>:</td>
				<td><textarea style="width:400px;height:50px;" id="exclude_author" name="exclude_author"><?php echo htmlspecialchars(stripslashes($jmetc_options['exclude_author'])); ?></textarea></td>
			</tr>
			
			<tr>
				<td width="200"><?php _e("Count Comments By", 'jmetc'); ?>:</td>
				<td><label><input type="radio" id="count_by0" name="count_by" value="0"<?php if($jmetc_options['count_by'] == 0) echo ' checked="checked"'; ?>> <?php _e("User Email Address", 'jmetc'); ?></label> &nbsp; &nbsp; 
					<label><input type="radio" id="count_by1" name="count_by" value="1"<?php if($jmetc_options['count_by'] == 1) echo ' checked="checked"'; ?>> <?php _e("Username",'jmetc'); ?></label>
					<div style="font-size:.8em;padding:3px 0 0 10px;"><?php _e('Use the Username option if users are not required to enter email address when commenting.','jmetc'); ?></div></td>
			</tr>
			<tr>
				<td><?php _e("Link Attribute Options", 'jmetc'); ?>:</td>
				<td><label><input type="radio" id="rel_links0" name="rel_links" value="0"<?php if($jmetc_options['rel_links'] == 0) echo ' checked="checked"'; ?>> <?php _e("None", 'jmetc'); ?></label> &nbsp; &nbsp; 
					<label><input type="radio" id="rel_links1" name="rel_links" value="1"<?php if($jmetc_options['rel_links'] == 1) echo ' checked="checked"'; ?>> rel='nofollow'</label> &nbsp; &nbsp; 
					<label><input type="radio" id="rel_links2" name="rel_links" value="2"<?php if($jmetc_options['rel_links'] == 2) echo ' checked="checked"'; ?>> rel='dofollow'</label>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><div id="jme-ap" style="display:none;"><label><input type="checkbox" id="author_page" name="author_page" value="1"<?php if($jmetc_options['author_page'] == 1) echo ' checked="checked"'; ?> /> <?php _e('Link Authors to Author Page', 'jmetc'); ?></label></div>
				</td>
			</tr>
			
			<tr>
				<td>&nbsp;</td>
				<td><label><input onclick="showCategories()" type="checkbox" id="show_category" name="show_category" value="1"<?php if($jmetc_options['show_category'] == 1) echo ' checked="checked"'; ?> /> <?php _e('Include/Exclude comment/post counts from Categories', 'jmetc'); ?></label>
				</td>
			</tr>
			
			<tr>
				<td>&nbsp;</td>
				<td><div id="jme-category-list" style="display:none;">
						<label><input type="radio" id="cat_inc_exc0" name="cat_inc_exc" value="0"<?php if($jmetc_options['cat_inc_exc'] == 0) echo ' checked="checked"'; ?> /> <?php _e('Include Categories', 'jmetc'); ?>:</label> &nbsp; &nbsp;
						<label><input type="radio" id="cat_inc_exc1" name="cat_inc_exc" value="1"<?php if($jmetc_options['cat_inc_exc'] == 1) echo ' checked="checked"'; ?> /> <?php _e('Exclude Categories', 'jmetc'); ?>:</label><br /><br />
						<table cellspacing="0">
						<tr><?php
							/* get category list */
							$jmevar['categories'] = jme_get_category_list_id();
							$jmevar['count'] = 0;
							foreach($jmevar['categories'] as $cat) {
								if(is_array($jmetc_options['category_list']))
									$checked = (in_array($cat->term_id,$jmetc_options['category_list'])) ? ' checked="checked"' : '';
								echo '<td width="180"><label><input type="checkbox" id="category_id[]" name="category_id[]" value="'.$cat->term_id.'"'.$checked.' /> '.$cat->name.'</label></td>';
								$jmevar['count']++;
								if($jmevar['count'] % 4 == 0) echo '</tr><tr>';
							}
							?>							
						</tr></table>
					</div>				
				</td>
			</tr>			
		</table>
		<p class="submit"><input type="submit" name="save_settings" value="<?php _e('Save Options', 'jmetc'); ?>" /></p>
		</div>
	</div>
	</form>
	
	<form method="post" name="jmetc_icon_options">
	<div class="postbox">
		<h3 class="hndle"><span><?php _e("Top Contributor Icon Options",'jmetc'); ?></span></h3>
		<div class="inside">	

		<table class="tbloptions">	
			<tr>		

				<td width="200" valign="top"><?php _e('Top Contributor Icon', 'jmetc'); ?>:</td>	
				<td><label for="show_icon"><input type="checkbox" id="show_icon" name="show_icon" value="1"<?php if($jmetc_icon['show_icon'] == 1) echo ' checked="checked"'; ?> />
					<?php _e('Show "Top Contributor Icon" next to Username in comments.', 'jmetc'); ?></label><br />
					<?php _e('This option gives your loyal blog followers and contributors some recognition by adding a little icon next to their name in all of their comments.', 'jmetc'); ?><br />
					<?php _e('By default this is a Star, however it can be changed to any Icon you want by uploading the new image to the plugin image directory <code>../plugins/top-contributors/images</code>.', 'jmetc'); ?>
				</td>
			</tr>
			<tr>
				<td><?php _e('Icon Image', 'jmetc'); ?>:</td>
				<td><label for="icon"><input style="width:150px;" type="text" id="icon" name="icon" value="<?php echo htmlentities($jmetc_icon['icon']); ?>" /></label> <img src="<?php echo JMETC_PLUGINPATH; ?>images/<?php echo $jmetc_icon['icon']; ?>" alt="" title="Top Contributor" /></td>
			</tr>
			
			<tr>
				<td valign="top"><?php _e('Comment Threshold', 'jmetc'); ?>:</td>
				<td><input style="width:150px;" type="text" id="comment_limit" name="comment_limit" value="<?php echo $jmetc_icon['comment_limit']; ?>" />
					<br /><?php _e('Use Comment Threshold value to display Icon next to commenters that have X amount of comments or more. Setting to 0 will use default setting of top 10 commenters', 'jmetc'); ?><br /><br />
					<a href="#" onclick="showThresholdInfo();return false;"><?php _e('Advanced Threshold Use', 'jmetc'); ?></a>
					<div id="jme-advanced-threshold" style="display:none;">
						<?php _e('You can assign multiple thresholds for comment counts by separating threshold counts by commas.', 'jmetc'); ?><br />
						<?php _e('For example by entering: "<b>10,30,100</b>", at 10 comments, the user will get 1 star, at 30 comments = 2 stars, and 100 comments = 3 stars.', 'jmetc'); ?><br />
						<?php _e('There is no limit to the number of comment count thresholds you can have.', 'jmetc'); ?>
					</div>
				</td>
			</tr>
		</table>
		
		<p class="submit"><input type="submit" name="save_icon_settings" value="<?php _e('Save Icon Options', 'jmetc'); ?>" /></p>
		</div>
	</div>
	</form>
</div>
</div>
<script type="text/javascript">
	var f = document.forms['jme_options'];
	var t = document.getElementById('jme-category-list');
	var ap = document.getElementById('jme-ap');
	var c = document.getElementById('jme-columns');
	showAuthorSettings();
	showCategories();
	showColumnfield();
</script>
<?php
}

add_action('admin_menu', 'jme_add_options_page');
add_action('widgets_init', 'top_contributors_load_widgets');
add_action('init', 'jme_top_contributors_init');
add_action('wp_head', 'jme_top_contributors_tooltip');

add_filter('get_comment_author_link','jme_tc_icon');

add_action('delete_comment','jmetc_refresh_comment_cache');
add_action('wp_set_comment_status','jmetc_refresh_comment_cache');
add_action('comment_post','jmetc_refresh_comment_cache');

add_action('edit_post', 'jmetc_refresh_author_cache');
add_action('delete_post', 'jmetc_refresh_author_cache');
add_action('publish_post', 'jmetc_refresh_author_cache');



register_activation_hook( __FILE__, jme_tc_activate);
register_deactivation_hook( __FILE__, jme_tc_deactivate);
?>