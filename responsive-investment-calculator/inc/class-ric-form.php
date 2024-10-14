<?php
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'RICForm' ) ) :

class RICForm
{
    private $options;
    
    /**
     * Get the form
     */
    public function get_form()
    {
        $this->options = RICOptions::get_instance();
        
        $html = '';
        
        $html .= '<div class="responsive-investment-calculator">';
        
        $html .= '<form id="ric_form" class="ric_form' . $this->get_form_class() . '" action="' . $this->get_action_url() . '" method="post">';
        
        $html .= $this->get_input( 'principal' );
        $html .= $this->get_input( 'interest_rate' );
        $html .= $this->get_input( 'term' );
        $html .= $this->get_input( 'compounding_period' );
        $html .= $this->get_input( 'submit' );
        
        $html .= '</form><!-- #ric_form -->';
        
        $html .= $this->get_results();
        
        $html .= '</div><!-- .responsive-investment-calculator -->';
        
        return $html;
    }
    
    private function get_action_url()
    {
        $protocol = ( is_ssl() ) ? 'https://' : 'http://';
        return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "#ric_form";
    }
    
    private function get_form_class()
    {
        $responsive = $this->options->get( 'css_responsive' );
        $theme      = $this->options->get( 'css_theme' );
        
        $class = '';
        if ( $responsive ) {
            $class .= ' ric_form_responsive';
        }
        switch ( $theme ) {
            case 'light':
                $class .= ' ric_form_light';
                break;
            case 'dark':
                $class .= ' ric_form_dark';
                break;
            default:
                break;
        }
        
        return $class;
    }
    
    // ***** INPUTS
    
    private function get_input( $name )
    {
        switch ( $name ) {
            case 'principal':
                return $this->get_text_input( 'principal' );
                break;
            case 'interest_rate':
                return $this->get_text_input( 'interest_rate' );
                break;
            case 'term':
                return $this->get_text_input( 'term' );
                break;
            case 'compounding_period':
                if ( $this->options->get( 'compounding_period' ) == 1 ) {
                    return $this->get_select_input( 'compounding_period' );
                }
                else {
                    return $this->get_hidden_input( 'compounding_period' );
                }
                break;
            case 'submit':
                return $this->get_submit_input( 'submit' );
                break;
            default:
                return '';
                break;
        }
    }
    
    private function get_text_input( $name )
    {
        // Label
        $html = $this->get_label( $name );
        
        // Input
        $html .= '<input type="text" class="ric_text_input';
        $html .= $this->get_input_class( $name );
        $html .= '" name="ric_' . $name . '" id="ric_' . $name . '"';
        $html .= $this->get_placeholder( $name );
        $html .= $this->get_value( $name );
        $html .= '/>';
        
        // Error
        $html .= $this->get_error( $name );
        
        return $this->wrap_input( $html );
    }
    
    private function get_select_input( $name )
    {
        // Get the default option
        $default = $this->options->get( $name . '_default' );
        
        if ( ! $default ) $default = $default = $this->options->get_default( $name . '_default' );;
        
        $text_domain = RIC::text_domain();
        
        // Only the compounding period can be displayed as a select input
        $periods = array(
            1   => array(
                'period'    => 'yearly',
                'text'      => __( 'Annually', $text_domain )
            ),
            4   => array(
                'period'    => 'quarterly',
                'text'      => __( 'Quarterly', $text_domain )
            ),
            12  => array(
                'period'    => 'monthly',
                'text'      => __( 'Monthly', $text_domain )
            ),
            365 => array(
                'period'    => 'daily',
                'text'      => __( 'Daily', $text_domain )
            )
        );
        
        $options = array();
        
        foreach ( $periods as $k => $period ) {
            $option = $this->options->get( $name . '_' . $period['period'] );
            if ( $option == 1 ) {
                $options[$k] = $period['text'];
            }
        }
        
        if ( empty( $options ) ) {
            $options[12] = $periods[12]['text'];
        }
        
        $html = '';
        
        // Label
        $html .= $this->get_label( $name );
        
        // Select Wrap
        $html .= '<span';
        $html .= ( $this->options->get( 'css_select') ) ? ' class="ric_select"' : '';
        $html .= '>';
        
        // Select Start
        $html .= '<select class="ric_select_input';
        $html .= $this->get_input_class( $name );
        $html .= '"';
        $html .= ' name="ric_' . $name . '" id="ric_' . $name . '">';
        
        // Options
        foreach ( $options as $k => $v ) {
            $html .= '<option value="' . $k . '" ' . selected( $k, $default, false ) . '>' . $v . '</option>';
        }
        
        // Select Close
        $html .= '</select>';
        
        // Close Wrap
        $html .= '</span>';
        
        // Error
        $html .= $this->get_error( $name );
        
        return $this->wrap_input( $html );
    }
    
    private function get_hidden_input( $name )
    {
        // Only the compounding period can be hidden
        $html = '';
        
        $html .= '<input type="hidden" name="ric_' . $name . '" id="ric_' . $name . '"';
        
        $default = $this->options->get( $name . '_default' );
        if ( ! $default ) $default = $this->options->get_default( $name . '_default' );
        
        $html .= ' value="' . $default . '" />';
        
        return $html;
    }
    
    private function get_submit_input( $name )
    {
        $html = '';
        
        $html .= '<input type="submit" name="ric_' . $name . '" id="ric_' . $name . '"';
        $html .= ' value="' . $this->options->get( $name . '_label' ) . '" />';
        
        return $this->wrap_input( $html );
    }
    
    private function get_label( $name )
    {
        $label = $this->options->get( $name . '_label' );
        
        if ( ! $label ) {
            return '';
        }
        
        return '<label for="ric_' . $name . '">' . esc_html( $label ) . '</label>'; 
    }
    
    private function get_input_class( $name )
    {
        $class = $this->options->get( $name . '_class' );
        
        return ( $class ) ? ' ' . esc_attr( $class ) : '';
    }
    
    private function get_placeholder( $name )
    {
        switch ( $name ) {
            case 'principal':
                $placeholder = $this->options->get( 'currency_symbol' );
                break;
            case 'interest_rate':
                $placeholder = '%';
                break;
            case 'term':
                $placeholder = $this->options->get( 'term_units' );
                switch ( $placeholder ) {
                    case 'months':
                        $placeholder = __( 'months', RIC::text_domain() );
                        break;
                    default:
                        $placeholder = __( 'years', RIC::text_domain() );
                        break;
                }
                break;
            default:
                $placeholder = null;
                break;
        }
        
        if ( ! $placeholder ) {
            return '';
        }
        
        return ' placeholder="' . esc_attr( $placeholder ) . '"';
    }
    
    private function get_value( $name )
    {
        $value = $this->options->get( $name . '_default' );
        
        if ( ! $value ) {
            return '';
        }
        
        return ' value="' . esc_attr( $value ) . '"';
    }
    
    private function get_error( $name )
    {
        return '<span class="ric_' . $name . '_error"></span>';
    }
    
    private function wrap_input( $input )
    {
        return '<div class="ric_input">' . $input . '</div><!-- .ric_input -->';
    }
    
    // ***** RESULTS
    
    private function get_results()
    {
        $html = '';
        
        $display = $this->options->get( 'results_display' );
        
        // Results Wrap
        $html .= '<div class="ric_results_wrap" id="ric_results_wrap" style="display: none;">';
            
        // Short results
        if ( $display != 3 ) {
            $html .= '<div class="ric_results" id="ric_results"></div>';
        }
        
        // Toggle
        if ( $display == 1 ) {
			$html .= '<img id="ric_inspector" class="ric_inspector" src="' . RIC::url() . 'img/icon_inspector.png" alt="Details">';
        }
        
        // Summary
        if ( $display != 0 ) {
            $html .= '<div class="ric_summary" id="ric_summary"></div>';
        }
        
        // Close Wrap
        $html .= '</div><!-- #ric_results_wrap -->';
        
        return $html;
    }
}   
 
endif;
