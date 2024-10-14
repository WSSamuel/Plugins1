<?php
if ( ! function_exists( 'dirDel' ) ) {
	function dirDel( $dir ) {
		$d = opendir( $dir );
		while( ( $entry = readdir( $d ) ) !== false ) {
			if ( $entry != "." && $entry != ".."){
				if ( is_dir( $dir . "/" . $entry ) ) {
					dirDel( $dir . "/" . $entry );
				} else {
					unlink( $dir . "/" . $entry );
				}
			}
		}
		closedir( $d );
		rmdir( $dir );
	}
}