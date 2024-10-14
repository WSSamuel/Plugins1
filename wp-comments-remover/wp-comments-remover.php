<?php
/*
Plugin Name: WP Comments Remover
Plugin URI: http://darklich.com/wp-comments-remover/
Description: A small plug-in to remove pending comments using a search keyword.
Version: 1.0.0.0
Author: Ram Shmider
Author URI: http://darklich.com
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*
Todo: Add function description.
*/
function darklich_get_comments_count_by_kw($theKw){	
	global $wpdb;
	$theKwClean = esc_sql($theKw);
	$query1 = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = 0 AND comment_content LIKE '%$theKwClean%'";
	$iResult =  $wpdb->get_var( $query1);
	return $iResult;
}
/*
Todo: Add function description.
*/
function darklich_del_comments_by_kw($theKw){	
	global $wpdb;
	$theKwClean = esc_sql($theKw);
	$query2 = "DELETE FROM $wpdb->comments WHERE comment_approved = 0 AND comment_content LIKE '%$theKwClean%'";
	$iResult = $wpdb->query( $wpdb->prepare( $query2) );
	return $iResult;
}
/*
Todo: Add function description.
*/
function darklich_del_all_pending_comments(){
	global $wpdb;
	$query3 = "DELETE FROM $wpdb->comments WHERE comment_approved = 0";
	$iResult = $wpdb->query($wpdb->prepare( $query3));	
	return $iResult;
}
/*
Todo: Add function description.
*/
function darklich_wp_comments_remover(){
	/*Empty for future use track keyword with db*/
}
/*
Todo: Add function description.
*/
function darklich_wp_comments_remover_add_css(){ 
	$plugin_url = plugin_dir_url( __FILE__ );

    wp_enqueue_style( 'darklich_wpcr_style', $plugin_url . '/css/wpcr.css' );
}
/*
Todo: Add function description.
*/
function darklich_wp_comments_remover_admin(){
	$page = add_submenu_page( 'edit-comments.php', __( 'WP Comments Remover', 'darklich_wp_comments_remover' ), __( 'WP Comments Remover', 'darklich_wp_comments_remover' ), 10, 'darklich_wp_comments_remover', 'darklich_wp_comments_remover_admin_page' );
	add_action( 'admin_head-' . $page, 'darklich_wp_comments_remover_add_css' );
}
/*
Todo: Add function description.
*/
function darklich_get_comments_total(){
	global $wpdb;
	$query1 = "SELECT COUNT(*) FROM $wpdb->comments";
	$iResult1 =  $wpdb->get_var( $query1);
	
	$query2 = "SELECT COUNT(*) FROM $wpdb->comments where comment_approved=0";
	$iResult2 =  $wpdb->get_var( $query2);
	
	$query3 = "SELECT COUNT(*) FROM $wpdb->comments where comment_approved=1";
	$iResult3 =  $wpdb->get_var( $query3);
	
	$query4 = "SELECT COUNT(*) FROM $wpdb->comments where comment_approved='trash'";
	$iResult4 =  $wpdb->get_var( $query4);
	
	$query5 = "SELECT COUNT(*) FROM $wpdb->comments where comment_approved='spam'";
	$iResult5 =  $wpdb->get_var( $query5);
	
	$msgResult = "$iResult1 [ <strong>Approved:</strong> $iResult3, <strong>Pending :</strong> $iResult2, <strong>Spam:</strong> $iResult5, <strong>Trash:</strong> $iResult4 ]";
	return $msgResult;	
}
/*
Todo: Add function description.
*/
function darklich_wp_comments_remover_admin_page(){
	$msgInfo = '';
?>
	<div class="wrap" >
<?php	
		
		if ( $_POST["btnTest"] ) {
			if(strlen($_POST["kwSearch"]) > 0){
				$msgInfo = "Found ".darklich_get_comments_count_by_kw(darklich_wp_comments_remover_clean($_POST["kwSearch"]))." comments contain ".darklich_wp_comments_remover_clean($_POST["kwSearch"]).".";
			}
			else
			{
				$msgInfo =  "Please enter a search term.";
			}
		}
		
		if ( $_POST['btnRemove'] ) {
			if(strlen($_POST["kwSearch"]) > 0){
				$msgInfo = "Remove ".darklich_del_comments_by_kw(darklich_wp_comments_remover_clean($_POST["kwSearch"]))." comments contain ".darklich_wp_comments_remover_clean($_POST["kwSearch"]).".";
			}	
			else
			{
				$msgInfo =  "Please enter a search term.";
			}
		}
			
		if ( $_POST['btnRemoveAll'] ) {
			$msgInfo = "All pending comments removes (".darklich_del_all_pending_comments().")"; 
			}	
?>	
	
		<h2>WP Comments Remover</h2>
		<div>
			A small plug-in to remove <strong>pending</strong> comments base on given keywords.
			<br/>
			<strong>Please Note:</strong> <br/>Once removed there is no undo!<br/>It also remove commands in trash!
			<br/>			
			<UL>
			<LI><strong>Test:</strong> Show you count of comments with the selected keyword.</LI>
			<LI><strong>Remove:</strong> Remove comments with the selected keyword.</LI>
			<LI><strong>Remove All Pending Comments:</strong> Remove all pending comments.</LI>
			</UL>
			<br/>
		</div>
		<div>
			<br/>
			<form action="" method="post">
				<label for="kwSearch">Search Term:</label>
				<input name="kwSearch" type="text" size="80" >
				<br/>
				<label for="kwInfo">Information:</label>
				<div name="kwInfo" id="kwInfo"> <?php echo $msgInfo;?> </div>
				<div><br/>Total comments found: <?php echo darklich_get_comments_total();?></div>
				<div class="submit">
					<input type="submit" name="btnTest" id="btnTest" value="Test" style="background:#0085ba;border-color:#0073aa #006799 #006799;box-shadow:0 1px 0 #006799;color:#fff;text-decoration:none;text-shadow:0 -1px 1px #006799,1px 0 1px #006799,0 1px 1px #006799,-1px 0 1px #006799;">
					<input type="submit" name ="btnRemove" id="btnRemove" value="Remove" style="background:#0085ba;border-color:#0073aa #006799 #006799;box-shadow:0 1px 0 #006799;color:#fff;text-decoration:none;text-shadow:0 -1px 1px #006799,1px 0 1px #006799,0 1px 1px #006799,-1px 0 1px #006799;">
					<input type="submit" name ="btnRemoveAll" id="btnRemoveAll" value="Remove All Pending Comments" style="background:#0085ba;border-color:#0073aa #006799 #006799;box-shadow:0 1px 0 #006799;color:#fff;text-decoration:none;text-shadow:0 -1px 1px #006799,1px 0 1px #006799,0 1px 1px #006799,-1px 0 1px #006799;">
				</div>
			</form>
		</div>
		<div class="examplekw">
			<a href="#hide1" class="hide" id="hide1">+</a>
			<a href="#show1" class="show" id="show1">-</a>
			<div class="question">Example of keyword to delete in your db (include in trash):</div>
			<div class="list">
				<table>
					<tr><th>Keyword</th><th>Count</th></tr>					
					<tr><td>cialis</td><td><?php echo darklich_get_comments_count_by_kw('cialis'); ?></td></tr>
					<tr><td>viagra</td><td><?php echo darklich_get_comments_count_by_kw('viagra'); ?></td></tr>
					<tr><td>loan</td><td><?php echo darklich_get_comments_count_by_kw('loan'); ?></td></tr>
					<tr><td>porn</td><td><?php echo darklich_get_comments_count_by_kw('porn'); ?></td></tr>
					<tr><td>adult</td><td><?php echo darklich_get_comments_count_by_kw('adult'); ?></td></tr>
					<tr><td>erotic</td><td><?php echo darklich_get_comments_count_by_kw('erotic'); ?></td></tr>
					<tr><td>sex</td><td><?php echo darklich_get_comments_count_by_kw('sex'); ?></td></tr>
					<tr><td>xxx</td><td><?php echo darklich_get_comments_count_by_kw('xxx'); ?></td></tr>
				</table>
			</div>		
		</div>
	</div>
<?php	
}
/*
Todo: Add function description.
*/
function darklich_wp_comments_remover_clean($text){
	
  $text = str_replace("&", "&amp;", $text);
  $text = str_replace("\"", "&quot;", $text);
  $text = str_replace("'", "", $text);
  $text = str_replace("`", "", $text);
  return trim(strip_tags($text));
}
/*
Todo: Add function description.
*/
function darklich_wp_comments_remover_init(){
	if ( is_admin() ) {
			add_action( 'init', 'darklich_wp_comments_remover' );
			add_action( 'admin_menu', 'darklich_wp_comments_remover_admin' );
		}

}

darklich_wp_comments_remover_init();
?>