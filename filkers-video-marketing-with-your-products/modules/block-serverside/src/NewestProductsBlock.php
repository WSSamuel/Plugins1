<?php

namespace Filkers\Blocks;

require_once('AbstractProductDataBlock.php');


class NewestProductsBlock extends AbstractProductDataBlock {

    public function __construct() {
        parent::__construct('newest-products');
    }

    // Override
    protected function set_block_query_args(&$query_args) {
        $query_args['orderby'] = 'date';
		$query_args['order']   = 'DESC';
	}

}