<?php

namespace Filkers\Blocks;

require_once('AbstractControls.php');

class SizeControls extends AbstractControls {

    public $aspectRatio;
    public $width;
    public $height;

    public function __construct(){
        parent::__construct();
        $this->addAttribute('size_ar', array('type' => 'string','default' => 'size_16_by_9'));
        $this->addAttribute('size_width', array('type' => 'string','default' => ''));
        $this->addAttribute('size_height', array('type' => 'string','default' => ''));
    }

    public function parse_attributes($attributes) {
        parent::parse_attributes($attributes);
        $this->aspectRatio = $attributes['size_ar'];
        $this->width = $attributes['size_width'];
        $this->height = $attributes['size_height'];
    }

    public function renderHTMLAttributes() {
        $output = '';
        $output.= ' class="'.$this->aspectRatio.'"';

        $output.= ' style="';
        if ( ! empty($this->width)) {
            $output.= 'width:'.$this->width.';';
        }
        if ( ! empty($this->height)) {
            $output.= 'height:'.$this->height.';';
        }
        $output.= '" ';
        return $output;
    }

}