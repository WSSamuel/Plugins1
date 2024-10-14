<?php
/*
Plugin Name: Unpublish
Plugin URI: https://github.com/dougwollison/unpublish
Description: Simply adds a one-click "Unpublish" button to the Editor screen, which switches the post to Pending status.
Version: 1.0.0
Author: Doug Wollison
Author URI: http://dougw.me
Tags: unpublish
License: GPL2
Text Domain: unpublish
Domain Path: /languages
*/

/**
 * Print the Unpublish minor action button on published posts.
 *
 * @since 1.0.0
 *
 * @param WP_Post $post The post being edited.
 */
function unpublish_print_button( $post ) {
	if ( $post->post_status == 'publish' ) {
		?>
		<input name="unpublish" type="submit" class="button" id="unpublish" value="<?php esc_attr_e( 'Unpublish', 'unpublish' ) ?>" />
		<?php
	}
}

add_action( 'post_submitbox_minor_actions', 'unpublish_print_button' );

/**
 * Print styling for unpublish button.
 *
 * @since 1.0.0
 */
function unpublish_print_styling() {
	?>
	<style type="text/css" media="screen">
		#unpublish {
			float: left;
		}
	</style>
	<?php
}

add_action( 'admin_head', 'unpublish_print_styling' );

/**
 * Handle the unpublish action.
 *
 * Rewrite the post_status field to "pending".
 *
 * @since 1.0.0
 */
function unpublish_handle_action() {
	// Ensure this came through the editpost action, and that the post was going to be saved as published
	if ( isset( $_POST['action'] ) && $_POST['action'] == 'editpost'
	  && isset( $_POST['unpublish'] ) && ! empty( $_POST['unpublish'] )
	  && isset( $_POST['post_status'] ) && $_POST['post_status'] == 'publish' ) {
		$_POST['post_status'] = 'pending';
	}
}

add_action( 'admin_init', 'unpublish_handle_action' );
