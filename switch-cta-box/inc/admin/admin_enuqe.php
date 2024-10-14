<?php
function wppw_cttabox_adding_admin_cta_box_stylesheet() {
    wp_register_style(
        'newstyleadmin',
        plugins_url( 'css/cta_admin_style.css', __FILE__ )
    );
    wp_enqueue_style( 'newstyleadmin' );
}
add_action( 'admin_enqueue_scripts', 'wppw_cttabox_adding_admin_cta_box_stylesheet' );
require_once ('admin_modify.php');

add_action( 'admin_print_scripts-post-new.php', 'wppw_cttabox_ctabox_admin_script', 11 );
add_action( 'admin_print_scripts-post.php', 'wppw_cttabox_ctabox_admin_script', 11 );

function wppw_cttabox_ctabox_admin_script() {
    global $post_type;
    if( 'ctabox' == $post_type )
    wp_enqueue_script( 'portfolio-admin-script',  plugins_url( 'js/cta_boxadmin.js', __FILE__ ) );
}