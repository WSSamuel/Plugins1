// Responsive Investment Calculator JS
(function($) {
    
    ric = {
        
        currencyFormat : null,
        thousandsSeparator : null,
        decimalSeparator : null,
        decimalPlaces : null,
        indianSystem : null,
        
        termUnits : null,
        
        resultsDisplay : 0,
        
        error: false,
        
        init : function() {
            this.setFormSubmitHandler();
            this.setCurrencyFormat();
            this.setSettings();
            this.setInspectorEventHandler();
        },
        
        setFormSubmitHandler : function() {
            $('#ric_form').submit( function(event) {
                event.preventDefault();
                ric.calculate();
            });
        },
        
        setInspectorEventHandler : function() {
		
			// Show the summary div when the result div is clicked.
			if ( $( '.ric_inspector' ).length ) {
                
                // Hide the summary
                $('.ric_summary').hide();
                
                // Set the event handler on the icon
				$('.ric_inspector').click(function() {
                    $('.ric_summary').slideToggle();
				});
			}
        },
        
        setCurrencyFormat : function() {
            
            var format = lidd_ric_script_vars.currency_format;
            if ( typeof format == 'undefined' ) {
                format = '{symbol}{amount}';
            }
            var symbol = lidd_ric_script_vars.currency_symbol;
            if ( symbol == null ) symbol = '';
            var code = lidd_ric_script_vars.currency_code;
            if ( code == null ) code = '';
            
            format = format.replace( '{symbol}', symbol );
            this.currencyFormat = format.replace( '{code}', code );
            
            this.thousandsSeparator = lidd_ric_script_vars.thousands_separator;
            if ( this.thousandsSeparator == '{space}' ) this.thousandsSeparator = '&nbsp;';
            this.decimalSeparator = lidd_ric_script_vars.decimal_separator;
            this.decimalPlaces = lidd_ric_script_vars.decimal_places;
            this.indianSystem = lidd_ric_script_vars.indian_system;
            
        },
        
        setSettings : function() {
            
            this.thousandSeparator = lidd_ric_script_vars.thousand_separator;
            this.decimalSeparator = lidd_ric_script_vars.decimal_separator;
            this.decimalPlaces = lidd_ric_script_vars.decimal_places;
            this.indianSystem = lidd_ric_script_vars.indian_system;
            
            this.termUnits = lidd_ric_script_vars.term_units;
            
            this.resultsDisplay = lidd_ric_script_vars.results_display;
        },
        
        calculate : function() {
            
            this.error = false;
            
            $('#ric_results_wrap').hide();
            $('#ric_results').html('');
            $('#ric_summary').html('');
            
            var principal           = $('#ric_principal').val().replace(/[^\d.]/g, '');
            var interest_rate       = $('#ric_interest_rate').val().replace(/[^\d.]/g, '');
            var term                = $('#ric_term').val().replace(/[^\d.]/g, '');
            var compounding_period  = $('#ric_compounding_period').val().replace(/[^\d.]/g, '');
            
            // ***** VALIDATE
            
            // Principal
            if ( $.isNumeric( +principal ) && principal > 0 ) {
    			principal = Math.abs( Math.round( (+principal)*100 ) / 100 );
                this.removeError( $('.ric_principal_error') );
            }
            else {
                this.triggerError( $('.ric_principal_error'), lidd_ric_script_vars.principal_error );
            }
            
    		// Interest rate. Positive value less than 100%.
    		if ( $.isNumeric( +interest_rate ) && (+interest_rate) < 100 && (+interest_rate) > 0 ) {
    			interest_rate = +interest_rate;
    			this.removeError( $('.ric_interest_rate_error') );
    		} else {
    			this.triggerError( $('.ric_interest_rate_error'), lidd_ric_script_vars.interest_rate_error );
    		}
            
            // Term
    		if ( $.isNumeric( +term ) && (+term) > 0 ) {
    			// The amortization period needs to fit nicely with the payment periods if there are decimals.
                if ( this.termUnits == 'months' ) term /= 12;
    			term = Math.abs( Math.ceil( term * 12 ) / 12 );
    			this.removeError( $('.ric_term_error') );
    		} else {
    			this.triggerError( $('.ric_term_error'), lidd_ric_script_vars.term_error );
    		}
            
            // Compounding Period
            switch ( compounding_period ) {
            case '365':
                compounding_period = 365;
                break;
            case '12':
                compounding_period = 12;
                break;
            case '4':
                compounding_period = 4;
                break;
            case '1':
            default:
                compounding_period = 1;
                break;
            }
            
            if ( this.error ) {
                return;
            }

            // ***** CALCULATE
            
            var nominal_interest_rate = interest_rate / 100;
            
            // F = P ( 1 + i/n ) ^ ( n * t );
            var future_value = principal * Math.pow( ( 1 + ( nominal_interest_rate / compounding_period ) ), ( compounding_period * term ) );
            var interest = future_value - principal;
            
            // ***** RESULTS
            
            if ( this.resultsDisplay != '4' ) {
                
                var results = $('#ric_results'),
                    results_text = lidd_ric_script_vars.results_text;
                    
                results_text = results_text.replace( '{interest_accrued}', this.formatCurrency( interest ) );
                results.html( '<p>' + results_text + '</p>' );
            }
            
            // ***** SUMMARY
            
            if ( this.resultsDisplay != '0' ) {

                var summary = $('#ric_summary'),
                    summary_text = lidd_ric_script_vars.summary_text;
            
                summary_text = summary_text.replace( '{term}', this.getTermText( term ) ).replace( '{principal}', this.formatCurrency( principal ) ).replace( '{interest_rate}', this.formatNumber( interest_rate, 2 ) ).replace( '{interest}', this.formatCurrency( interest ) );
                summary.html( '<p>' + summary_text + '</p>' );
            }
            
            // ***** DISPLAY
            
            $('#ric_results_wrap').show();
        },
        
        triggerError : function( element, message ) {
            this.error = true;
            element.text( message );
            element.addClass( 'ric_error' );
        },
        
        removeError : function( element ) {
			element.text( '' );
			element.removeClass( 'ric_error' );
        },
        
        formatCurrency : function( amount ) {
            
            if ( this.indianSystem == 1 ) {
                amount = this.formatIndianSystem( amount );
            }
            else {
                amount = this.formatNumber( amount );
            }
            
            var format = this.currencyFormat;
            return format.replace( '{amount}', amount );
        },
        
        formatNumber : function( amount, places ) {
            
            if ( typeof places == 'undefined' ) {
                places = this.decimalPlaces;
                console.log( typeof places );
            }
            amount = amount.toFixed( places );
		    amount = amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, this.thousandsSeparator );
            if ( places > 0 && this.decimalSeparator == ',' ) {
                amount = amount.substring( 0, amount.lastIndexOf(".") ) + ',' + amount.substring( amount.lastIndexOf(".") + 1 );
            }
            return amount;
        },
        
        formatIndianSystem : function( amount ) {
            amount = amount.toFixed(0);
		    return amount.slice(0, -3).toString().replace(/\B(?=(\d{2})+(?!\d))/g, ',') + ',' + amount.slice(-3);
        },
        
        getTermText : function( term ) {
            
            var term_text,
                months = ( Math.ceil( term * 12 ) % 12 ),
                years = Math.floor( term );
                
            if ( years == 0 ) {
                if ( months == 1 ) {
                    term_text = lidd_ric_script_vars.summary_text_sm;
                }
                else {
                    term_text = lidd_ric_script_vars.summary_text_pm;
                }
            }
            else if ( years == 1 ) {
                if ( months == 0 ) {
                    term_text = lidd_ric_script_vars.summary_text_sy;
                }
                else if ( months == 1 ) {
                    term_text = lidd_ric_script_vars.summary_text_sysm;
                }
                else {
                    term_text = lidd_ric_script_vars.summary_text_sypm;
                }
            }
            else {
                if ( months == 0 ) {
                    term_text = lidd_ric_script_vars.summary_text_py;
                }
                else if ( months == 1 ) {
                    term_text = lidd_ric_script_vars.summary_text_pysm;
                }
                else {
                    term_text = lidd_ric_script_vars.summary_text_pypm;
                }
            }
            
            return term_text.replace( '{years}', years ).replace( '{months}', months );
        }
        
    },
    
    $(document).ready( function() {
        ric.init();
    });
    
})(jQuery);