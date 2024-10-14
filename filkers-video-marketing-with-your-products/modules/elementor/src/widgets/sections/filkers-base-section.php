<?php


class Filkers_Base_Section  {

    public function add_section(&$widget){}

    public function add_controls(&$widget, $condition=[]){}

    public function get_render_attributes(&$widget) {
        return [];
    }

}