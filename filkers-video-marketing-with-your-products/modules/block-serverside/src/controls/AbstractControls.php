<?php

namespace Filkers\Blocks;

abstract class AbstractControls {

    private $attributes;
    protected $preview;

    public function __construct(){
        $this->attributes = array();
    }

    protected function addAttribute($name, $definition) {
        $this->attributes[$name] = $definition;
    }

    public function get_attributes() {
        return $this->attributes;
    }

    public function parse_attributes($attributes) {
        if (isset($attributes['preview'])) {
            $this->preview = $attributes['preview'];
        } else {
            $this->preview = false;
        }
    }

    public function renderHTMLAttributes() {
        return '';
    }

}