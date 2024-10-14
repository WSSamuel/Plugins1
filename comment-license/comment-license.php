<?php

// Comment License
//
// Copyright (c) 2006-2007 Alex King
// http://alexking.org/projects/wordpress
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// *****************************************************************

/*
Plugin Name: Comment License
Plugin URI: http://alexking.org/projects/wordpress
Description: Show license terms for your comments form. <a href="options-general.php?page=comment-license.php">Edit your license terms here.</a>
Author: Alex King
Author URI: http://alexking.org
Version: 1.4.1
*/

function akcl_show_license()
{
  $text = get_option('comment-license');
  if (!empty($text)) {
    print('<p class="comment_license">' . esc_html($text) . '</p>');
  }
}

add_action('comment_form', 'akcl_show_license', 99);

function akcl_options_form()
{
  ?>
  <div class="wrap">
    <h2>
      <?php
      esc_html_e('Comment License Options', 'comment-license');
      ?>
    </h2>
    <form id="ak_commentlicense" name="ak_commentlicense" action="options.php" method="post">
      <?php
      settings_fields('comment-license');
      do_settings_sections('comment-license');
      submit_button(esc_html__('Update Comment License', 'comment-license'));
      ?>
    </form>
    <p>
      This plugin was originally created by <a href="https://alexking.org/projects/wordpress/readme?project=comment-license" target="_blank">Alex King</a> and is currently maintained by <a href="https://crowdfavorite.com" target="_blank">Crowd Favorite</a>.
    </p>
  </div>
  <?php
}

function akcl_menu_items()
{
  add_options_page(
    esc_html__('Comment License', 'comment-license'),
    esc_html__('Comment License', 'comment-license'),
    'manage_options',
    basename(__FILE__),
    'akcl_options_form'
  );
}

add_action('admin_menu', 'akcl_menu_items');

add_action('admin_init', 'comment_license_settings_init');

function comment_license_settings_init()
{
  add_settings_section(
    'comment-license',
    '',
    '',
    'comment-license'
  );

  add_settings_field(
    'comment-license',
    esc_html__('Comment License', 'comment-license'),
    'comment_license_markup',
    'comment-license',
    'comment-license'
  );

  register_setting('comment-license', 'comment-license');
}

function comment_license_markup()
{
  ?>
  <textarea
    cols="45"
    rows="5"
    name="comment-license"
    id="comment-license"
  ><?php
    echo esc_html(get_option('comment-license')); ?></textarea>
  <?php
}
