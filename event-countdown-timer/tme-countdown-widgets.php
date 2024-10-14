<?php
class tme_countdown extends WP_Widget{

	function __construct(){
		$paramitter=array(
		'description' => __('Display your event Countdown', 'tme-countdown'), //plugin description
		'name' => 'Event Countdown by TechMix'  //title of plugin
		);
parent::__construct('tme_countdown', '', $paramitter);
  }
  // extract($instance);

  public function form($instance)  {
    global $default_setting;
  $instance = wp_parse_args( (array) $instance, $default_setting );

  ?>

  <div><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" /></label></div>

  <div><label for="<?php echo $this->get_field_id('img_link'); ?>">Image link: <input class="widefat" id="<?php echo $this->get_field_id('img_link'); ?>" name="<?php echo $this->get_field_name('img_link'); ?>" type="text" value="<?php echo esc_attr($instance['img_link']); ?>" /></label></div>
    <div><label for="<?php echo $this->get_field_id('background_color'); ?>">Background-color: <input class="widefat" id="<?php echo $this->get_field_id('background_color'); ?>" name="<?php echo $this->get_field_name('background_color'); ?>" type="color" value="<?php echo esc_attr($instance['background_color']); ?>" /></label></div>
<div><label for="<?php echo $this->get_field_id('time_box_color'); ?>">Time box color: <input class="widefat" id="<?php echo $this->get_field_id('time_box_color'); ?>" name="<?php echo $this->get_field_name('time_box_color'); ?>" type="color" value="<?php echo esc_attr($instance['time_box_color']); ?>" /></label></div>

<div><label for="<?php echo $this->get_field_id('time_text_color'); ?>">Time text color: <input class="widefat" id="<?php echo $this->get_field_id('time_text_color'); ?>" name="<?php echo $this->get_field_name('time_text_color'); ?>" type="color" value="<?php echo esc_attr($instance['time_text_color']); ?>" /></label></div>
<div><label for="<?php echo $this->get_field_id('time_title_color'); ?>">Time title color: <input class="widefat" id="<?php echo $this->get_field_id('time_title_color'); ?>" name="<?php echo $this->get_field_name('time_title_color'); ?>" type="color" value="<?php echo esc_attr($instance['time_title_color']); ?>" /></label></div>


<div><label for="<?php echo $this->get_field_id('countdown_datetime'); ?>">Countdown datetime: <input placeholder="yyyy/mm/dd" class="widefat w-tme-datetime" id="<?php echo $this->get_field_id('countdown_datetime'); ?>" name="<?php echo $this->get_field_name('countdown_datetime'); ?>" type="text" requeired value="<?php echo esc_attr($instance['countdown_datetime']); ?>" /></label></div>

<div><label for="<?php echo $this->get_field_id('countdown_timezone'); ?>">Select timezone:
<select name="<?php echo $this->get_field_name('countdown_timezone'); ?>">
  <?php
    $tme_time_zone_list = timezone_identifiers_list();
    $tme_default_time_zone = $instance['countdown_timezone'];
    $select = "";
    foreach ($tme_time_zone_list as $value) {
      $select .='<option value="'.$value.'"';
            $select .= ($value == $tme_default_time_zone ? ' selected' : '');
            $select .= '>'.$value.'</option>';
    }
    echo $select;
  ?>
</select>

</label></div>


  <div>Please go to <a href="options-general.php?page=tmecountdown_options">Settings -> tme Countdown</a> to default configure </div>

  <div><a href="https://techmix.xyz/" target="_blank">Techmix.xyz</a></div>
  <?php

  }







		
	
	public function widget($args, $instance){
    if (isset($instance["countdown_datetime"])) {
      echo $args['before_widget'];
      echo tme_add_countdown($instance);
      echo $args['after_widget'];
    }
		
	}
}