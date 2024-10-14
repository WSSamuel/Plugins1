<?php

require_once('filkers-base-product-widget.php');

class Filkers_Related_Products_Widget extends Filkers_Base_Product_Widget {

    // Override
    public function get_name() {
        return "filkers-related-products";
    }

    // Override
    public function get_title() {
        return "Filkers Related Products";
    }

    // Override
    public function get_icon() {
	    return 'flk-icon flk-related';
	}

    // Override
    protected function set_block_query_args(&$query_args) {
		$product = wc_get_product();
		$product_ids = array(0);
		if ($product) {
		    $product_ids = array_merge($product_ids, wc_get_related_products($product->get_id()));
		}
        $query_args['post__in'] = $product_ids;
    }


}