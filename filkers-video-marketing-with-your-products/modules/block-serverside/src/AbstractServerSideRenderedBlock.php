<?php

namespace Filkers\Blocks;

require_once('AbstractBlock.php');

abstract class AbstractServerSideRenderedBlock extends AbstractBlock {

    private $attributes = array();
    protected $preview;


    public function __construct($name) {
        parent::__construct($name);
        $this->addAttribute('preview', array('type' => 'boolean','default' => false));
    }

    protected function addAttribute($name, $definition) {
        $this->attributes[$name] = $definition;
    }

    protected function mergeAttributes($controls) {
        $this->attributes= array_merge($this->attributes, $controls->get_attributes());
    }

    // Override
    protected function parse_attributes($attributes) {
        $this->preview = $attributes['preview'];
    }

    protected abstract function render($attributes=array(), $content = '');

    public function render_callback($attributes=array(), $content = '') {
        $this->parse_attributes($attributes);
        return $this->render($attributes,$content);
    }

    // Override
    protected function getSettings() {
        $parentSettings = parent::getSettings();
        $settings = array_merge($parentSettings, array(
            'attributes' => $this->attributes,
            'render_callback' => [ $this, 'render_callback' ]
        ));
        return $settings;
    }




}