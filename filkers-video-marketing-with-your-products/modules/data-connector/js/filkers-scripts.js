(function($) {
	var filkers_main_message_timeout;

	window.filkers_get_main_message = function (filkers_main_message_new_content){
		clearTimeout(filkers_main_message_timeout);
    filkers_main_message = $('#filkers-main-message');
    filkers_main_message.find('#filkers-main-message-span').html(filkers_main_message_new_content);
    filkers_main_message.fadeOut(100).fadeIn('slow');

    filkers_main_message_timeout = setTimeout(function(){
    	if (filkers_main_message.is(":visible")) {
      	filkers_main_message.fadeOut('slow');
    	}
    }, 10000);
  }

  window.pad = function (str, max) {
	  str = str.toString();
	  return str.length < max ? pad('0' + str, max) : str;
	}

  window.inArray = function (needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle) return true;
    }

    return false;
  }

  function filkers_checkbox_change(){
    if ($('#filkers_api_connection_checkbox').is(':checked')) {
      $('.form-table tr:nth-child(2),.form-table tr:nth-child(3)').fadeIn('fast');
    }else{
      $('.form-table tr:nth-child(2),.form-table tr:nth-child(3)').fadeOut('fast');
    }
  }

	$(document).ready(function() {
		if ($('#filkers_api_connection_checkbox').length) {
			filkers_checkbox_change();

		  $(document).on('change', '#filkers_api_connection_checkbox, #filkers_api_debug_checkbox', function(e){
		    filkers_checkbox_change();
		    filkers_get_main_message('Ok');
		  });
		}

		if ($('.filkers-toggle').length) {
			$(document).on('click', '.filkers-toggle', function(e) {
      e.preventDefault();

      if ($(this).find('i').length) {
        if ($(this).siblings('.filkers-toggle-content').is(':visible')) {
        	$(this).find('i').text('keyboard_arrow_down');
        }else{
        	$(this).find('i').text('keyboard_arrow_up');
        }
      }

      $(this).siblings('.filkers-toggle-content').fadeToggle();
    });
		}

		if ($('.login form .input').length) {
      $('.login form .input').each(function(index) {
			  $('#user_login').attr('placeholder', $('#user_login').siblings('label').text());

			  $('#user_pass').attr('placeholder', $('#user_pass').closest('.user-pass-wrap').find('label').text());

			  $('#password_protected_pass').attr('placeholder', $('#password_protected_pass').closest('label').text());
			});
    }
    
	  if($('.filkers-reload-page').length) {
			$(document).on('click','.filkers-reload-page',function(e){
				e.preventDefault();
		    location.reload();
		  });
		}

		if($('.filkers-parallax').length) {
			$('.filkers-parallax').each(function(index, element) {
	      $(this).css({'height': $(this).attr('data-filkers-parallax-height') + 'px', 'background-image': 'url("' + $(this).attr('data-filkers-parallax-url') + '"'});
	    });
		}

	  if($('.filkers-scroll-anchor').length) {
	  	$(document).on('click','.filkers-scroll-anchor',function(e){
	  		e.preventDefault();
	  		$('html, body').animate({
	  			scrollTop: $($(this).attr('href')).offset().top
	  		},2000);
	  	});
	  }

	  if($('.filkers-close-icon').length){
	  	$(document).on('click','.filkers-close-icon',function(e){
	  		e.preventDefault();$(this).closest('div').fadeOut('slow');
	  	});
	  }

	  if($('.filkers-tooltip').length) {
			$('.filkers-tooltip').tooltipster({maxWidth:300,delayTouch:[0,4000]});
		}

	  if ($('.filkers-select').length) {
	  	$('.filkers-select').each(function(index) {
				if ($(this).hasClass('search-disabled')) {
					$(this).select2({minimumResultsForSearch: -1});
				}else{
					$(this).select2();
				}
			});
		}

		/* AVISO LEGAL */
		if ($('.filkers-privacy-policy').length) {
			$('.filkers-legal-section p,.filkers-legal-section h3,.filkers-legal-section ul').fadeOut();
			$('.filkers-legal-section h2').css('cursor','pointer');
			$('.filkers-privacy-policy h2').click(function(e) {
	      e.preventDefault();
	      $(this).closest('.filkers-legal-section').find('p,h3,ul').fadeToggle('slow');
	    });
		}
	})
})(jQuery);