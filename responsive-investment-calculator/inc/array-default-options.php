<?php
/**
 * Default settings for the calculator
 *
 * @package Responsive Investment Calculator
 * @since 1.0.0
 */
return array(
    
    // Currency Format
    'currency_symbol'               => '$',
    'currency_code'                 => null,
    'currency_format'               => '{symbol}{amount} {code}',
    'thousands_separator'           => ',',
    'decimal_separator'             => '.',
    'decimal_places'                => 2,
    'indian_system'                 => 0,
    
    // Input Settings
    'compounding_period'            => 1,       // Show the compounding period input
    'compounding_period_yearly'     => 1,
    'compounding_period_quarterly'  => 1,
    'compounding_period_monthly'    => 1,
    'compounding_period_daily'      => 1,
    'term_units'                    => 'years', // Investment term in years
    
    // Labels
    'principal_label'               => __( 'Principal Amount', RIC::text_domain() ),
    'interest_rate_label'           => __( 'Interest Rate', RIC::text_domain() ),
    'term_label'                    => __( 'Investment Term', RIC::text_domain() ),
    'compounding_period_label'      => __( 'Compounding Period', RIC::text_domain() ),
    'submit_label'                  => __( 'Calculate', RIC::text_domain() ),
    
    // Default Values
    'principal_default'             => null,
    'interest_rate_default'         => null,
    'term_default'                  => null,
    'compounding_period_default'    => 12,
    
    // HTML Classes
    'principal_class'               => null,
    'interest_rate_class'           => null,
    'term_class'                    => null,
    'compounding_period_class'      => null,
    'submit_class'                  => null,
    
    // CSS Settings
    'css'                           => 1,       // Load CSS
    'css_responsive'                => 1,
    'css_theme'                     => 'light',
    'css_select'                    => 1,       // Fancy select box
    'css_select_adjust'             => null,    // Adjust the arrow on the fancy select box
    
    // Result Settings
    'results_display'               => 1        // Show result with a toggle for details
);
