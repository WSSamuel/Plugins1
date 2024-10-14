<?php
/*
Plugin Name: en_GB localisation
Description: Fixes those little things in WordPress like misplaced vowels and over-use of the letter Z.
Author: Adam Harley
Author URI: http://adamharley.co.uk
Plugin URI: http://adamharley.co.uk/wordpress-plugins/british-english-translation/
Version: 1.0.2.1
*/

function gb_gettext( $text ) {
	static $replace, $keys;

	if ( !is_array($replace) ) {
		$replace = array(
			'You are about to install WordPress %s <strong>in English (US).</strong> There is a chance this update will break your translation. You may prefer to wait for the localized version to be released.'
				=> 'You are about to install WordPress %s <strong>in English (US).</strong> There is a chance this may expose you briefly to Americanisms. Stay calm and carry on.',

			'Trash' => 'Bin',
			'trash' => 'bin',

			'Color' => 'Colour',
			'color' => 'colour',
			'favorite' => 'favourite',
			'neighbor' => 'neighbour',

			// Cambridge > Oxford
			'authorize' => 'authorise',
			'categorize' => 'categorise',
			'customize' => 'customise',
			'localized' => 'localised',
			'minimize' => 'minimise',
			'optimize' => 'optimise',
			'Optimize' => 'Optimise',
			'Organize' => 'Organise',
			'recognize' => 'recognise',
			'utilize' => 'utilise',
		);

		$hour = date('G', time() + (get_option('gmt_offset')/* in hrs*/ * 60 * 60) );

		if ( $hour <= 4 )
			$replace['Howdy, %1$s'] = 'Go to bed, %1$s';
		else if ( $hour < 12 )
			$replace['Howdy, %1$s'] = 'Mornin\', %1$s';
		else if ( $hour <= 16 )
			$replace['Howdy, %1$s'] = 'Afternoon, %1$s';
		else
			$replace['Howdy, %1$s'] = 'Evenin\', %1$s';

		$keys = array_keys( $replace );
	}

	return str_replace( $keys, $replace, $text );
}

add_filter( 'gettext', 'gb_gettext' );
add_filter( 'gettext_with_context', 'gb_gettext' );
add_filter( 'ngettext', 'gb_gettext' );
add_filter( 'ngettext_with_context', 'gb_gettext' );