var VABFWC_p_now	=	VABFWC_SenD_In.VABFWC_p_now_Out,
		VABFWC_Chu_F	=	VABFWC_SenD_In.VABFWC_Chu_F_Out,
		VABFWC_Chu_Fs	=	VABFWC_SenD_In.VABFWC_Chu_Fs_Out;
jQuery ( document ).ready( function ( $ ) {
	'use strict';
	$( document ).on( 'click', '.vabfwc_click', function() {
		jQuery( this ).children( 'textarea' ).focus();
	});
	$( document ).on( 'click', '.vabfwc_spoiler-head', function() {
		jQuery( this ).next().slideToggle( 400 );
	});
	if ( window.history.replaceState && VABFWC_p_now != '' ) {
		window.history.replaceState( null, null, window.location.href );
	}
	$( '.vabfwc_veri' ).prop( 'checked', false );
	$( document ).on( 'ready pjax:end', function() {
		$( '.vabfwc_veri' ).prop( 'checked', false);
	});
	$( '.VABFWC_file' ).change(function() {
    if ( $( this ).val() != '' ) {
			$(this).prev().text( VABFWC_Chu_Fs + ': ' + $( this )[0].files.length );
		} else {
			$( this ).prev().text( VABFWC_Chu_F );
		}
	});
});
function getVABFWC( name ) {
	'use strict';
	jQuery( name ).attr( 'required', 'required' ).val( 'GAME OVER' );
}
/* ( function( $ ) {
} ) ( jQuery ); */