<?php
defined( 'ABSPATH' ) || die;

if ( ! function_exists( 'ric_get_localization' ) ) :

function ric_get_localization()
{
    $options = RICOptions::get_instance();
    
    $text_domain = RIC::text_domain();
    
	// HTML wrapper on return values 
	$bs = '<b class="ric_b">';
	$be = '</b>';
    
    $localization = array(
        
        // Currency Format
        'currency_symbol'               => $options->get( 'currency_symbol' ),
        'currency_code'                 => $options->get( 'currency_code' ),
        'currency_format'               => $options->get( 'currency_format' ),
        'thousands_separator'           => $options->get( 'thousands_separator' ),
        'decimal_separator'             => $options->get( 'decimal_separator' ),
        'decimal_places'                => $options->get( 'decimal_places' ),
        'indian_system'                 => $options->get( 'indian_system' ),
    
        // Input Settings
        'term_units'                    => $options->get( 'term_units' ),
    
        // Results Settings
        'results_display'               => $options->get( 'results_display' ),
        
        // Error messages
        'principal_error'       => __( 'Please enter the principal amount.', $text_domain ),
        'interest_rate_error'   => __( 'Please enter an interest rate.', $text_domain ),
        'term_error'            => __( 'Please enter the term.', $text_domain ),
    
        // Summary text
        'results_text'          => sprintf(
                __( 'Interest Accrued: %1$s', $text_domain ),
                $bs . '{interest_accrued}' . $be
            ),
        'summary_text'          => sprintf(
                __( 'For a term of %1$s on %2$s at a rate of %3$s%%, the accrued interest is %4$s.'),
                $bs . '{term}' . $be,
                $bs . '{principal}' . $be,
                $bs . '{interest_rate}' . $be,
                $bs . '{interest}' . $be
            ),
        'summary_text_sm'       => __( 'one month', $text_domain ),
        'summary_text_pm'       => sprintf(
                __( '%1$s months', $text_domain ),
                '{months}'
            ),
        'summary_text_sy'       => __( 'one year', $text_domain ),
        'summary_text_py'       => sprintf(
                __( '%1$s years', $text_domain ),
                '{years}'
            ),
        'summary_text_sysm'     => __( 'one year and one month', $text_domain ),
        'summary_text_sypm'     =>  sprintf(
                __( 'one year and %1$s months', $text_domain ),
                '{months}'
            ),
        'summary_text_pysm'     =>  sprintf(
                __( '%1$s year and one month', $text_domain ),
                '{years}'
            ),
        'summary_text_pypm'     =>  sprintf(
                __( '%1$s year and %2$s months', $text_domain ),
                '{years}',
                '{months}'
            ),
    );
    
    return $localization;
}   
 
endif;
