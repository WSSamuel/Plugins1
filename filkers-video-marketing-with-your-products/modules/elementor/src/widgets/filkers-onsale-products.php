<?php

require_once('filkers-base-product-widget.php');

class Filkers_OnSale_Products_Widget extends Filkers_Base_Product_Widget {

    // Override
    public function get_name() {
        return "filkers-onsale-products";
    }

    // Override
    public function get_title() {
        return "Filkers On Sale Products";
    }

    // Override
    public function get_icon() {
	    return 'flk-icon flk-sales';
	}

    // Override
    protected function set_block_query_args(&$query_args) {
        $query_args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
        $query_args['orderby'] = 'date';
		$query_args['order']   = 'DESC';
    }

}