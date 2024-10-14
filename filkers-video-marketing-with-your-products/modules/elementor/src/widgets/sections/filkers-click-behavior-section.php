<?php

require_once( __DIR__ . '/filkers-base-section.php' );

class Filkers_Click_Behavior_Section extends \Filkers_Base_Section {

    // Override
    public function add_section(&$widget) {
        $widget->start_controls_section(
            'click_behavior_section',
            [
                'label' => __( 'Click Behavior'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_controls($widget);

        $widget->end_controls_section();
    }

    // Override
    public function add_controls(&$widget, $condition=[]) {
        $widget->add_control(
            'click_behavior',
            [
				'label' => __( 'On click'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'condition' => $condition,
				'options' => [
				    'default' => __( 'Default action'),
				    'custom' => __( 'Go to custom URL'),
				    'none' => __( 'Do nothing')
				]
            ]
        );

        $widget->add_control(
            'click_href',
            [
				'label' => __( 'Custom URL'),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'Type your URL here'),
				'condition' => array_merge($condition, [ 'click_behavior' => 'custom' ])
            ]
        );

        $widget->add_control(
            'click_target',
            [
				'label' => __( 'Open links in a new tab'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
				'return_value' => '_blank',
				'condition' => array_merge($condition, [ 'click_behavior!' => 'none' ]) ,
            ]
        );
    }

    // Override
    public function get_render_attributes(&$widget) {
        $attributes = parent::get_render_attributes($widget);
        $settings = $widget->get_settings_for_display();

        if ($widget->isPreviewMode()) {
            $attributes['href'] = 'none';
        } else {
            switch ($settings['click_behavior']) {
                case "none":
                    $attributes['href'] = 'none';
                    break;

                case "custom":
                    $attributes['href'] = $settings['click_href']['url'];
                    break;

                case "default":
                    break;
            }

            if  ($settings['click_target'] === '_blank') {
                $attributes['target'] = '_blank';
            } else {
                $attributes['target'] = '_top';
            }
        }

        return $attributes;
    }



}