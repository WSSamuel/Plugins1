<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
if ( ! function_exists( 'vabfwc_dirDel' ) ) {
	function vabfwc_dirDel( $dir ) {
		$d = opendir( $dir );
		while( ( $entry = readdir( $d ) ) !== false ) {
			if ( $entry != "." && $entry != ".."){
				if ( is_dir( $dir . "/" . $entry ) ) {
					vabfwc_dirDel( $dir . "/" . $entry );
				} else {
					unlink( $dir . "/" . $entry );
				}
			}
		}
		closedir( $d );
		rmdir( $dir );
	}
}
function vabfwc_delete_plugin() {
	$posts = get_posts(
		array(
			'numberposts' => -1,
			'post_type' => 'vab_fwc',
			'post_status' => 'any',
		)
	);
	foreach ( $posts as $post ) {
		wp_delete_post( $post->ID, true );
	}
	$VABFWC_dir = wp_upload_dir();
	$VABFWC_dir = $VABFWC_dir['basedir'] . '/VABFWC';
	if ( file_exists( $VABFWC_dir ) ) {
		vabfwc_dirDel( $VABFWC_dir );
	}
}
if ( ! defined( 'VABFWC_VERSION' ) ) {
	vabfwc_delete_plugin();
}