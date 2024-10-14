<?php

require_once( __DIR__ . '/filkers-base-section.php' );

class Filkers_Button_Settings_Section extends \Filkers_Base_Section {

    // Override
    public function add_section(&$widget) {
        $widget->start_controls_section(
            'button_settings_section',
            [
                'label' => __( 'Button'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_controls($widget);

        $widget->end_controls_section();
    }

    // Override
    public function add_controls(&$widget, $condition=[]) {

        $buttonSelector = '{{WRAPPER}} .filkers-product-add-to-cart a.button';
        $hoverButtonSelector = '{{WRAPPER}} ul.products li.filkers-product div.filkers-product-add-to-cart a.button:hover';

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'btn_typography',
				'label' => __( 'Typography'),
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => $buttonSelector
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'btn_text_shadow',
				'label' => __( 'Text Shadow'),
                'selector' => $buttonSelector
            ]
        );


        $widget->add_control(
            'heading_1',
            [
				'label' => __( 'Button style (normal)'),
                'type' => \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_button_style_controls($widget, $condition, 'normal', $buttonSelector);

        $widget->add_control(
            'heading_2',
            [
				'label' => __( 'Button style (hover)'),
                'type' => \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_button_style_controls($widget, $condition, 'hover', $hoverButtonSelector);

        $widget->add_control(
            'divider_1',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
				'label' => __( 'Border type'),
                'selector' => $buttonSelector
            ]
        );

        $widget ->add_control(
            'btn_border_radius',
            [
                'label' => __( 'Border Radius'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    $buttonSelector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );



        $widget->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_box_shadow',
				'label' => __( 'Box shadow'),
                'selector' => $buttonSelector
            ]
        );

        $widget->add_control(
            'divider_2',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER
            ]
        );

        $widget ->add_control(
			'btn_padding',
			[
				'label' => __( 'Padding'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					$buttonSelector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


    }

    protected function add_button_style_controls(&$widget, $condition=[], $id, $selector) {
            $widget ->add_control(
    			'btn_text_color_'. $id,
    			[
    				'label' => __( 'Text Color'),
    				'type' => \Elementor\Controls_Manager::COLOR,
    				'selectors' => [
    					$selector,
    				],
    			]
    		);


            $widget->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'btn_background' . $id,
    				'label' => __( 'Background type'),
    				'types' => ['classic', 'gradient'],
                    'selector' => $selector,
                    'fields_options' => [ 'image' => [ 'condition' => ['background' => 'never_show_image']]]
                ]
            );

    }


    // Override
    public function get_render_attributes(&$widget) {
        $attributes = parent::get_render_attributes($widget);
        $settings = $widget->get_settings_for_display();


        return $attributes;
    }



}