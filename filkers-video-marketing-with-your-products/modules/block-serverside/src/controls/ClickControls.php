<?php

namespace Filkers\Blocks;

require_once('AbstractControls.php');

class ClickControls extends AbstractControls {

    protected $behavior;
    protected $target;
    protected $href;

    public function __construct(){
        parent::__construct();
        $this->addAttribute('click_behavior', array('type' => 'string','default' => 'default'));
        $this->addAttribute('click_target', array('type' => 'string','default' => '_top'));
        $this->addAttribute('click_href', array('type' => 'string','default' => ''));
    }

    public function parse_attributes($attributes) {
        parent::parse_attributes($attributes);
        $this->behavior = $attributes['click_behavior'];
        $this->target = $attributes['click_target'];
        $this->href = $attributes['click_href'];
    }

    public function renderHTMLAttributes() {
        $output = ' target="'.$this->target.'"';


        if ($this->preview) {
            $output .= ' href="none"';
        } else {
            switch ($this->behavior) {
                case "none":
                    $output .= ' href="none"';
                    break;

                case "custom_href":
                    $output .= ' href="'.$this->href.'"';
                    break;
            }
        }

        $output.=' ';
        return $output;
    }


}