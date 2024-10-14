<?php
/*
Plugin Name: Responsive Investment Calculator
Plugin URI: http://liddweaver.com/responsive-mortgage-calculator/
Description: Add a responsive investment calculator widget or use the shortcode [investmentcalculator] or [ric]. Use it to calculate interest accrued on principal.
Version: 1.0.2
Author: liddweaver
Author URI: http://liddweaver.com
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: responsive-investment-calculator
*/


// Prevent direct access
defined('ABSPATH') || die;

// Include the main plugin class
require_once plugin_dir_path( __FILE__ ) . 'inc/class-responsive-investment-calculator.php';

function responsive_investment_calculator() {
    
    $version    = '1.0.2';
    
    $paths      = array(
        'dir'         => plugin_dir_path( __FILE__ ),
        'url'         => plugin_dir_url( __FILE__ ),
        'plugin_file' => __FILE__
    );
    
    $names      = array(
        'plugin_name'   => 'Responsive Investment Calculator',
        'text_domain'   => 'responsive-investment-calculator',
        'option_name'   => 'ric_options',
        'widget_id'     => 'ric_widget'
    );
    
    $shortcodes  = array(
        'investmentcalculator',
        'ric'
    );
    
    $ric = new ResponsiveInvestmentCalculator( $version, $paths, $names, $shortcodes );
}

responsive_investment_calculator();

// -----------------------------------
// That's all, folks!
