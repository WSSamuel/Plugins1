<?php

namespace Filkers\Blocks;

require_once('AbstractControls.php');

class PlaybackControls extends AbstractControls {

    public $speed;

    public function __construct(){
        parent::__construct();
        $this->addAttribute('playback_speed', array('type' => 'number','default' => 1));
    }

    public function parse_attributes($attributes) {
        parent::parse_attributes($attributes);
        $this->speed = $attributes['playback_speed'];
    }

    public function renderHTMLAttributes() {
        $output = '';
        $output.= ' speed="'.$this->speed.'" ';
        return $output;
    }

}