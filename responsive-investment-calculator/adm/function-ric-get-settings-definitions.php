<?php
function ric_get_settings_definitions()
{
    $text_domain = RIC::text_domain();
    $admin_page  = RIC::admin_page();
    
    $definitions = array(
        
        // Currency Settings
        array(
            'id'            => 'ric_currency_settings',
            'title'         => __( 'Currency Settings', $text_domain ),
            'description'   => __( 'Set the display format and symbol for the currency.', $text_domain ),
            'fields'        => array(
                array(
                    'id'        => 'currency_symbol',
                    'title'     => __( 'Currency Symbol', $text_domain ),
                    'callback'  => 'sanitize_text',
                    'args'      => array(
                        'id'            => 'ric_currency_symbol',
                        'type'          => 'text'
                    )
                ),
                array(
                    'id'        => 'currency_code',
                    'title'     => __( 'Currency Code', $text_domain ) . ' &ndash; <a href="http://www.currency-iso.org/">ISO 4217</a>',
                    'callback'  => 'sanitize_currency_code',
                    'args'      => array(
                        'id'        => 'ric_currency_code',
                        'type'      => 'text'
                    )
                ),
                array(
                    'id'        => 'currency_format',
                    'title'     => __( 'Currency Format', $text_domain ),
                    'callback'  => 'sanitize_currency_format',
                    'args'      => array(
                        'id'        => 'ric_currency_format',
                        'type'      => 'text',
                        'help'      => __( 'Use the tags {currency}, {amount} and {code} to structure how currency is displayed in the results. Spaces are allowed.', $text_domain )
                    )
                ),
                array(
                    'id'        => 'thousands_separator',
                    'title'     => __( 'Thousands Separator', $text_domain ),
                    'callback'  => 'sanitize_select',
                    'args'      => array(
                        'id'            => 'ric_thousands_separator',
                        'type'          => 'select',
                        'options'       => array(
                            '.'         => 'Period: "."',
                            ','         => 'Comma: ","',
                            '{space}'   => 'Space: " "'
                        )
                    )
                ),
                array(
                    'id'        => 'decimal_separator',
                    'title'     => __( 'Decimal Separator', $text_domain ),
                    'callback'  => 'sanitize_select',
                    'args'      => array(
                        'id'            => 'ric_decimal_separator',
                        'type'          => 'select',
                        'options'       => array(
                            '.' => 'Period: "."',
                            ',' => 'Comma: ","'
                        )
                    )
                ),
                array(
                    'id'        => 'decimal_places',
                    'title'     => __( 'Decimal Places', $text_domain ),
                    'callback'  => 'sanitize_int',
                    'args'      => array(
                        'id'        => 'ric_decimal_places',
                        'type'      => 'text'
                    )
                ),
                array(
                    'id'        => 'indian_system',
                    'title'     => __( 'Indian System', $text_domain ),
                    'callback'  => 'sanitize_checkbox',
                    'args'      => array(
                        'id'            => 'ric_indian_system',
                        'label'         => 'Use the Indian System to format currency.',
                        'type'          => 'checkbox'
                    )
                )
            )
        ),
        
        // Input Settings
        array(
            'id'            => 'ric_input_settings',
            'title'         => __( 'Input Settings', $text_domain ),
            'description'   => __( 'Choose settings for the calculator inputs.', $text_domain ),
            'fields'        => array(
                array(
                    'id'        => 'compounding_period',
                    'title'     => __( 'Compounding Period', $text_domain ),
                    'callback'  => 'sanitize_checkbox',
                    'args'      => array(
                        'id'        => 'ric_compounding_period',
                        'label'     => 'Allow users to select an interest rate compounding period. Leave unchecked to hide the input.',
                        'type'      => 'checkbox'
                    )
                ),
                array(
                    'id'        => 'compounding_period_yearly',
                    'title'     => __( 'Annual Compounding', $text_domain ),
                    'callback'  => 'sanitize_checkbox',
                    'args'      => array(
                        'id'        => 'ric_compounding_period_yearly',
                        'label'     => 'User can select Annual compounding.',
                        'type'      => 'checkbox'
                    )
                ),
                array(
                    'id'        => 'compounding_period_quarterly',
                    'title'     => __( 'Quarterly Compounding', $text_domain ),
                    'callback'  => 'sanitize_checkbox',
                    'args'      => array(
                        'id'        => 'ric_compounding_period_quarterly',
                        'label'     => 'User can select Quarterly compounding.',
                        'type'      => 'checkbox'
                    )
                ),
                array(
                    'id'        => 'compounding_period_monthly',
                    'title'     => __( 'Monthly Compounding', $text_domain ),
                    'callback'  => 'sanitize_checkbox',
                    'args'      => array(
                        'id'        => 'ric_compounding_period_monthly',
                        'label'     => 'User can select Monthly compounding.',
                        'type'      => 'checkbox'
                    )
                ),
                array(
                    'id'        => 'compounding_period_daily',
                    'title'     => __( 'Daily Compounding', $text_domain ),
                    'callback'  => 'sanitize_checkbox',
                    'args'      => array(
                        'id'        => 'ric_compounding_period_daily',
                        'label'     => 'User can select Daily compounding.',
                        'type'      => 'checkbox'
                    )
                ),
                array(
                    'id'        => 'term_units',
                    'title'     => __( 'Investment Term Units', $text_domain ),
                    'callback'  => 'sanitize_select',
                    'args'      => array(
                        'id'        => 'ric_term_units',
                        'help'      => 'Set whether the Investment Term is calculated in years or months.',
                        'type'      => 'select',
                        'options'       => array(
                            'years'         => __( 'Years', $text_domain ),
                            'months'        => __( 'Months', $text_domain )
                        )
                    )
                )
            )
        ),
        
        // Labels
        array(
            'id'            => 'ric_labels_settings',
            'title'         => __( 'Input Labels', $text_domain ),
            'description'   => __( 'Customize the labels on the calculator inputs.', $text_domain ),
            'fields'        => array(
                array(
                    'id'        => 'principal_label',
                    'title'     => __( 'Principal Label', $text_domain ),
                    'callback'  => 'sanitize_text',
                    'args'      => array(
                        'id'        => 'ric_principal_label',
                        'type'      => 'text'
                    )
                ),
                array(
                    'id'        => 'interest_rate_label',
                    'title'     => __( 'Interest Rate Label', $text_domain ),
                    'callback'  => 'sanitize_text',
                    'args'      => array(
                        'id'        => 'ric_interest_rate_label',
                        'type'      => 'text'
                    )
                ),
                array(
                    'id'        => 'term_label',
                    'title'     => __( 'Investment Term Label', $text_domain ),
                    'callback'  => 'sanitize_text',
                    'args'      => array(
                        'id'        => 'ric_term_label',
                        'type'      => 'text'
                    )
                ),
                array(
                    'id'        => 'compounding_period_label',
                    'title'     => __( 'Compounding Period Label', $text_domain ),
                    'callback'  => 'sanitize_text',
                    'args'      => array(
                        'id'        => 'ric_compounding_period_label',
                        'type'      => 'text'
                    )
                ),
                array(
                    'id'        => 'submit_label',
                    'title'     => __( 'Submit Label', $text_domain ),
                    'callback'  => 'sanitize_text',
                    'args'      => array(
                        'id'        => 'ric_submit_label',
                        'type'      => 'text'
                    )
                )
            )
        ),
        
        // Default Values
        array(
            'id'            => 'ric_default_values_settings',
            'title'         => __( 'Default Values', $text_domain ),
            'description'   => __( 'Set default values for the calculator inputs.', $text_domain ),
            'fields'        => array(
                array(
                    'id'        => 'principal_default',
                    'title'     => __( 'Principal Default', $text_domain ),
                    'callback'  => 'sanitize_text',
                    'args'      => array(
                        'id'        => 'ric_principal_default',
                        'type'      => 'text'
                    )
                ),
                array(
                    'id'        => 'interest_rate_default',
                    'title'     => __( 'Interest Rate Default', $text_domain ),
                    'callback'  => 'sanitize_text',
                    'args'      => array(
                        'id'        => 'ric_interest_rate_default',
                        'type'      => 'text'
                    )
                ),
                array(
                    'id'        => 'term_default',
                    'title'     => __( 'Term Default', $text_domain ),
                    'callback'  => 'sanitize_text',
                    'args'      => array(
                        'id'        => 'ric_term_default',
                        'type'      => 'text'
                    )
                ),
                array(
                    'id'        => 'compounding_period_default',
                    'title'     => __( 'Compounding Period Default', $text_domain ),
                    'callback'  => 'sanitize_select',
                    'args'      => array(
                        'id'        => 'ric_compounding_period_default',
                        'type'      => 'select',
                        'options'       => array(
                            1           => __( 'Annually', $text_domain ),
                            4           => __( 'Quarterly', $text_domain ),
                            12          => __( 'Monthly', $text_domain ),
                            365         => __( 'Daily', $text_domain )
                        )
                    )
                )
            )
        ),
        
        // HTML Classes
        array(
            'id'            => 'ric_classes_settings',
            'title'         => __( 'Input Classes', $text_domain ),
            'description'   => __( 'Add CSS classes to override styles or to hook into your theme\'s styling.', $text_domain ),
            'fields'        => array(
                array(
                    'id'        => 'principal_class',
                    'title'     => __( 'Principal Class', $text_domain ),
                    'callback'  => 'sanitize_class',
                    'args'      => array(
                        'id'        => 'ric_principal_class',
                        'type'      => 'text'
                    )
                ),
                array(
                    'id'        => 'interest_rate_class',
                    'title'     => __( 'Interest Rate Class', $text_domain ),
                    'callback'  => 'sanitize_class',
                    'args'      => array(
                        'id'        => 'ric_interest_rate_class',
                        'type'      => 'text'
                    )
                ),
                array(
                    'id'        => 'investment_term_class',
                    'title'     => __( 'Investment Term Class', $text_domain ),
                    'callback'  => 'sanitize_class',
                    'args'      => array(
                        'id'        => 'ric_investment_term_class',
                        'type'      => 'text'
                    )
                ),
                array(
                    'id'        => 'compounding_period_class',
                    'title'     => __( 'Compounding Period Class', $text_domain ),
                    'callback'  => 'sanitize_class',
                    'args'      => array(
                        'id'        => 'ric_compounding_period_class',
                        'type'      => 'text'
                    )
                ),
                array(
                    'id'        => 'submit_class',
                    'title'     => __( 'Submit Class', $text_domain ),
                    'callback'  => 'sanitize_class',
                    'args'      => array(
                        'id'        => 'ric_submit_class',
                        'type'      => 'text'
                    )
                )
            )
        ),
        
        // CSS Settings
        array(
            'id'            => 'ric_css_settings',
            'title'         => __( 'CSS Styling', $text_domain ),
            'description'   => __( 'Toggle layout and styling. Remove styling to prevent CSS from loading (but it won\'t be responsive any more).', $text_domain ),
            'fields'        => array(
                array(
                    'id'        => 'css',
                    'title'     => __( 'CSS', $text_domain ),
                    'callback'  => 'sanitize_checkbox',
                    'args'      => array(
                        'id'        => 'ric_css',
                        'label'     => 'Load the CSS file.',
                        'type'      => 'checkbox'
                    )
                ),
                array(
                    'id'        => 'css_responsive',
                    'title'     => __( 'Responsive Layout', $text_domain ),
                    'callback'  => 'sanitize_checkbox',
                    'args'      => array(
                        'id'        => 'ric_css_responsive',
                        'label'     => 'Make the calculator responsive',
                        'type'      => 'checkbox'
                    )
                ),
                array(
                    'id'        => 'css_theme',
                    'title'     => __( 'Theme', $text_domain ),
                    'callback'  => 'sanitize_select',
                    'args'      => array(
                        'id'        => 'ric_css_theme',
                        'type'      => 'select',
                        'help'      => 'Set the general color of the theme. Or set it to none and create your own.',
                        'options'       => array(
                            0           => __( 'None. Use my theme\'s default styling', $text_domain ),
                            'light'     => __( 'Light Theme', $text_domain ),
                            'dark'      => __( 'Dark Theme', $text_domain )
                        )
                    )
                ),
                array(
                    'id'        => 'css_select',
                    'title'     => __( 'Select Box Styling', $text_domain ),
                    'callback'  => 'sanitize_checkbox',
                    'args'      => array(
                        'id'        => 'ric_css_select',
                        'label'     => 'Apply fancy styling to Compounding Period select box.',
                        'type'      => 'checkbox'
                    )
                ),
                array(
                    'id'        => 'css_select_adjust',
                    'title'     => __( 'Select Box Adjustment', $text_domain ),
                    'callback'  => 'sanitize_text',
                    'args'      => array(
                        'id'        => 'ric_css_select_adjust',
                        'type'      => 'text',
                        'help'      => 'Adjust the select box arrow up or down by entering valid dimensions (px, em, rem). For example ".5em".',
                            
                    )
                )
            )
        ),
        
        // Results Display
        array(
            'id'            => 'ric_results_settings',
            'title'         => __( 'Results Settings', $text_domain ),
            'description'   => __( 'Choose the amount of information to display in the results.', $text_domain ),
            'fields'        => array(
                array(
                    'id'        => 'results_display',
                    'title'     => __( 'Results Display', $text_domain ),
                    'callback'  => 'sanitize_select',
                    'args'      => array(
                        'id'        => 'ric_results_display',
                        'type'      => 'select',
                        'options'       => array(
                            0 => __( 'Show the Interest Accrued only', $text_domain ),
                    		1 => __( 'Show the Interest Accrued with a toggle to view the Summary text', $text_domain ), 
                    		2 => __( 'Show both the Interest Accrued and the Summary text', $text_domain ),
                    		3 => __( 'Show the Summary text only', $text_domain )
                        )
                    )
                )
            )
        ),
        
    );
    
    return $definitions;
}
