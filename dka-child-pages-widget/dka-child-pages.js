jQuery(document).ready(function($) {

	$('a.exclude').live('click', function(){
		
		var e_field = $($(this).attr('href')) ;
		var e_selec = $($(this).attr('rel')) ;
		var e_added = e_selec.val() ;
	
		if (e_added) {
			if ( e_field.val() ) {
				e_field.val( e_field.val() + ',' + e_added ) ;
			} else {
				e_field.val( e_added ) ;
			}
		}
		
	});

});
