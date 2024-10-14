<?php

/**
 * This file adds scripts
 */

// Adjust top position of fixed header to not overlap wordpress alert bar
add_action( 'wp_footer', 'mbwpab_fixed_header_script', 99 );
function mbwpab_fixed_header_script() {
	?>
	<script>
		jQuery( document ).ready( function() {

			function fixedHeaderAdjust( fixedHeader ) {
				if ( 'fixed' === jQuery( fixedHeader  ).css( 'position' ) ) {

					if ( jQuery( 'body' ).hasClass( 'mbwpab-alert-bar-active' ) ) {

						var alertHeight 		=	jQuery( '.mbwpab-alert-bar' ).outerHeight();
						var alertHeightAdmin	=	alertHeight + 32;

						if ( jQuery( 'body' ).hasClass( 'admin-bar' ) ) {
							jQuery( fixedHeader ).attr( 'style', 'top: ' + alertHeightAdmin + 'px !important' );
						} else {
							jQuery( fixedHeader ).attr( 'style', 'top: ' + alertHeight + 'px !important' );
						} 

						jQuery( '.mbwpab-alert-closer' ).click( function() {
			                jQuery( fixedHeader ).removeAttr( 'style' );
			            });

					}

				}
			}

			function fixedHeaderScrollAdjust( fixedHeader ) {

            	if ( 'fixed' === jQuery( fixedHeader  ).css( 'position' ) ) {
 
				    if ( jQuery( 'body' ).hasClass( 'mbwpab-alert-bar-active' ) ) {

				    	var alertHeight 			=	jQuery( '.mbwpab-alert-bar' ).outerHeight();
						var alertHeightAdmin		=	alertHeight + 32;
		            	var alertOffset				=	jQuery( '.mbwpab-alert-bar' ).offset().top;
		            	var windowScroll			=	jQuery( window ).scrollTop();
		            	var alertScrollOffset 		=	alertHeight - windowScroll;
		            	var alertScrollOffsetAdmin 	=	alertHeightAdmin - windowScroll;

					    if ( alertScrollOffset >= 1 ) {	
					    	if ( jQuery( 'body' ).hasClass( 'admin-bar' ) ) {
								jQuery( fixedHeader ).attr( 'style', 'top: ' + alertScrollOffsetAdmin + 'px !important' );
							} else {
								jQuery( fixedHeader ).attr( 'style', 'top: ' + alertScrollOffset + 'px !important' );
							} 
					    } else if ( alertScrollOffset < 1 ){
					    	jQuery( fixedHeader ).removeAttr( 'style' );
					    }

					}

				}

			}

			fixedHeaderAdjust( '<?php echo apply_filters( 'mbwpab_fixed_header_selector', '' ); ?>' );

            jQuery( window ).scroll( function () {
            	fixedHeaderScrollAdjust( '<?php echo apply_filters( 'mbwpab_fixed_header_selector', '' ); ?>' );
			});

		});
	</script>
	<?php
}

// Add alert closer script
function mbwpab_closer_script() {
    ?>
    <script>
        jQuery( document ).ready( function() {

            // Collapse search on click
            jQuery( '.mbwpab-alert-closer' ).click( function() {
                jQuery( '.mbwpab-alert-bar' ).slideUp();
                jQuery( 'body' ).removeClass( 'mbwpab-alert-bar-active' );
            });

        });
    </script>
    <?php
}