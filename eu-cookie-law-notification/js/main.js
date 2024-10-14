jQuery( document ).ready( function( $ ) {
	$(".cookie-notification-jc-accept").hover(
		function(){
			$(this).css('cursor', 'pointer');
		},
		function(){
			$(this).css('cursor', 'auto');
		}
	);
	
	$(".cookie-notification-jc-accept").click(
		function(){
			$("#cookie-notification-jc").slideUp( 150 );
		}
	);
	
	// Move the notification to top
	$(".top").prependTo("body");
});