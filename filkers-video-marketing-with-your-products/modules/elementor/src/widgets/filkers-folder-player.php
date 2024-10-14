<?php

require_once( __DIR__ . '/filkers-base-widget.php' );
require_once( __DIR__ . '/sections/filkers-click-behavior-section.php' );

class Filkers_Folder_Player_Widget extends \Filkers_Base_Widget {

    // Override
    public function get_name() {
        return "filkers-folder-player";
    }

    // Override
    public function get_title() {
        return "Filkers Folder Player";
    }

    // Override
    public function get_icon() {
	    return 'flk-icon flk-folder';
	}

    // Override
    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'uid',
            [
                'label' => __( 'UID to embed'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'string',
                'placeholder' => __( 'Paste your folder UID here'),
            ],
        );

        $this->add_control(
            'size_class',
            [
                'label' => __( 'Size'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'size_auto' => __('Fill'),
                    'size_9_by_16' => __('Vertical 9:16'),
                    'size_4_by_5' => __('Vertical 4:5'),
                    'size_1_by_1' => __('Square'),
                    'size_16_by_9' => __('Horizontal 16:9'),
                    'size_3_by_1' => __('Horizontal 3:1'),
                    'size_4_by_1' => __('Horizontal 4:1'),
                ],
                'default' => 'size_16_by_9'

            ],
        );

        $slider_section = new \Filkers_Slider_Controls_Section();
        $slider_section->add_controls($this);

        $this->add_control(
            'speed',
            [
                'label' => __( 'Playback speed'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [''],
                'range' => [ '' => ['min' => 0.5, 'max' => 2, 'step' => 0.25]],
                'default' => [ 'unit' => '', 'size' => 1]
            ],
        );

        $this->end_controls_section();

        $clickSection = new \Filkers_Click_Behavior_Section();
        $clickSection->add_section($this);


    }

    // Override
    protected function render() {
		$settings = $this->get_settings_for_display();
        $clickSection = new \Filkers_Click_Behavior_Section();

		$this->add_render_attribute('player', [
		    'uid' => $settings['uid'],
		    'class' => $settings['size_class'],
		    'speed' => $settings['speed']['size'],
		]);

        if ( $this->isPreviewMode()) {
            $this->add_render_attribute('player', [
                'edition'       => "",
            ]);
        }

        $slider_section = new \Filkers_Slider_Controls_Section();
        $this->add_render_attribute('player', $slider_section->get_render_attributes($this));

        $this->add_render_attribute('player', $clickSection->get_render_attributes($this));



		echo '<div class="elementor-widget">';
		echo '<filkers-folder '. $this->get_render_attribute_string( 'player' ). ' />';
		echo '</div>';
	}

}