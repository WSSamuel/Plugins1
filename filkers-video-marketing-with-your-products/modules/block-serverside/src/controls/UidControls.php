<?php

namespace Filkers\Blocks;

require_once('AbstractControls.php');

class UidControls extends AbstractControls {

    public $uid;
    public $aspectRatio;
    public $bottomPaddingPercent;


    public function __construct(){
        parent::__construct();
        $this->addAttribute('uid', array('type' => 'string','default' => ''));
        $this->addAttribute('uid_aspect_ratio', array('type' => 'number','default' => 0.8));
    }

    public function parse_attributes($attributes) {
        parent::parse_attributes($attributes);
        $this->uid = $attributes['uid'];
        $this->aspectRatio = $attributes['uid_aspect_ratio'];

        if (isset($this->aspectRatio)) {
            $this->bottomPaddingPercent = 100.0 / $this->aspectRatio;
        }
    }

}