<?php

namespace Filkers\Blocks;

require_once('AbstractControls.php');

class GridControls extends AbstractControls {

    public $columns;
    public $rows;
    public $showButton;

    public function __construct(){
        parent::__construct();
        $this->addAttribute('show_button', array('type' => 'boolean','default' => false));
        $this->addAttribute('grid_columns', array('type' => 'number','default' => 4));
        $this->addAttribute('grid_rows', array('type' => 'number','default' => 1));
    }

    public function parse_attributes($attributes) {
        parent::parse_attributes($attributes);
        $this->columns = $attributes['grid_columns'];
        $this->rows = $attributes['grid_rows'];
        $this->showButton = $attributes['show_button'];
    }

}