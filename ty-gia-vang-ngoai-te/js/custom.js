jQuery(document).ready(function($) {
  	$(document).ready(function() {
  		 
  		$('.widget-top').on('click', function() {
  			
			var parent = $(this).closest('.widget');
			 
			if ($(parent).find('.ty-gia-types').length) {
				var types_wtg = $(parent).find('.ty-gia-types').val();
				 
				show_hide_wtg(types_wtg,parent);  
			}
		});

  		

		$('.ty-gia-types').on('change', function() {

			var parent = $(this).closest('.widget.open');
			  var ty = $(this).val();

			  show_hide_wtg(ty,parent);
		});


		$('.btn-preview-ty-gia').on('click', function() {
			var parent = $(this).closest('.widget.open');
			show_preview_wtg(parent);
		});
	});

	function show_hide_wtg(types_wtg,parent){
		$(parent).find('.hidden').hide();
		 
		switch(types_wtg) {
		 case "gold":
		  $(parent).find('.gold-show').show(); 
		  break;
		 case "bank":
		 case "interest_rate_deposit":
		 case "interest_rate_loan":
		  $(parent).find('.bank-show').show(); 
		  break;
		  case "rate":
		  case "tool_rate":
		  $(parent).find('.rate-show').show(); 
		  break;
		  case "oil":
		  $(parent).find('.oil-show').show(); 
		  break;
		  case "giaca":
		  $(parent).find('.giaca-show').show(); 
		  break;
		 default:
		 // code to be executed if n is different from case 1 and 2
		}  
	}

//
	function show_preview_wtg(parent){
		var width_wtg = $(parent).find('.ty-gia-width').val();
		var height_wtg = $(parent).find('.ty-gia-height').val();
		var bgheader_wtg = $(parent).find('.ty-gia-background-title').val().replace("#","");
		var colorheader_wtg = $(parent).find('.ty-gia-color-title').val().replace("#","");
		var padding_wtg = $(parent).find('.ty-gia-padding').val();
		var fontsize_wtg = $(parent).find('.ty-gia-font-size').val();
		var iso_wtg = '';
		var ty_wtg = $(parent).find('.ty-gia-types').val();
		    
	     
	  	switch(ty_wtg) {
			case "gold":
			  api = 'vang';
			  jQuery.each( $(parent).find('.gold-show .checkbox'), function( key, value ) {
				  if ($(this).is(":checked")) {
				  	iso_wtg  = iso_wtg+","+$(this).attr('name-show');
				  }
			  });
		  	break;
		 	case "bank":
			  api = 'tygia';
			    
			  jQuery.each( $(parent).find('.bank-show .checkbox'), function( key, value ) {
				  if ($(this).is(":checked")) {
				  	iso_wtg  = iso_wtg+","+$(this).attr('name-show');
				  }
			  }); 
			break;

			case "rate":
			  api = 'ngoaite';
			    
			  jQuery.each( $(parent).find('.rate-show .checkbox'), function( key, value ) {
				  if ($(this).is(":checked")) {
				  	iso_wtg  = iso_wtg+","+$(this).attr('name-show');
				  }
			  }); 
		  	break;
		  	case "oil":
			  api = 'xang-dau';
			    
			  jQuery.each( $(parent).find('.oil-show .checkbox'), function( key, value ) {
				  if ($(this).is(":checked")) {
				  	iso_wtg  = iso_wtg+","+$(this).attr('name-show');
				  }
			  }); 
		  	break;
		  	case "tool_rate":
			  api = 'cong-cu-chuyen-doi-tien-te';
			    
			  jQuery.each( $(parent).find('.rate-show .checkbox'), function( key, value ) {
				  if ($(this).is(":checked")) {
				  	iso_wtg  = iso_wtg+","+$(this).attr('name-show');
				  }
			  }); 
		  	break;

		  	case "interest_rate_deposit":
			  api = 'laisuat';
			    
			  jQuery.each( $(parent).find('.bank-show .checkbox'), function( key, value ) {
				  if ($(this).is(":checked")) {
				  	iso_wtg  = iso_wtg+","+$(this).attr('name-show');
				  }
			  }); 
		  	break;
		  	case "interest_rate_loan":
			  api = 'laisuatchovay';
			    
			  jQuery.each( $(parent).find('.bank-show .checkbox'), function( key, value ) {
				  if ($(this).is(":checked")) {
				  	iso_wtg  = iso_wtg+","+$(this).attr('name-show');
				  }
			  }); 
		  	break;

		  	case "giaca":
			  api = 'gia-ca-thi-truong';
			    
			  jQuery.each( $(parent).find('.giaca-show .checkbox'), function( key, value ) {
				  if ($(this).is(":checked")) {
				  	iso_wtg  = iso_wtg+","+$(this).attr('name-show');
				  }
			  }); 
		  	break;
		  	case "coin":
			  api = 'coin-embed';
			    
			  /*jQuery.each( $(parent).find('.bank-show .checkbox'), function( key, value ) {
				  if ($(this).is(":checked")) {
				  	iso_wtg  = iso_wtg+","+$(this).attr('name-show');
				  }
			  }); */
		  	break;
		  	
		 	default:
		  		api = 'vang'; 
		  	break;
		} 

		//show iframe
	  	jQuery('.widget.open .div-preview-ty-gia').html('<iframe frameborder="0" width="'+width_wtg+'" height="'+height_wtg+'" src="https://webtygia.com/api/'+api+'?bgheader='+bgheader_wtg+'&colorheader='+colorheader_wtg+'&padding='+padding_wtg+'&fontsize='+fontsize_wtg+'&hienthi='+iso_wtg+'&"></iframe>');

	}
});
//show or hide by type wtg
