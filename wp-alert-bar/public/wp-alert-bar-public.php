<?php

/**
 * This file builds the functionality of the alert bar
 */

// Hook alert bar
add_action( 'wp_head', 'mbwpab_page_display', 99 );
function mbwpab_page_display() {

    if ( ( ( get_option( 'alert_display', 'home-page' ) == 'home-page' ) && is_front_page() ) || ( get_option( 'alert_display', 'full-site' ) == 'full-site' ) ) {
        mbwpab_alert_bar_markup();
    }

}

// Build alert bar
function mbwpab_alert_bar_markup() {

    if ( true === get_theme_mod( 'alert_close_display' ) ) {
        add_action( 'wp_footer', 'mbwpab_closer_script' );
    }

    ?>
        <div class="mbwpab-alert-bar<?php if ( true === get_theme_mod( 'alert_close_display' ) ) { echo ' mbwpab-alert-bar-has-close'; }?>">
            <div class="wrap">
                <p class="mbwpab-alert-message">
                    <?php if ( get_option( 'title' ) ) { ?>
                        <span class="mbwpab-alert-title"><?php echo get_option( 'title' ); ?></span><span class="mbwpab-alert-title-sep">:</span>
                    <?php } ?>
                    <?php if ( get_option( 'message' ) ) { ?>
                        <span class="mbwpab-alert-message"><?php echo get_option( 'message' ); ?></span>
                    <?php } ?>  
                    <?php if ( get_option( 'cta' ) ) { ?>
                        <span class="mbwpab-alert-cta-sep">-</span> <a href="<?php echo get_option( 'cta_link' ); ?>"<?php if ( true === get_theme_mod( 'cta_target_blank' ) ) { echo ' target="_blank"'; }?> class="mbwpab-alert-cta"><?php echo get_option( 'cta' ); ?></a>
                    <?php } ?> 
                </p>
                <?php if ( true === get_theme_mod( 'alert_close_display' ) ) { ?>
                    <div class="mbwpab-alert-closer"><i class="fas fa-times"></i></div>
                <?php } ?> 
            </div>
        </div>
    <?php
}

// Add alert body class
add_filter( 'body_class', 'mbwpab_add_body_class' );
function mbwpab_add_body_class( $classes ) {

    if ( ( ( get_option( 'alert_display', 'home-page' ) == 'home-page' ) && is_front_page() ) || ( get_option( 'alert_display', 'full-site' ) == 'full-site' ) ) {
        $classes[] = 'mbwpab-alert-bar-active';
    }

    return $classes;

}