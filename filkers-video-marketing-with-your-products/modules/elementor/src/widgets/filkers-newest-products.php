<?php

require_once('filkers-base-product-widget.php');

class Filkers_Newest_Products_Widget extends Filkers_Base_Product_Widget {

    // Override
    public function get_name() {
        return "filkers-newest-products";
    }

    // Override
    public function get_title() {
        return "Filkers Newest Products";
    }

    // Override
    public function get_icon() {
	    return 'flk-icon flk-new';
	}

    // Override
    protected function set_block_query_args(&$query_args) {
        $query_args['orderby'] = 'date';
		$query_args['order']   = 'DESC';
    }

}