<?php
/**
 * Enqueue Scripts
 *
 * @since 1.0
 * @return void
 */
function edd_keep_addtocart_enqueue(){
	
	wp_enqueue_script( 'edd_keep_addtocart_js', plugins_url('js/edd-keep-addtocart.js', dirname(__FILE__) ), array( 'jquery', 'edd-ajax' ), false, true );
	
	wp_localize_script( 'edd_keep_addtocart_js', 'edd_keep_addtocart_vars', array(
			'adding_to_cart_message' => __( 'Adding to Cart', 'edd_keep_addtocart' ),
			'sucessfully_added_message' => __( 'Successfully Added', 'edd_keep_addtocart' )
		)
	);
	
	wp_enqueue_style( 'edd_keep_addtocart_css', plugins_url('css/edd-keep-addtocart.css', dirname(__FILE__) ) );
	
}
add_action( 'wp_enqueue_scripts', 'edd_keep_addtocart_enqueue' );