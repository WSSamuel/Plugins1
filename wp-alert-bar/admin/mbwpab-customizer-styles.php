<?php

/**
 * This file adds customized style overrides
 */

// Set alert bar background color
add_action( 'wp_head', 'mbwpab_index_css_styles', 100 );
function mbwpab_index_css_styles() {
    ?>
        <style type="text/css">
            .mbwpab-alert-bar {
                background: <?php echo get_option( 'background', '#F8F0CE' ); ?>;
                border-bottom: 1px solid <?php echo get_option( 'border', '#DEB408' ); ?>;
                color: <?php echo get_option( 'text_color', '#444' ); ?>;
                <?php echo ( get_option( 'font_size' ) ? 'font-size: ' . get_option( 'font_size', '' ) . 'px;' : '' ); ?> 
            }

            .mbwpab-alert-bar a {
                color: <?php echo get_option( 'link_color', '#CD2653' ); ?>;;
            }

            .mbwpab-alert-bar a:hover {
                color: <?php echo get_option( 'link_hover_color', '#8e0b2e' ); ?>;;
            }
        </style>
    <?php
}