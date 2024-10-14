<?php
/*
Plugin Name: Easy Digital Downloads - Keep Add To Cart
Plugin URI: http://mintplugins.com/plugins/edd-keep-addtocart
Description: Keep the "Add To Cart" ajax button on the screen instead of switching to a "Checkout" button. This way, multiples can be added to the cart.
Version: 1.0.0.3
Author: Mint Plugins
Author URI: http://mintplugins.com
License: GPLv2 or later
Contributors: johnstonphilip, mintplugins, mordauk
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Include Enqueue Scripts 
 */
require( plugin_dir_path( __FILE__ ) . 'includes/misc-functions/enqueue-scripts.php' );


		
	