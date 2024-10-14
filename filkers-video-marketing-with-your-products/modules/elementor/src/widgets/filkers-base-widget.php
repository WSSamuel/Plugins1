<?php



abstract class Filkers_Base_Widget extends \Elementor\Widget_Base {

    public function isPreviewMode() {
        return \Elementor\Plugin::$instance->editor->is_edit_mode();
    }

    // Override
    public function get_script_depends() {
        return [ 'filkers-taglib' ];
    }

    // Override
    public function get_style_depends() {
        return ['filkers-widgets'];
    }

    // Override
    public function get_categories() {
        return [ 'filkers' ];
    }


}