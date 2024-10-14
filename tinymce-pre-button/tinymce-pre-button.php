<?php
/**
 * @package TinyMCE Pre Button
 * @version 1.0
 */
/*
Plugin Name: TinyMCE Pre Button
Description: Adds the Pre button to the TinyMCE toolbar and the shortcut Ctrl+0 to format text with &lt;pre&gt; tag
Author: mortalis
Version: 1.0
Released under the GPL version 2.0, http://www.gnu.org/licenses/gpl-2.0.html
*/

function mcepre_add_buttons($plugin_array) {
  $plugin_array['preButton'] = plugins_url('mce-pre',__FILE__) . '/plugin.js';
  return $plugin_array;
}

function mcepre_register_buttons($buttons) {
  array_push( $buttons, 'pre');
  return $buttons;
}

function mcepre_buttons() {
  add_filter("mce_external_plugins", "mcepre_add_buttons");
  add_filter('mce_buttons', 'mcepre_register_buttons');
}
add_action( 'init', 'mcepre_buttons' );
