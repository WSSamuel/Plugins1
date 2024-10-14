<?php

namespace Filkers\Blocks;

require_once('AbstractControls.php');

class SliderControls extends AbstractControls {

    public $arrows;
    public $dots;
    public $random;
    public $limit;

    public function __construct(){
        parent::__construct();
        $this->addAttribute('slider_arrows', array('type' => 'string','default' => 'arrows'));
        $this->addAttribute('slider_dots', array('type' => 'string','default' => 'dots'));
        $this->addAttribute('slider_random', array('type' => 'boolean','default' => false));
        $this->addAttribute('slider_limit', array('type' => 'number','default' => 4));
    }

    public function parse_attributes($attributes) {
        parent::parse_attributes($attributes);
        $this->arrows = $attributes['slider_arrows'];
        $this->dots = $attributes['slider_dots'];
        $this->random = $attributes['slider_random'];
        $this->limit = $attributes['slider_limit'];
    }

    public function renderHTMLAttributes() {
        $output = '';
        if ($this->random) {
            $output.= ' random';
        }
        $output.= ' arrows="'.$this->arrows.'"';
        $output.= ' dots="'.$this->dots.'"';
        $output.= ' ';
        return $output;
    }



}