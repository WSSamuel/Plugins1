<?php
/*
Plugin Name: OZ Canonical
Plugin URI: http://coffebreak.info
Description: OZ Canonical is a plugin which helps you to edit the canonical attribute easily and fast on all of your blog's pages.
Version: 0.5
Author: Andon Ivanov
Author URI: http://coffebreak.info/
*/

add_action('admin_menu', 'oz_menu');
function oz_menu() {
  add_menu_page(__('OZ Canonical Settings'), __('OZ Cannonical'), 'manage_options', 'oz_menu', 'oz_opt_panel', ''); 
}

function oz_opt_panel(){
	$new_domain_url = get_option('oz_ndu');

	?>
	<div class="wrap">
	<h2>OZ Cannonical</h2>
	<p><?php _e('To define a new canonical address to all of your blog\'s pages you need to type the address of your new domain (ex. http://coffebreak.info) and then just save the settings.') ?></p>
	<form action="" method="post">
	<?php
	if(!empty($_POST['submit'])){
		update_option('oz_ndu', $_POST['oz_ndu']);
		$new_domain_url = $_POST['oz_ndu'];
	}
	?>
	<table class="form-table">
	<tbody>
	<tr valign="top">
	<th scope="row">
	<label for="oz_ndu">New Canonical URL:</label>
	</th>
	<td>
	<input type="text" size="60" name="oz_ndu" value="<?php echo $new_domain_url; ?>">
	<p class="description"><?php _e('If you leave a blank field, it is going to use a default settings.') ?></p>
	</td>
		</tr>
	</tbody>
	</table>
	<p><input type="submit" name="submit" value="<?php _e('Save Changes') ?>" /></p>
	</form>

	</div>
	<?php
}

function oz_canonical(){
	global $wp;
	$wp_current_url = add_query_arg( $wp->query_string, '', home_url('/'. $wp->request ) );
	$wp_change_url = str_replace(home_url(), get_option('oz_ndu'), $wp_current_url);
	$new_dom = get_option('oz_ndu');
	if(!empty($new_dom)) { $wp_current_url = $wp_change_url; }
	
	echo '<link rel="canonical" href="'.$wp_current_url.'" />';
	
}
remove_action( 'wp_head', 'rel_canonical' );
remove_filter('template_redirect', 'redirect_canonical');
add_filter('wp_head', 'oz_canonical');
?>