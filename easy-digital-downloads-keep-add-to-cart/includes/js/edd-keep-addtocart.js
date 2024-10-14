jQuery(document).ready(function($) {
   
    //Make the add to cart button display even if EDD is trying to hide it
	$( 'a.edd-add-to-cart').css( 'display', '' );
	
	var original_addtocart_text;
	
	//We'll need to store which button was clicked because the "updated" trigger from EDD dosn't give us a button context
	var edd_keep_addtocart_button;
		
	//When the ajax add to cart in EDD is clicked
	 $('body').on('click.eddAddToCart', '.edd-add-to-cart', function (e) {
		 
		 //Remove the class which triggers the add to cart
		 $(this).removeClass('edd-add-to-cart');
		 			 		 
		 //Store what the button originally said so we can re-apply it after update
		 original_addtocart_text = $(this).find('.edd-add-to-cart-label').html();
		 
		 //Store which button was clicked so we can update it upon the "updated" trigger from edd
		 edd_keep_addtocart_button = $(this);
		 
		 //Show "Adding to Cart" on the button
		 $( this ).find('.edd-add-to-cart-label').html( edd_keep_addtocart_vars.adding_to_cart_message );
		 
		 $( this ).css( 'display', '' );
		 
		 $( this ).find( '.edd-loading' ).css( 'opacity', '' );
		 $( this ).find( '.edd-loading' ).css( 'margin-left', '5px' );
		 
		
	 });
	 
	//When a new item has been added to the cart using ajax in EDD
	$('body').on('edd_cart_item_added', function(event){
		
		if ( edd_keep_addtocart_button ){
			//Show "Successfully added" message on the button
			edd_keep_addtocart_button.find('.edd-add-to-cart-label').html( edd_keep_addtocart_vars.sucessfully_added_message );
				
			setTimeout(function () {			
				
				//Show the "add to cart" button text again
				edd_keep_addtocart_button.find('.edd-add-to-cart-label').html( original_addtocart_text );
				
				//Re-add the add-to-cart class so the button works again
				edd_keep_addtocart_button.addClass('edd-add-to-cart');
				
				edd_keep_addtocart_button.find( '.edd-add-to-cart-label' ).css( 'opacity', '1' );
				
				edd_keep_addtocart_button.find( '.edd-loading' ).css( 'opacity', '0' );
				
				console.log( 'test' );
			
			}, 1000);
			
		}
	});
	
});