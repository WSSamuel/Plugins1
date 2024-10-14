(function( $ ) {
  'use strict';

  var $this;
  
  $(function() {
    // Determine if we should disable the submit button or show the feedback section on load: 
    var ratings = $('.wph .wph-rating');
    ratings.change(function (e) {
      $(this).closest('.wph form.wph-form').find('.wph-button').prop('disabled', ratings.filter(':checked').length < 1);
      if ( ( $('.wph.wph-after_rating').size() > 0 ) && ( ratings.filter(':checked').length > 0 ) ) {
        $('.wph-feedback-wrap').fadeIn(1000);
      }
    });
    ratings.change();
    // If we don't show the feedback section, just submit upon rating change:
    $('.wph.wph-never').on('change', '.wph-rating', function(e) {
      $('.wph form.wph-form').trigger('submit');
    });
    // If we show feedback after rating, show it once we have a rating:
    $('.wph.wph-after_rating').on('change', '.wph-rating', function(e) {
      $('.wph-feedback-wrap').fadeIn(1000);
    });

    $('body').on('submit', '.wph form.wph-form', function(e) {
      e.preventDefault();
      var $form = $(this);
      $this = $form.find('.wph-button');
      var data = {
        _ajax_nonce: wphelpful.nonce,
        action: 'wphelpful_save_feedback'
      }
      // add form data to data:
      var formData = $form.serializeArray(); 
      for (var x in formData) {
        data[formData[x]['name'].replace('wphelpful[', '').replace(']', '')] = formData[x]['value'];
      }
      data['local_time'] = new Date();

      // change button to disable and indicate saving...
      $this.attr('disabled', 'disabled');

      // change text to active state from settings...
      //var button_text = $this.html();
      var active_button_text = $this.data('active');
      $this.html(active_button_text);
      
      //console.log(data);

      $.ajax({
        url: wphelpful.ajax_url,
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function(response) {
          //console.log(response);
          for (var x in response) {
            $(''+x).replaceWith(response[x]);
          }
          // TODO: set cookie?
          //console.log('saved!');
        },
        error: function(xhr, textStatus, errorThrown) {
          $this.attr('disabled', false).html('Error');
          // TODO: should this be a setting?
          alert("Uh oh! We ran into an error saving your feedback.");
          console.log(textStatus);
          console.log(errorThrown);
        }
      });
      return false;
    });
  });

  jQuery( document.body ).on( 'post-load', function() {});

})( jQuery );
