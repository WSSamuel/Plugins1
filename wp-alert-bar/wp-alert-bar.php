<?php
/*
    Plugin Name: WordPress Alert Bar
    Description: Alert Bar Plugin for WordPress
    Version: 1.0.3
    Author: Ryan Bracey
    Author URI: https://www.ryanbracey.com/
*/


defined( 'WPINC' ) || die;

include_once 'admin/mbwpab-customizer-options.php';
include_once 'admin/mbwpab-customizer-styles.php';
include_once 'admin/mbwpab-customizer-scripts.php';
include_once 'public/wp-alert-bar-public.php';

// Enqueue public scripts
add_action( 'wp_enqueue_scripts', 'mbwpab_enqueue_public_assets', 1 );
function mbwpab_enqueue_public_assets() {
    wp_enqueue_style( 'mbwpab-style-css', plugins_url( 'public/css/style.css', __FILE__ ) );
    wp_enqueue_style( 'mbwpab-fontawesome-css', plugins_url( 'public/css/all.css', __FILE__ ) );

    wp_enqueue_script( 'jquery' );
}

// Enqueue admin scripts
add_action( 'customize_controls_print_styles', 'mbwpab_enqueue_customizer_stylesheet' );
function mbwpab_enqueue_customizer_stylesheet() {

    wp_enqueue_style( 'mbwpab-style-css', plugins_url( 'admin/css/customizer.css', __FILE__ ) );

}

// Add settings link
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'mbwpab_add_action_links' );
function mbwpab_add_action_links ( $links ) {
    $mylinks = array(
        '<a href="' . admin_url( '/customize.php?autofocus[panel]=mbwpab_panel' ) . '">Settings</a>',
    );
    return array_merge( $links, $mylinks );
}