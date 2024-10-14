<?php
/**
 *  This is the ajax functionality that processes the users' selections given via the form input. Next it
 *  refreshes dynamically the form's textarea with the pick line numbers returned by the pickResponder. If 
 *  the 'cyclingdata' (a.k.a '$supplyon') included in the response is set to zero, that signals the current  
 *  round's allowed total cycles have been used up and the pick button then gets disabled for a brief pause.
 */		
		$pickajax = <<<PICKAJAX
			<script type='text/javascript'>
			    function processform(){
					jQuery('#pickbutton').fadeTo('fast',0.35); 
					var separ = '$separator';
					var prefiks  = '$lineprefix';
					var newround = '$freshround';
					var visitdata  = jQuery('#visitid').val();
					var roundsdata = jQuery('#roundsid').val();
					var selectdata = jQuery('#lottoselected :selected').val();
					var picksignature = jQuery('#picksignid').val(); 
					jQuery.ajax( {
							type: 'GET', 
							url: ajax_url,
							data:   { action: 'pickResponder',                   
									  visit: visitdata,
  									  rounds: roundsdata,
									  lottoselection: selectdata,
									  _ajax_nonce: picksignature},
							success: function(databack) {
								var dataparts = databack.split(separ);
								var numberdata = dataparts[0];
								var kountdata  = dataparts[1];
								var cyclingdata  = dataparts[2];
								var displayline = prefiks + kountdata + separ + numberdata;
								jQuery('#visitid').attr('value',kountdata);
								jQuery('#answerbox').html(displayline);
								jQuery('#pickbutton').fadeTo('fast',1); 
								if(cyclingdata == 0 ) {
									jQuery('#pickbutton').fadeTo('fast',0.35);
									jQuery('#pickbutton').attr('disabled', true);
									setTimeout( function() {
															jQuery('#pickbutton').attr('disabled', false);
															jQuery('#visitid').attr('value', 0);
															jQuery('#answerbox').html(newround);
															jQuery('#pickbutton').fadeTo('fast',1); }, 11600); 
										} 
									} 
								}
						    )
					}
			    jQuery( document ).ready( function() {
				    jQuery('#pickbutton').click( function(){processform();}	);
					    }
					)
	        </script> 
PICKAJAX;
