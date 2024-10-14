<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if (isset($_POST['tme_countdown_option'])) {
	$retrieved_nonce = $_POST['_wpnonce'];
	if (wp_verify_nonce($retrieved_nonce, 'tmecountdown_setting')) {
		$tme_countdown_data = shortcode_atts( array(
		    'day_t' => 'Days',
        'hours_t' => 'Hours',
        'minutes_t' => 'Minutes',
        'seconds_t' => 'Seconds',
        'zero_t' => "0",
        'one_t' => "1",
        'two_t' => "2",
        'three_t' => "3",
        'four_t' => "4",
        'five_t' => "5",
        'six_t' => "6",
        'seven_t' => "7",
        'eight_t' => "8",
        'nine_t' => "9",
		  ), $_POST );

		if ( $wpdb->get_var('SHOW TABLES LIKE "' . tme_COUNT_TABLE_NAME . '"') == tme_COUNT_TABLE_NAME ) {
			$sql = "TRUNCATE `". tme_COUNT_TABLE_NAME . "`;";
			$wpdb->query($sql);


			$sql = "INSERT INTO ". tme_COUNT_TABLE_NAME . " ";
		    $sql .= "(`name`, `value`) VALUES";
		    $sql .= "('day_t', '".sanitize_text_field($tme_countdown_data['day_t'])."'),";
		    $sql .= "('hours_t', '".sanitize_text_field($tme_countdown_data['hours_t'])."'),";
		    $sql .= "('minutes_t', '".sanitize_text_field($tme_countdown_data['minutes_t'])."'),";
		    $sql .= "('seconds_t', '".sanitize_text_field($tme_countdown_data['seconds_t'])."'),";
		    $sql .= "('zero_t', '".sanitize_text_field($tme_countdown_data['zero_t'])."'),";
		    $sql .= "('one_t', '".sanitize_text_field($tme_countdown_data['one_t'])."'),";
		    $sql .= "('two_t', '".sanitize_text_field($tme_countdown_data['two_t'])."'),";
		    $sql .= "('three_t', '".sanitize_text_field($tme_countdown_data['three_t'])."'),";
		    $sql .= "('four_t', '".sanitize_text_field($tme_countdown_data['four_t'])."'),";
		    $sql .= "('five_t', '".sanitize_text_field($tme_countdown_data['five_t'])."'),";
		    $sql .= "('six_t', '".sanitize_text_field($tme_countdown_data['six_t'])."'),";
		    $sql .= "('seven_t', '".sanitize_text_field($tme_countdown_data['seven_t'])."'),";
		    $sql .= "('eight_t', '".sanitize_text_field($tme_countdown_data['eight_t'])."'),";
		    $sql .= "('nine_t', '".sanitize_text_field($tme_countdown_data['nine_t'])."')";
		    $sql .= ";";
		    $wpdb->query($sql);

		}
		
	}
}


function tme_countdown_setting(){
	global $wpdb;
$tme_countdown_data_r = $wpdb->get_results("SELECT * FROM `".tme_COUNT_TABLE_NAME."`;",ARRAY_A);
$tme_countdown_data = array();
foreach ($tme_countdown_data_r as $value) {
	if (isset($value['name']) && isset($value['value'])) {
		$tme_countdown_data[$value['name']] = $value['value'];
	}
	
}
$tme_countdown_data = shortcode_atts( array(
    'day_t' => 'Days',
    'hours_t' => 'Hours',
    'minutes_t' => 'Minutes',
    'seconds_t' => 'Seconds',
    'zero_t' => "0",
    'one_t' => "1",
    'two_t' => "2",
    'three_t' => "3",
    'four_t' => "4",
    'five_t' => "5",
    'six_t' => "6",
    'seven_t' => "7",
    'eight_t' => "8",
    'nine_t' => "9",
  ), $tme_countdown_data );
return $tme_countdown_data;
}


function tme_countdown_update_query($sql){
	global $wpdb;
	$reault = $wpdb->query($sql);
	return true;
}




function tme_countdown_activation_hook(){
	global $wpdb;
	if ( $wpdb->get_var('SHOW TABLES LIKE "' . tme_COUNT_TABLE_NAME . '"') != tme_COUNT_TABLE_NAME ) {
		$sql = "CREATE TABLE IF NOT EXISTS `". tme_COUNT_TABLE_NAME . "` (";
		$sql .= "`name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,";
		$sql .= "`value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL";
		$sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		$wpdb->query($sql);


    $sql = "INSERT INTO ". tme_COUNT_TABLE_NAME . " ";
    $sql .= "(`name`, `value`) VALUES";
    $sql .= "('day_t', 'Days'),";
    $sql .= "('hours_t', 'Hours'),";
    $sql .= "('minutes_t', 'Minutes'),";
    $sql .= "('seconds_t', 'Seconds'),";
    $sql .= "('zero_t', 0),";
    $sql .= "('one_t', 1),";
    $sql .= "('two_t', 2),";
    $sql .= "('three_t', 3),";
    $sql .= "('four_t', 4),";
    $sql .= "('five_t', 5),";
    $sql .= "('six_t', 6),";
    $sql .= "('seven_t', 7),";
    $sql .= "('eight_t', 8),";
    $sql .= "('nine_t', 9)";
    $sql .= ";";
    $wpdb->query($sql);


	}
}

?>