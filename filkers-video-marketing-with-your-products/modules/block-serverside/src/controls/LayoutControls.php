<?php

namespace Filkers\Blocks;

require_once('AbstractControls.php');

class LayoutControls extends AbstractControls {

    public $type;

    public function __construct(){
        parent::__construct();
        $this->addAttribute('layout_type', array('type' => 'string','default' => 'grid'));
    }

    public function parse_attributes($attributes) {
        parent::parse_attributes($attributes);
        $this->type = $attributes['layout_type'];
    }

}