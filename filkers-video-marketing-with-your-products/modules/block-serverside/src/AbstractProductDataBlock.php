<?php

namespace Filkers\Blocks;

require_once('BlockQuery.php');
require_once('AbstractServerSideRenderedBlock.php');

require_once('controls/UidControls.php');
require_once('controls/ClickControls.php');
require_once('controls/GridControls.php');
require_once('controls/LayoutControls.php');
require_once('controls/PlaybackControls.php');
require_once('controls/SliderControls.php');

abstract class AbstractProductDataBlock extends AbstractServerSideRenderedBlock {

    private $attributes = array();

    private $wooCommerceActive;

    private $uidControls;
    private $clickControls;
    private $gridControls;
    private $layoutControls;
    private $playbackControls;
    private $sliderControls;

    public function __construct($name) {
        parent::__construct($name);

        $this->uidControls = new UidControls();
        $this->mergeAttributes($this->uidControls);

        $this->clickControls = new ClickControls();
        $this->mergeAttributes($this->clickControls);

        $this->gridControls = new GridControls();
        $this->mergeAttributes($this->gridControls);

        $this->layoutControls = new LayoutControls();
        $this->mergeAttributes($this->layoutControls);

        $this->playbackControls = new PlaybackControls();
        $this->mergeAttributes($this->playbackControls);

        $this->sliderControls = new SliderControls();
        $this->mergeAttributes($this->sliderControls);
    }

    // Override
    protected function parse_attributes($attributes) {
        parent::parse_attributes($attributes);

        // Test whether WooCommerce is active or not
        $this->wooCommerceActive = in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true );

        $this->uidControls->parse_attributes($attributes);
        $this->clickControls->parse_attributes($attributes);
        $this->gridControls->parse_attributes($attributes);
        $this->layoutControls->parse_attributes($attributes);
        $this->playbackControls->parse_attributes($attributes);
        $this->sliderControls->parse_attributes($attributes);
    }

    protected  function renderMissingWooCommerceError($attributes=array(), $content = '') {
        $output = '';
        $output .= '<div class="filkers-block filkers-block-error">';
        $output .= 'WooCommerce plugin not found. <a>Please install it to use this block.</a>';
        $output .= '</div>';
        return $output;
    }

     protected function get_app_id() {
        if (empty(get_option('filkers_api_connection_appid'))) {
            return null;
        } else {
            return get_option('filkers_api_connection_appid');
        }
    }

    // Override
     public function render_callback($attributes=array(), $content = '') {
        $this->parse_attributes($attributes);

        if ($this->wooCommerceActive) {
            return $this->render($attributes,$content);
        } else {
            return $this->renderMissingWooCommerceError($attributes,$content);
        }

    }

    protected function get_query_limit() {
            switch($this->layoutControls->type) {
                case "slider":
                    return $this->sliderControls->limit;

                case "grid":
                    $limit = $this->gridControls->columns * $this->gridControls->rows;
                    if ($limit % 2 === 0) {
                        return $limit;
                    } else {
                        return $limit + 1;
                    }

                default:
                    return 4;
            }

    }

    protected function get_product_ids() {
        $query_args = array(
                'fields'              => 'ids',
    			'post_type'           => 'product',
    			'post_status'         => 'publish',
    			'fields'              => 'ids',
    			'ignore_sticky_posts' => true,
    			'no_found_rows'       => false,
    			'orderby'             => '',
    			'order'               => '',
    			'meta_query'          => WC()->query->get_meta_query(), // phpcs:ignore WordPress.DB.SlowDBQuery
    			'tax_query'           => array(), // phpcs:ignore WordPress.DB.SlowDBQuery
    			'posts_per_page'      => $this->get_query_limit(),
    	);

    	$this->set_block_query_args($query_args);
        $this->set_visibility_query_args( $query_args );

    	$is_cacheable      = (bool) apply_filters( 'woocommerce_blocks_product_grid_is_cacheable', true, $query_args );
        $transient_version = \WC_Cache_Helper::get_transient_version( 'product_query' );

        $query   = new BlockQuery( $query_args );
        $results = wp_parse_id_list( $is_cacheable ? $query->get_cached_posts( $transient_version ) : $query->get_posts() );

        // Remove ordering query arguments which may have been added by get_catalog_ordering_args.
        WC()->query->remove_ordering_args();

        // Prime caches to reduce future queries.
        if ( is_callable( '_prime_post_caches' ) ) {
            _prime_post_caches( $results );
        }

        return $results;
    }

    protected function set_block_query_args(&$query_args) {}

    protected function set_visibility_query_args( &$query_args ) {
        $product_visibility_terms  = wc_get_product_visibility_term_ids();
        $product_visibility_not_in = array( $product_visibility_terms['exclude-from-catalog'] );

        if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
            $product_visibility_not_in[] = $product_visibility_terms['outofstock'];
        }

        $query_args['tax_query'][] = array(
            'taxonomy' => 'product_visibility',
            'field'    => 'term_taxonomy_id',
            'terms'    => $product_visibility_not_in,
            'operator' => 'NOT IN',
        );
    }

    // Override
    protected function render($attributes=array(), $content = '') {
            switch($this->layoutControls->type) {
                case "slider":
                    return $this->renderSlider();

                case "grid":
                    return $this->renderGrid();

                default:
                    return '<h1>'.$this->layoutControls->type.'</h1>';
            }
    }

    protected function renderSlider() {
        $output = '<div class="filkers-block filkers-product-slider">';
            $output .= '<filkers-product-slider ';
                $output .= ' uid="'.$this->uidControls->uid.'"';
                $output .= ' app-id="'.$this->get_app_id().'"';
                $output .= ' product-ids="'.implode(',',$this->get_product_ids()).'" ';
                $output .= $this->preview ? '' : ' edition';
                $output .= $this->sliderControls->renderHTMLAttributes();
                $output .= $this->playbackControls->renderHTMLAttributes();
                $output .= $this->clickControls->renderHTMLAttributes();
                $output .= ' style="padding-bottom:'.$this->uidControls->bottomPaddingPercent.'%;" ';
            $output.= '/>';
        $output .= '</div>';
        return $output;
    }

    protected function renderGrid() {
        $output = '<div class="filkers-block filkers-grid wc-block-grid" >';
        $output .= '<div class="filkers-products wc-block-grid__products columns-'.$this->gridControls->columns.'">';
        $products = array_filter( array_map( 'wc_get_product', $this->get_product_ids() ) );

        $productIdx = 1;
        foreach($products as $product) {
            $output .= $this->render_product_card($productIdx, $product);
            $productIdx++;
        }
        $output .= '</div>';
        $output .= '</div>';
        return $output;
    }

    protected function render_product_button($product) {
        $output = '<div class="flk-product-button wp-block-button wc-block-grid__product-add-to-cart" >';
        $attributes = array(
            'aria-label'       => $product->add_to_cart_description(),
            'data-quantity'    => '1',
            'data-product_id'  => $product->get_id(),
            'data-product_sku' => $product->get_sku(),
            'rel'              => 'nofollow',
            'class'            => 'wp-block-button__link add_to_cart_button',
        );

        if (
            $product->supports( 'ajax_add_to_cart' ) &&
            $product->is_purchasable() &&
            ( $product->is_in_stock() || $product->backorders_allowed() )
        ) {
            $attributes['class'] .= ' ajax_add_to_cart';
        }

        $output .= sprintf(
            '<a href="%s" %s>%s</a>',
            esc_url( $product->add_to_cart_url() ),
            wc_implode_html_attributes( $attributes ),
            esc_html( $product->add_to_cart_text() )
        );
        $output .= '</div>';
        return $output;
    }

    protected function render_product_card($productIdx, $product) {
        $output = '<div';
        $output .= ' class="filkers-product-card wc-block-grid__product filkers-product-'.$productIdx.' "';
        $output .= '>';

            $output .= '<filkers-design';
            $output .= ' uid="' . $this->uidControls->uid . '"';
            $output .= ' product-id="' . $product->get_id() . '"';
            $output .= ' app-id="'.$this->get_app_id().'"';
            $output .= $this->preview ? 'edition' : '';
            $output .= $this->playbackControls->renderHTMLAttributes();
            $output .= $this->clickControls->renderHTMLAttributes();
            $output .= ' style="padding-bottom:'.$this->uidControls->bottomPaddingPercent.'%" ';
            $output .= '>';
            $output .= '</filkers-design>';

            if ($this->gridControls->showButton) {
                $output .= $this->render_product_button($product);
            }

        $output .= '</div>';

        return $output;
    }



}