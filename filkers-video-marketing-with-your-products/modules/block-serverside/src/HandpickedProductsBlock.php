<?php

namespace Filkers\Blocks;

require_once('AbstractProductDataBlock.php');


class HandpickedProductsBlock extends AbstractProductDataBlock {

    protected $product_ids;

    public function __construct() {
        parent::__construct('handpicked-products');
        $this->addAttribute('product_ids', array('type' => 'array','default' => array()));
    }

    // Override
    protected function parse_attributes($attributes) {
        parent::parse_attributes($attributes);
        $this->product_ids = $attributes['product_ids'];
    }

    // Override
    protected function get_product_ids() {
        return $this->product_ids;
    }

}