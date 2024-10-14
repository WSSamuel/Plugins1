<?php
if (!current_user_can('administrator'))  {
	wp_die( __('You do not have sufficient permissions to accessconis page.', 'tme-countdown') );
}



$tme_countdown_data = tme_countdown_setting();
?>

<div class="wrap">
	<div id="icon-options-general" class="icon32"></div>
    <h2><?php _e('Plugin Options tme Countdown', 'tme-countdown')?></h2><br/>
    <div class="tmec_plugins_wrap"><!-- start mvc wrap -->
	<div class="tmec_right_sidebar"><!-- start right sidebar -->
    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" class="tme_plugin_main_form">
		<div class="tmec_plugins_text">
        	<div class="tmec_option_wrap">
				<h3 class="hndle">Set your number placeholder</h3>
				<div><font size="2">This is your language-based number zero to nine, default is english(0-9)</font></div>
				<div><label for="">Zero: </label><input class="widefat" id="" name="zero_t" type="text" value="<?php echo _e($tme_countdown_data['zero_t'],"tme-countdown")?>"></div>
				<div><label for="">One: </label><input class="widefat" id="" name="one_t" type="text" value="<?php echo _e($tme_countdown_data['one_t'],"tme-countdown")?>"></div>
				<div><label for="">Two: </label><input class="widefat" id="" name="two_t" type="text" value="<?php echo _e($tme_countdown_data['two_t'],"tme-countdown")?>"></div>
				<div><label for="">Three: </label><input class="widefat" id="" name="three_t" type="text" value="<?php echo _e($tme_countdown_data['three_t'],"tme-countdown")?>"></div>
				<div><label for="">Four: </label><input class="widefat" id="" name="four_t" type="text" value="<?php echo _e($tme_countdown_data['four_t'],"tme-countdown")?>"></div>
				<div><label for="">Five: </label><input class="widefat" id="" name="five_t" type="text" value="<?php echo _e($tme_countdown_data['five_t'],"tme-countdown")?>"></div>
				<div><label for="">Six: </label><input class="widefat" id="" name="six_t" type="text" value="<?php echo _e($tme_countdown_data['six_t'],"tme-countdown")?>"></div>
				<div><label for="">Seven: </label><input class="widefat" id="" name="seven_t" type="text" value="<?php echo _e($tme_countdown_data['seven_t'],"tme-countdown")?>"></div>

				<div><label for="">Eight: </label><input class="widefat" id="" name="eight_t" type="text" value="<?php echo _e($tme_countdown_data['eight_t'],"tme-countdown")?>"></div>
				<div><label for="">Nine: </label><input class="widefat" id="" name="nine_t" type="text" value="<?php echo _e($tme_countdown_data['nine_t'],"tme-countdown")?>"></div>
				<h3 style="margin-top: 30px;" class="hndle">Set your time slot placeholder</h3>
				<div><font size="2">This is your language-based time slot(Days, Hours etc) placeholder, default is english(Days, Hours, Minutes, Seconds</div>
				<div><label for="">Days: </label><input class="widefat" id="" name="day_t" type="text" value="<?php echo _e($tme_countdown_data['day_t'],"tme-countdown")?>"></div>
				<div><label for="">Hours: </label><input class="widefat" id="" name="hours_t" type="text" value="<?php echo _e($tme_countdown_data['hours_t'],"tme-countdown")?>"></div>
				<div><label for="">Minutes: </label><input class="widefat" id="" name="minutes_t" type="text" value="<?php echo _e($tme_countdown_data['minutes_t'],"tme-countdown")?>"></div>
				<div><label for="">Seconds: </label><input class="widefat" id="" name="seconds_t" type="text" value="<?php echo _e($tme_countdown_data['seconds_t'],"tme-countdown")?>"></div>
				<p style="margin-top:20px;">
        		<input type="submit" name="tme_countdown_option" class="button-primary" value="Save Changes">
        		</p>
            <?php wp_nonce_field('tmecountdown_setting'); ?>
			</div>
		</div>
    </form>
    </div><!-- End Right sidebar -->




    <div class="tmec_left_sidebar"><!-- start Left sidebar -->
		<div class="tmec_plugins_text">
        	<div class="tmec_option_wrap">
        		<?php
        			if (isset($_POST['tme_countdown_generate_shortcode']) && isset($_POST['widget-tme_countdown_countdown_datetime'])) { 
        				?>
        				<h3 class="hndle">Copy this shortcode and place it whare you need</h3>
        				<textarea style="width: 100%; height: 150px;">[tme_countdown title="<?php echo esc_attr($_POST['widget-tme_countdown_title']);?>" img_link="<?php echo esc_attr($_POST['widget-tme_countdown_img_link']);?>" background_color="<?php echo esc_attr($_POST['widget-tme_countdown_background_color']);?>" time_box_color="<?php echo esc_attr($_POST['widget-tme_countdown_time_box_color']);?>" time_text_color="<?php echo esc_attr($_POST['widget-tme_countdown_time_text_color']);?>" time_title_color="<?php echo esc_attr($_POST['widget-tme_countdown_time_title_color']);?>" countdown_datetime="<?php echo $_POST['widget-tme_countdown_countdown_datetime'];?>" countdown_timezone="<?php echo $_POST['widget-tme_countdown_countdown_timezone'];?>"]</textarea>
        				<p style="margin-bottom: 30px"></p>

        		<?php	}

        		global $default_setting;
        		echo "</pre>";
        		?>
				<h3 class="hndle">Gnenerate Shortcode by fill this form as your need</h3>
				<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" class="tme_plugin_main_form">
  <div><label for="">Title: </label><input class="widefat" id="" name="widget-tme_countdown_title" type="text" value="<?php echo $default_setting['title'];?>"></div>

  <div><label for="">Image link: </label><input class="widefat" id="" name="widget-tme_countdown_img_link" type="text" value="<?php echo $default_setting['img_link'];?>" ></div>
  <?php
wp_enqueue_script('wp-color-picker');
wp_enqueue_style( 'wp-color-picker' );
?>
    <div><label for="">Background-color: </label><input class="widefat" id="widget-tme_countdown_background_color" name="widget-tme_countdown_background_color" type="color" value="<?php echo $default_setting['background_color'];?>"></div>
<div><label for="">Time box color:</label> <input class="widefat" id="widget-tme_countdown_time_box_color" name="widget-tme_countdown_time_box_color" type="color" value="<?php echo $default_setting['time_box_color'];?>"></div>

<div><label for="">Time text color: </label><input class="widefat" id="widget-tme_countdown_time_text_color" name="widget-tme_countdown_time_text_color" type="color" value="<?php echo $default_setting['time_text_color'];?>"></div>
<div><label for="">Time title color: </label><input class="widefat" id="widget-tme_countdown_time_title_color" name="widget-tme_countdown_time_title_color" type="color" value="<?php echo $default_setting['time_title_color'];?>"></div>
<script type="text/javascript">
				jQuery(document).ready(function($) {   
					$('#widget-tme_countdown_background_color').wpColorPicker();
					$('#widget-tme_countdown_time_box_color').wpColorPicker();
					$('#widget-tme_countdown_time_text_color').wpColorPicker();
					$('#widget-tme_countdown_time_title_color').wpColorPicker();
				});             
				</script>
		
<div><label for="">Select date and time: </label><input type="text" class="tme-datetime" required="" name="widget-tme_countdown_countdown_datetime" placeholder="yyyy/mm/dd hh:mm"></div>
<div><label for="">Select timezone: </label>
<select name="widget-tme_countdown_countdown_timezone">
	<?php
		$tme_time_zone_list = timezone_identifiers_list();
		$tme_default_time_zone = $default_setting['countdown_timezone'];
		$select = "";
		foreach ($tme_time_zone_list as $value) {
			$select .='<option value="'.$value.'"';
            $select .= ($value == $tme_default_time_zone ? ' selected' : '');
            $select .= '>'.$value.'</option>';
		}
		echo $select;
	?>
</select>
</div>
<p style="margin-top:20px;"><input type="submit" name="tme_countdown_generate_shortcode" class="button-primary" value="Generate shortcode"></p>
</form>
		</div>
	</div><!-- End Left sidebar -->
	</div><!-- End mvc wrap -->
</div>
