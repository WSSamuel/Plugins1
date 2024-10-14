(function( $ ) {
  'use strict';

  // Add color picker widget to all fields with .wph-color-picker class:
  $('.wph-color-picker').wpColorPicker();

  // we create a copy of the WP inline edit post function
  var $wp_inline_edit = inlineEditPost.edit;
  // and then we overwrite the function with our own code
  inlineEditPost.edit = function( id ) {

    // "call" the original WP edit function
    // we don't want to leave WordPress hanging
    $wp_inline_edit.apply( this, arguments );

    // now we take care of our business

    // get the post ID
    var $post_id = 0;
    if ( typeof( id ) == 'object' )
      $post_id = parseInt( this.getId( id ) );

    if ( $post_id > 0 ) {

      // define the edit row
      var $edit_row = $( '#edit-' + $post_id );

      // get the feedback button status
      var $feedbackable = $( '#post-' + $post_id + ' .wphelpful').text();
      // populate the completable button status
      $edit_row.find( 'input[name="wphelpful[feedback]"]' ).attr( 'checked', $feedbackable != 'Not Enabled' );
    }

  };

  $(document).on('click', '.wph_delete_button', function(e) {
    e.preventDefault();

    if (confirm('Are you sure you want to delete this feedback?')) {
      var elm = this;
      var feedback_id = $(this).data('feedback-id');

      $.getJSON( WPHelpful.url + "?action=wph_delete_feedback", { feedback_id: feedback_id }, function( data, status, xhr ) {
        console.log(data);
        $(elm).closest('tr').fadeOut(1000);
      });
    }
    
    return false;
  });

})( jQuery );
