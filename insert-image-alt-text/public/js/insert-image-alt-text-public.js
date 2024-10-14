(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );

function show_image_alt_text(){
    var imgs = document.getElementsByTagName("img");
    var imgSrcs = [];
	    for (var i = 0; i < imgs.length; i++) {
	    	if(imgs[i].hasAttribute("alt") && imgs[i].alt != ''){
	    		imgs[i].style.background = "green";
	    	}else{
				imgs[i].style.background = "red";
				imgSrcs.push(imgs[i].src);
	    	}
				imgs[i].style.padding = "10px";
	    }

	    var appendHtml = '';
	    imgSrcs.forEach(function(element) {
		  appendHtml += '<li><a target="_blank" href="' + element + '">' + element + '</a></li>';
		});

		document.getElementById('div-no-alt').style.display = 'block';

		document.getElementById('put-all-no-alt-here').innerHTML = appendHtml;
}
