<?php

/**
 * This file adds plugin options to the wordpress customizer
 */

// Add customizer section
add_action( 'customize_register', 'mbwpab_add_section' );
function mbwpab_add_section( $wp_customize ) {

	$wp_customize->add_panel( 'mbwpab_panel', array(
			'title' 			=> 	'Alert Bar',
			'priority' 			=> 	30,
		) 
	);
    
    $wp_customize->add_section( 'mbwpab_style_section' , array(
            'title'       		=> 	'Styles',
            'panel'				=>	'mbwpab_panel',
            'priority'    		=> 	10,
        ) 
    );

    $wp_customize->add_section( 'mbwpab_content_section' , array(
            'title'       		=> 	'Content',
            'panel'				=>	'mbwpab_panel',
            'priority'    		=> 	20,
        ) 
    );

    $wp_customize->add_section( 'mbwpab_display_section' , array(
            'title'       		=> 	'Display',
            'panel'				=>	'mbwpab_panel',
            'priority'    		=> 	30,
        ) 
    );

    $wp_customize->add_setting( 'background' , array(
    		'type'				=>	'option',
            'default'     		=> 	'#F8F0CE',
            'transport'   		=> 	'refresh',
            'sanitize_callback' => 	'sanitize_hex_color',
        ) 
    );

    $wp_customize->add_setting( 'border' , array(
    		'type'				=>	'option',
            'default'     		=> 	'#DEB408',
            'transport'   		=> 	'refresh',
            'sanitize_callback' => 	'sanitize_hex_color',
        ) 
    );

    $wp_customize->add_setting( 'text_color' , array(
    		'type'				=>	'option',
            'default'     		=> 	'#444',
            'transport'   		=> 	'refresh',
            'sanitize_callback' => 	'sanitize_hex_color',
        ) 
    );

    $wp_customize->add_setting( 'font_size' , array(
    		'type'				=>	'option',
            'default'     		=> 	'',
            'transport'   		=> 	'refresh',
            'sanitize_callback' => 	'mbwpab_sanitize_number'
            
        ) 
    );

    $wp_customize->add_setting( 'link_color' , array(
    		'type'				=>	'option',
            'default'     		=> 	'#CD2653',
            'transport'   		=> 	'refresh',
            'sanitize_callback' => 	'sanitize_hex_color',
        ) 
    );

    $wp_customize->add_setting( 'link_hover_color' , array(
    		'type'				=>	'option',
            'default'     		=> 	'#8e0b2e',
            'transport'   		=> 	'refresh',
            'sanitize_callback' => 	'sanitize_hex_color',
        ) 
    );

    $wp_customize->add_setting( 'title' , array(
    		'type'				=>	'option',
            'default'     		=> 	'',
            'transport'   		=> 	'refresh',
            'sanitize_callback'	=>	'sanitize_text_field',
        ) 
    );

    $wp_customize->add_setting( 'message' , array(
    		'type'				=>	'option',
            'default'     		=> 	'',
            'transport'   		=> 	'refresh',
            'sanitize_callback'	=>	'sanitize_textarea_field',
        ) 
    );

    $wp_customize->add_setting( 'cta' , array(
    		'type'				=>	'option',
            'default'     		=> 	'',
            'transport'   		=> 	'refresh',
            'sanitize_callback'	=>	'sanitize_text_field',
        ) 
    );

    $wp_customize->add_setting( 'cta_link' , array(
    		'type'				=>	'option',
            'default'     		=> 	'',
            'transport'   		=> 	'refresh',
            'sanitize_callback'	=>	'mbwpab_sanitize_url',
        ) 
    ); 

    $wp_customize->add_setting( 'cta_target_blank' , array(
            'default'     		=> 	false,
            'transport'   		=> 	'refresh',
        ) 
    ); 

    $wp_customize->add_setting( 'alert_display' , array(
    		'type'				=>	'option',
            'default'     		=> 	'Hide',
            'transport'   		=> 	'refresh',
        ) 
    );

    $wp_customize->add_setting( 'alert_close_display' , array(
            'default'     		=> 	false,
            'transport'   		=> 	'refresh',
        ) 
    ); 

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background', array(
            'label'         	=> 	'Background Color',
            'description'   	=> 	'Set the background color of the alert',
            'section'       	=> 	'mbwpab_style_section',
            'settings'      	=> 	'background',
        )
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'border', array(
            'label'         	=> 	'Border Color',
            'description'   	=> 	'Set the bottom border color of the alert',
            'section'       	=> 	'mbwpab_style_section',
            'settings'      	=> 	'border',
        )
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'text_color', array(
            'label'         	=> 	'Text Color',
            'description'   	=> 	'Set the text color of the alert',
            'section'       	=> 	'mbwpab_style_section',
            'settings'      	=> 	'text_color',
        )
    ) );

    $wp_customize->add_control( 'font_size', array(
            'label'         	=> 	'Font Size (px)',
            'description'   	=> 	'Set the font size.<br>Input 0 for site default. Max 80px.',
            'section'       	=> 	'mbwpab_style_section',
            'settings'      	=> 	'font_size',
            'type'          	=> 	'number',
            'input_attrs'		=>	array(
            	'min' 			=> 	0,
            	'max'			=>	80,
            ),
        )
    );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
            'label'         	=> 	'Link Color',
            'description'   	=> 	'Set the link color of the alert',
            'section'       	=> 	'mbwpab_style_section',
            'settings'      	=> 	'link_color',
        )
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_hover_color', array(
            'label'         	=> 	'Link Hover Color',
            'description'   	=> 	'Set the link hover color of the alert',
            'section'       	=> 	'mbwpab_style_section',
            'settings'      	=> 	'link_hover_color',
        )
    ) );

    $wp_customize->add_control( 'title', array(
            'label'         	=> 	'Title',
            'description'   	=> 	'Add an alert title',
            'section'       	=> 	'mbwpab_content_section',
            'settings'      	=> 	'title',
            'type'          	=> 	'text',
        )
    );

    $wp_customize->add_control( 'message', array(
            'label'         	=> 	'Message',
            'description'   	=> 	'Add an alert message',
            'section'       	=> 	'mbwpab_content_section',
            'settings'      	=> 	'message',
            'type'          	=> 	'textarea',
        )
    );

    $wp_customize->add_control( 'cta', array(
            'label'         	=> 	'Call to Action',
            'description'   	=> 	'Add an alert call to action',
            'section'       	=> 	'mbwpab_content_section',
            'settings'      	=> 	'cta',
            'type'          	=> 	'text',
        )
    );

    $wp_customize->add_control( 'cta_link', array(
            'label'         	=> 	'Call to Action Link',
            'description'   	=> 	'Add a link to the call to action',
            'section'       	=> 	'mbwpab_content_section',
            'settings'      	=> 	'cta_link',
            'type'          	=> 	'url',
            'input_attrs' 		=> 	array(
		    	'placeholder'	=>	'http://www.google.com',
			),
        )
    );

    $wp_customize->add_control( 'cta_target_blank', array(
            'label'         	=> 'Open Link in New Tab',
            'section'       	=> 'mbwpab_content_section',
            'settings'      	=> 'cta_target_blank',
            'type'          	=> 'checkbox',
        )
    );

    $wp_customize->add_control( 'alert_display', array(
            'label'         	=> 	'Display Options',
            'description'   	=> 	'Choose whether to display alert across the entire site, on just the home page or not at all',
            'section'       	=> 	'mbwpab_display_section',
            'settings'      	=> 	'alert_display',
            'type'          	=> 	'radio',
            'choices'       	=> 	array(
                'hide'      	=> 	'Hide',
                'full-site' 	=> 	'Full Site',
                'home-page' 	=> 	'Home Page',
            ),
        )
    );

    $wp_customize->add_control( 'alert_close_display', array(
            'label'         	=> 'Include Close Button',
            'section'       	=> 'mbwpab_display_section',
            'settings'      	=> 'alert_close_display',
            'type'          	=> 'checkbox',
        )
    );

}

// Santize Callbacks
function mbwpab_sanitize_url( $url ) {
  	return esc_url_raw( $url );
}

function mbwpab_sanitize_number( $input, $setting ) {
    $input_attrs 	= 	$setting->manager->get_control( $setting->id )->input_attrs;
    $min 			= 	$input_attrs['min'] ? $input_attrs['min'] : '';
    $max 			= 	$input_attrs['max'] ? $input_attrs['max'] : '';

    if ( isset( $input ) && is_numeric( $input ) ) {
        if ( is_array( $input_attrs ) ) {
            if ( isset( $min ) && is_numeric( $min ) ) {
                if ( $input < $min ) {
                    $input = $min;
                }
            }
            if ( isset( $max ) && is_numeric( $max ) ) {
                if ( $input > $max ) {
                    $input = $max;
                }
            }
        }
        return $input;
    } else {
        return $setting->default;
    }
}