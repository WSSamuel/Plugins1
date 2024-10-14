<?php

require_once( __DIR__ . '/sections/filkers-button-settings-section.php' );
require_once( __DIR__ . '/sections/filkers-click-behavior-section.php' );
require_once( __DIR__ . '/sections/filkers-slider-controls-section.php' );


abstract class Filkers_Base_Product_Widget extends \Filkers_Base_Widget {

    // Override
    public function get_style_depends() {
        return array_merge(parent::get_style_depends(), [ 'filkers-products-grid' ]);
    }

    // Override
    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'uid',
            [
                'label' => __( 'UID to embed'),
                'type' => \Filkers_Design_Uid_Control::TYPE,
                'input_type' => 'string',
                'placeholder' => __( 'Paste your folder UID here'),
            ],
        );

        $this->add_control(
            'layout',
            [
				'label' => __( 'Layout'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => [
				    'grid' => __( 'Grid'),
				    'slider' => __( 'Slider'),
				]
            ]
        );


	    $this->add_grid_controls();
	    $this->add_slider_controls();

        $this->add_control(
            'speed',
            [
                'label' => __( 'Playback speed'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [''],
                'range' => [ '' => ['min' => 0.5, 'max' => 2, 'step' => 0.25]],
                'default' => [ 'unit' => '', 'size' => 1]
            ],
        );

        $this->end_controls_section();

        $clickSection = new \Filkers_Click_Behavior_Section();
        $clickSection->add_section($this);

        $buttonStyleSettings = new \Filkers_Button_Settings_Section();
        $buttonStyleSettings->add_section($this);
    }


    protected function add_grid_controls() {
        $grid_condition = [ 'layout' => 'grid'];

        $this->add_control(
            'show_button',
            [
                'label' => __( 'Add to cart button'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'condition' => $grid_condition
            ]
        );

        $this->add_control(
            'grid_columns',
            [
                'label' => __( 'Columns'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [''],
                'range' => [ '' => ['min' => 1, 'max' => 4, 'step' => 1]],
                'default' => [ 'unit' => '', 'size' => 4],
                'condition' => $grid_condition
            ],
        );


    }

    protected function add_slider_controls() {
        $condition = [ 'layout' => 'slider'];
        $slider_section = new \Filkers_Slider_Controls_Section();
        $slider_section->add_controls($this, $condition);
        $this->add_control(
            'products_per_page',
            [
                'label' => __( 'Product count'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 4,
                'condition' => $condition,
                'range' => [
                    'min' => 1,
                    'max' => 8,
                   'step' => 1
                ]
            ]
        );

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

        $query   = new Filkers\Blocks\BlockQuery( $query_args );
        $results = wp_parse_id_list( $is_cacheable ? $query->get_cached_posts( $transient_version ) : $query->get_posts() );

        // Remove ordering query arguments which may have been added by get_catalog_ordering_args.
        WC()->query->remove_ordering_args();

        // Prime caches to reduce future queries.
        if ( is_callable( '_prime_post_caches' ) ) {
            _prime_post_caches( $results );
        }

        return $results;
    }

    protected function get_query_limit() {
   		$settings = $this->get_settings_for_display();
   		if ($settings['layout'] === "grid") {
   		    $columns = $settings['grid_columns']['size'];
   		    if ( $columns % 2 === 0) {
   		        return $columns;
   		    } else {
   		        return $columns + 1;
   		    }
   		} else {
            return $settings['products_per_page'];
   		}
    }

    protected function set_widget_query_args(&$query_args) {}

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

    protected function get_effective_uid_settings() {
        $settings = $this->get_settings_for_display();
        if (empty($settings['uid']['designUid'])) {
            return array(
                "valid" => 1,
                "error" => "",
                "designUid" => "",
                "aspectRatio" => 0.8
            );
        } else {
            return $settings['uid'];
        }
    }

    protected function get_app_id() {
        if (empty(get_option('filkers_api_connection_appid'))) {
            return null;
        } else {
            return get_option('filkers_api_connection_appid');
        }
    }

    protected function get_effective_design_uid() {
        $settings = $this->get_settings_for_display();
        if ($settings['uid']['valid']) {
            return $settings['uid']['designUid'];
        } else {
            return "CRitK-uWqRt0LxnmEsoHWncStW_n8wtWVxa7_5GmluQ";
        }
    }

    // Override
    protected function render() {
        // Test whether WooCommerce is active or not
        if (class_exists('woocommerce') !== true) {
            $this->renderMissingWooCommerceError();
            return;
        }

        // Test whether the data-connector part of the plugin is active or not
        if ($this->get_app_id() === null) {
            $this->renderApiNotConnectedError();
            return;
        }

        $settings = $this->get_settings_for_display();
        $products = array_filter( array_map( 'wc_get_product', $this->get_product_ids() ) );
        if ( $products) {

            echo '<section class="woocommerce products filkers-products-'.$settings['layout'].' ';
            if ( array_key_exists('grid_columns', $settings) ) {
                echo 'columns-'.$settings['grid_columns']['size'];
            }
            echo '" ';
            echo '>';

            if ( $settings['layout'] === "grid") {
                $this->renderGrid($products);
            } else if ( $settings['layout'] === "slider") {
                $this->renderSlider($products);
            }

            echo '</section>';
        }
    }

   protected  function renderApiNotConnectedError() {
        if ($this->isPreviewMode()) {
            echo '<div class="filkers-widget filkers-error">';
            echo 'Your store is not connected with Filkers. <br/> Please go to "Filkers" option on the main Wordpress menu to connect it now.';
            echo '</div>';
        }

        echo '';
    }


   protected  function renderMissingWooCommerceError() {
        if ($this->isPreviewMode()) {
            echo '<div class="filkers-widget filkers-error">';
            echo 'WooCommerce plugin not found. Please install it to use this widget.';
            echo '</div>';
        }

        echo '';
    }

    protected function renderGrid($products) {
   		$settings = $this->get_settings_for_display();

        wc_setup_loop(['columns' => $settings['grid_columns']['size']]);
        woocommerce_product_loop_start();

        $productIdx = 1;
        foreach($products as $card_product) {
            if ($card_product !== null) {
                $this->render_product_card($productIdx, $card_product);
                $productIdx++;
            }
        }

        woocommerce_product_loop_end();
    }

    protected function renderSlider($products) {
        $product_ids = $this->get_product_ids();
        $uidSettings = $this->get_effective_uid_settings();

        $clickSection = new \Filkers_Click_Behavior_Section();
   		$settings = $this->get_settings_for_display();
   		$bottomPaddingPercent = 100 / $uidSettings['aspectRatio'];


        if ( $product_ids) {
            $this->add_render_attribute('slider', [
                'uid'       => $uidSettings["designUid"],
                'speed'     => $settings['speed']['size'],
                'app-id'    => $this->get_app_id(),
                'product-ids' => implode(',',$product_ids),
                'style'     => 'padding-bottom:'.$bottomPaddingPercent.'%;'
            ]);

            $slider_section = new \Filkers_Slider_Controls_Section();
            $this->add_render_attribute('slider', $slider_section->get_render_attributes($this));


            if ( $this->isPreviewMode()) {
                    $this->add_render_attribute('slider', [
                        'edition'       => ''
                    ]);
            }

            $this->add_render_attribute('slider', $clickSection->get_render_attributes($this));


            echo '<filkers-product-slider '.$this->get_render_attribute_string( 'slider' ). '></filkers-product-slider>';
        }
    }

    protected function render_product_button($card_product, $args = array()) {
        global $product;
        $product = $card_product;
        if ( $product ) {
                $defaults = array(
                        'quantity'   => 1,
                        'class'      => implode(
                                ' ',
                                array_filter(
                                        array(
                                                'button',
                                                'product_type_' . $product->get_type(),
                                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                                $product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
                                        )
                                )
                        ),
                        'attributes' => array(
                                'data-product_id'  => $product->get_id(),
                                'data-product_sku' => $product->get_sku(),
                                'aria-label'       => $product->add_to_cart_description(),
                                'rel'              => 'nofollow',
                        ),
                );

                $args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

                if ( isset( $args['attributes']['aria-label'] ) ) {
                        $args['attributes']['aria-label'] = wp_strip_all_tags( $args['attributes']['aria-label'] );
                }

                echo '<div class="filkers-product-add-to-cart" ';
                if ($this->isPreviewMode()) {
                    echo ' style="pointer-events:none;" ';
                }
                echo '>';
                wc_get_template( 'loop/add-to-cart.php', $args );
                echo '</div>';

        }
    }

    protected function render_product_card($index, $product) {

        $prid = $product->get_id();
        $clickSection = new \Filkers_Click_Behavior_Section();
   		$settings = $this->get_settings_for_display();

        $uidSettings = $this->get_effective_uid_settings();
   		$bottomPaddingPercent = 100 / $uidSettings['aspectRatio'];

        echo '<li ';
        wc_product_class( 'filkers-product filkers-product-' . $index, $product );
        echo ' >';

        $this->add_render_attribute('card-'.$prid, [
            'uid'       => $uidSettings['designUid'],
            'app-id'    => $this->get_app_id(),
            'product-id' => $product->get_id(),
            'speed' => $settings['speed']['size'],
            'style' => 'padding-bottom:'.$bottomPaddingPercent.'%;'
        ]);

        if ( $this->isPreviewMode()) {
            $this->add_render_attribute('card-'.$prid, [
                'edition'       => "",
            ]);
        }

        $this->add_render_attribute('card-'.$prid, $clickSection->get_render_attributes($this));

        echo '<filkers-design '.$this->get_render_attribute_string( 'card-'.$prid ). '></filkers-design>';

        if ($settings['show_button'] === 'yes') {
            $this->render_product_button($product);
        }

        echo '</li>';
    }


}