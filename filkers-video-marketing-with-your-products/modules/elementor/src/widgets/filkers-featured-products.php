<?php

require_once('filkers-base-product-widget.php');

class Filkers_Featured_Products_Widget extends Filkers_Base_Product_Widget {

    // Override
    public function get_name() {
        return "filkers-featured-products";
    }

    // Override
    public function get_title() {
        return "Filkers Featured Products";
    }

    // Override
    public function get_icon() {
	    return 'flk-icon flk-featured';
	}

    // Override
    protected function set_block_query_args(&$query_args) {
        $query_args['post__in'] = array_merge( array( 0 ), wc_get_featured_product_ids() );
        $query_args['orderby'] = 'date';
		$query_args['order']   = 'DESC';
    }


}