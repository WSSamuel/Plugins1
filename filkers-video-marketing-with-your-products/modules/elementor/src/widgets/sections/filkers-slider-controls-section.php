<?php

require_once( __DIR__ . '/filkers-base-section.php' );

class Filkers_Slider_Controls_Section extends \Filkers_Base_Section {

    // Override
    public function add_section(&$widget) {
    }

    // Override
    public function add_controls(&$widget, $condition = []) {
        $widget->add_control(
            'dots',
            [
                'label' => __( 'Navigation dots'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'dots',
                'return_value' => 'dots',
                'condition' => $condition
            ],
        );

        $widget->add_control(
            'arrows',
            [
                'label' => __( 'Navigation arrows'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'arrows',
                'return_value' => 'arrows',
                'condition' => $condition
            ],
        );

        $widget->add_control(
            'random',
            [
                'label' => __( 'Start at random element'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'condition' => $condition
            ],
        );

    }

    // Override
    public function get_render_attributes(&$widget) {
        $attributes = parent::get_render_attributes($widget);
        $settings = $widget->get_settings_for_display();

        if ($settings['dots'] === 'dots') {
            $attributes['dots'] = '';
        }

        if ($settings['arrows'] === 'arrows') {
            $attributes['arrows'] = '';
        }

        if ($settings['random'] === 'yes') {
            $attributes['random'] = '';
        }

        return $attributes;
    }



}