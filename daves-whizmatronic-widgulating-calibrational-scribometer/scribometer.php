<?php
/*
  Plugin Name: Dave's Whizmatronic Widgulating Calibrational Scribometer
  Plugin URI: http://davidanaxagoras.com/whizmatronic/
  Description: Dave's Whizmatronic Widgulating Calibrational Scribometer is a widget that allows you to display your writing progress with a simple, adjustable progress meter in your sidebar.
  Author: David Anaxagoras
  Version: 0.3.0
  Author URI: http://davidanaxagoras.com/

  Copyright 2009-2010 David W. Anaxagoras <email: dave@davidanaxagoras.com>. All rights reserved.

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.

 */

//error_reporting(E_ALL);

class daves_scribometer extends WP_Widget {

     function daves_scribometer() {
          parent::WP_Widget(false, $name = 'daves_scribometer');
     }

     function widget($args, $instance) {
          extract($args);

          //kill divide by zero error
          //if (!( $percent_complete == 0 )) {
          $percent_complete = round(( $instance['on_page'] / $instance['total_pages'] ) * 100);
          //	} else return;

          $widget_title = $instance['widget_title'];
          $title = $instance['title'];
          $draft = $instance['draft'];
          $units = $instance['units'];
          $on_page = $instance['on_page'];
          $total_pages = $instance['total_pages'];
          $height = $instance['height'];
          $border_color = $instance['border_color'];
          $background_color = $instance['background_color'];
          $link_love = $instance['link_love'];

          // if the theme's $widget_title uses h3, then make $title h4, otherwise use h3
          //if ($after_title == '</h3>') {
          //  $hS = $instance['h4'];
          //} else {
          //  $hS = $instance['h3'];
          //}
?>

<?php echo $before_widget; ?>

          <div id="scribometer" class="scribometer">

<?php if ($title)
               echo $before_title . $widget_title . $after_title; ?>

          <div class="scribometer-body">

               <!--Title of Work-->
               <h3 class="scribometer-script-title"><?php echo $title; ?></h3>

               <!--Progress Bar-->
               <div class="scribometer-border" style="height: <?php echo $height ?>px; width: 98%; border-width: 1px; border-style: solid; border-color: <?php echo $border_color ?>;">
                    <div class="scribometer-bar" style="height: <?php echo $height ?>px; width: <?php echo $percent_complete ?>%; background-color: <?php echo $background_color ?>;">
                         <!--optional text-->
                    </div><!--END .scribometer_bar-->
               </div><!--END .scribometer_border-->

               <!--Details-->
               <p class="scribometer-draft"><?php echo $draft; ?></p>
               <p class="scribometer-progress"><?php echo $on_page . ' of ' . $total_pages . ' ' . $units . ' (' . $percent_complete . '%) complete'; ?></p>

          </div><!--END .scribometer-body-->

          <!--Link Love-->
<?php if ($link_love == 'yes') { ?>
               <p class="scribometer-link"><?php echo 'Powered by <a href="http://davidanaxagoras.com/whizmatronic/">Dave\'s Scribometer</a>' ?></p>
<?php } else
               ; ?>

     </div><!--END #scribometer-->

<?php echo $after_widget; ?>

<?php
     }

     function update($new_instance, $old_instance) {

          $instance = $old_instance;

          $instance['widget_title'] = strip_tags($new_instance['widget_title']);
          $instance['title'] = strip_tags($new_instance['title']);
          $instance['draft'] = strip_tags($new_instance['draft']);
          $instance['units'] = strip_tags($new_instance['units']);
          $instance['on_page'] = strip_tags($new_instance['on_page']);
          $instance['total_pages'] = strip_tags($new_instance['total_pages']);
          $instance['height'] = strip_tags($new_instance['height']);
          $instance['border_color'] = strip_tags($new_instance['border_color']);
          $instance['background_color'] = strip_tags($new_instance['background_color']);
          $instance['link_love'] = strip_tags($new_instance['link_love']);

          return $instance;
     }

     function form($instance) {

          // Get our options
          $instance = wp_parse_args((array) $instance, array(
                         'widget_title' => 'Dave\'s Whizmatronic Widgulating Calibrational Scribometer',
                         'title' => 'Untitled Project',
                         'draft' => 'First Draft',
                         'units' => 'pages',
                         'on_page' => '0',
                         'total_pages' => '120',
                         'height' => '15',
                         'border_color' => 'black',
                         'background_color' => 'black',
                         'link_love' => 'no'));

          $widget_title = esc_attr($instance['widget_title']);
          $title = esc_attr($instance['title']);
          $draft = esc_attr($instance['draft']);
          $units = esc_attr($instance['units']);
          $on_page = esc_attr($instance['on_page']);
          $total_pages = esc_attr($instance['total_pages']);
          $height = esc_attr($instance['height']);
          $border_color = esc_attr($instance['border_color']);
          $background_color = esc_attr($instance['background_color']);
          $link_love = esc_attr($instance['link_love']);
?>

          <p><label for="<?php echo $this->get_field_id('widget_title'); ?>">
<?php _e('Widget heading:'); ?>
                    <input
                         class="widefat"
                         id="<?php echo $this->get_field_id('widget_title'); ?>"
               name="<?php echo $this->get_field_name('widget_title'); ?>"
               type="text"
               value="<?php echo $widget_title; ?>"
               />
     </label></p>

<p><label for="<?php echo $this->get_field_id('title'); ?>">
<?php _e('Title of work:'); ?>
          <input
               class="widefat"
               id="<?php echo $this->get_field_id('title'); ?>"
               name="<?php echo $this->get_field_name('title'); ?>"
               type="text"
               value="<?php echo $title; ?>"
               />
     </label></p>

<p><label for="<?php echo $this->get_field_id('draft'); ?>">
<?php _e('Project phase:'); ?>
          <input
               class="widefat"
               id="<?php echo $this->get_field_id('draft'); ?>"
               name="<?php echo $this->get_field_name('draft'); ?>"
               type="text"
               value="<?php echo $draft; ?>"
               />
     </label></p>

<p><label for="<?php echo $this->get_field_id('units'); ?>">
<?php _e('Units of measure:'); ?>
          <input
               class="widefat"
               id="<?php echo $this->get_field_id('units'); ?>"
               name="<?php echo $this->get_field_name('units'); ?>"
               type="text"
               value="<?php echo $units; ?>"
               />
     </label></p>

<p><label for="<?php echo $this->get_field_id('on_page'); ?>">
<?php _e('Units complete:'); ?>
          <input
               class="widefat"
               id="<?php echo $this->get_field_id('on_page'); ?>"
               name="<?php echo $this->get_field_name('on_page'); ?>"
               type="text"
               value="<?php echo $on_page; ?>"
               />
     </label></p>

<p><label for="<?php echo $this->get_field_id('total_pages'); ?>">
<?php _e('Total units goal:'); ?>
          <input
               class="widefat"
               id="<?php echo $this->get_field_id('total_pages'); ?>"
               name="<?php echo $this->get_field_name('total_pages'); ?>"
               type="text"
               value="<?php echo $total_pages; ?>"
               />
     </label></p>

<p><label for="<?php echo $this->get_field_id('height'); ?>">
<?php _e('Height of progress meter in pixels:'); ?>
          <input
               class="widefat"
               id="<?php echo $this->get_field_id('height'); ?>"
               name="<?php echo $this->get_field_name('height'); ?>"
               type="text"
               value="<?php echo $height; ?>"
               />
     </label></p>

<p><label for="<?php echo $this->get_field_id('border_color'); ?>">
<?php _e('Color of progress meter border:'); ?>
          <input
               class="widefat"
               id="<?php echo $this->get_field_id('border_color'); ?>"
               name="<?php echo $this->get_field_name('border_color'); ?>"
               type="text"
               value="<?php echo $border_color; ?>"
               />
     </label></p>

<p><label for="<?php echo $this->get_field_id('background_color'); ?>">
<?php _e('Color of progress meter bar:'); ?>
          <input
               class="widefat"
               id="<?php echo $this->get_field_id('background_color'); ?>"
               name="<?php echo $this->get_field_name('background_color'); ?>"
               type="text"
               value="<?php echo $background_color; ?>"
               />
     </label></p>

<p><label for="<?php echo $this->get_field_id('link_love'); ?>">
<?php _e('Display a link to this plugin?'); ?>
          <input
               class="widefat"
               name="<?php echo $this->get_field_name('link_love'); ?>"
               type="radio"
               value="no" checked
               /> <?php _e('No'); ?>
          <input
               class="widefat"
               name="<?php echo $this->get_field_name('link_love'); ?>"
               type="radio"
               value="yes"
               /> <?php _e('Yes'); ?>
     </label></p>

<?php
     }

}

add_action('widgets_init', create_function('', 'return register_widget("daves_scribometer");'));
?>