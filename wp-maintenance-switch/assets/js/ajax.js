jQuery(document).ready( function($){
    $( '#wp-admin-bar-wpmaintenanceswitch' ).click( function( ev ){
        ev.preventDefault();
        var data = { action: 'wpmaintenanceswitch' };
		$( '#wp-admin-bar-wpmaintenanceswitch' ).find('.ab-icon').removeClass( 'dashicons-admin-tools' ).addClass( 'dashicons-update wpmaintenanceswitch-spinner' );
        $.post( wpmaintenanceswitch.ajaxurl, data, function( response ){
            if( 1 === response.wpmaintenanceswitch ){
                $( '.wpmaintenanceswitch-toggler' ).addClass( 'active' ).find( '.ab-icon' ).removeClass( 'dashicons-update wpmaintenanceswitch-spinner' ).addClass( 'dashicons-admin-tools' );
            } else {
                $( '.wpmaintenanceswitch-toggler' ).removeClass( 'active' ).find( '.ab-icon' ).removeClass( 'dashicons-update wpmaintenanceswitch-spinner' ).addClass( 'dashicons-admin-tools' );
            }
        }, 'json' );
    } );
} );