jQuery( document ).ready( function( $ ) {
	$( "#cookie-notification-jc-opacity-slider" ).slider({
		range: "min",
		value: $( "input[id=cookie-notification-jc-opacity-slider-val]" ).val(),
		min: 1,
		max: 100,
		slide: function( event, ui ) {
			$( "#cookie-notification-jc-opacity-slider-val").val( ui.value );
		}
	});
	
	$( "#cookie-notification-jc-opacity-slider-val" ).val( $( "#cookie-notification-jc-opacity-slider" ).slider( "value" )  );
});