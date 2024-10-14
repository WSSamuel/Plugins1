/**
 * This is the main javascript file for the author_avatar plugin's main administration view.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end administrator.
 *
 * @package   author-avatar
 * @author    Guillaume Kanoufi <guillaume@lostwebdesigns.com>
 * @license   GPL-2.0+
 * @link      http://lostwebdesigns.com
 * @copyright 12-16-2013 Company Name
 */

(function ($) {
	"use strict";
	$(function () {
		// Place your administration-specific JavaScript here
		// Uploading files
		var file_frame,
			attachment,
			trigger = ($('#user_meta_image').val() === '') ? $('.additional-user-image, #user_meta_image') : $('.additional-user-image');


		  trigger.on('click', function( event ){


		    event.preventDefault();

		    // If the media frame already exists, reopen it.
		    if ( file_frame ) {
		      file_frame.open();
		      return;
		    }

		    // Create the media frame.
		    file_frame = wp.media.frames.file_frame = wp.media({
		      title: $( this ).data( 'uploader_title' ),
		      button: {
		        text: $( this ).data( 'uploader_button_text' ),
		      },
		      multiple: false  // Set to true to allow multiple files to be selected
		    });

		    // When an image is selected, run a callback.
		    file_frame.on( 'select', function() {
		      // We set multiple to false so only get one image from the uploader
		      attachment = file_frame.state().get('selection').first().toJSON();

		            // Sends the attachment URL to our custom image input field.
		            $('#user_meta_image').val(attachment.url);
		            $(".user_meta_thumb").attr('src', attachment.url);
		            //console.log(attachment);

		      // Do something with attachment.id and/or attachment.url here
		    });

		    // Finally, open the modal
		    file_frame.open();
		  });
	});
}(jQuery));
