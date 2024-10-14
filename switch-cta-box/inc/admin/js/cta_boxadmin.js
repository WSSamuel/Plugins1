jQuery( document ).ready(function() {
jQuery("#launcce_cta_box_template_preview").click(function(){
    jQueryTheSelectedOption = jQuery( "#cta_box_template_id" ).val();
	if(jQueryTheSelectedOption == "template_two"){
		imageUrl = jQuery("#template_two_image").val();
	}
	else if(jQueryTheSelectedOption == "template_one"){
		imageUrl = jQuery("#template_one_image").val();
	}
	else if(jQueryTheSelectedOption == "template_three"){
		imageUrl = jQuery("#template_three_image").val();
	}
	jQuery("#theimage_loader").css('background-image', 'url(' + imageUrl + ')').animate({height: "350"}, 1000, function() {
    // Animation complete.
	});;
});
jQuery( "#cta_box_template_id" ).change(function() {
  jQueryTheSelectedOption = jQuery( "#cta_box_template_id" ).val();
	if(jQueryTheSelectedOption == "template_two"){
		imageUrl = jQuery("#template_two_image").val();
	}
	else if(jQueryTheSelectedOption == "template_one"){
		imageUrl = jQuery("#template_one_image").val();
	}
	else if(jQueryTheSelectedOption == "template_three"){
		imageUrl = jQuery("#template_three_image").val();
	}
	jQuery("#theimage_loader").css('background-image', 'url(' + imageUrl + ')').animate({height: "350"}, 1000, function() {
    // Animation complete.
	});;
});
});