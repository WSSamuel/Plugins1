<?php

namespace Filkers\Blocks;

require_once('AbstractProductDataBlock.php');

class OnSaleProductsBlock extends AbstractProductDataBlock {

    public function __construct() {
        parent::__construct('onsale-products');
    }

    // Override
    protected function set_block_query_args(&$query_args) {
        $query_args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
    }

}
