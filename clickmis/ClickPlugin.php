<?php

/**
 * @link              https://clickmis.net/
 * @since             1.0.7
 * @package           ClickPlugin
 * 
 * Plugin Name: ClickPlugin
 * Plugin URI: https://clickmis.net/
 * Description: اتصال و همگامسازی وب سایت فروش ووکامرس با حسابداری آنلاین کلیک
 * Version: 1.0.7
 * Author: ClickMis
 * Author URI: https://clickmis.net/
 * License:     GPLv2
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Network:     true
 **/


function ClickMisPlugin_cleans()
{
	try {
		header("Access-Control-Allow-Origin: *");
		ini_set('memory_limit', '-1');
		set_time_limit(1000);
		ini_set('display_errors', 'Off');
		ini_set('error_reporting', 0);
		wc_set_time_limit(1000);

		if (!defined('WP_DEBUG')) define('WP_DEBUG', false);
		if (!defined('WP_DEBUG_LOG')) define('WP_DEBUG_LOG', false);
		if (!defined('WP_DEBUG_DISPLAY')) define('WP_DEBUG_DISPLAY', false);

		function ClickMisPlugin_overrule_webhook_disable_limit($number)
		{
			return 999999;
		}
		add_filter('woocommerce_max_webhook_delivery_failures', 'ClickMisPlugin_overrule_webhook_disable_limit');
	} catch (\Throwable $e) {
	}
}

ClickMisPlugin_cleans();


// try {
// 	function ClickMisPlugin_my_woocommerce_rest_check_permissions($permission, $context, $object_id, $post_type)
// 	{
// 		return true;
// 	}
// 	add_filter('woocommerce_rest_check_permissions', 'ClickMisPlugin_my_woocommerce_rest_check_permissions', 90, 4);
// } catch (\Throwable $e) {
// }

// Hook before calculate fees
// add_action('woocommerce_cart_calculate_fees', 'ClickMisPlugin_rayehe_discount');
// /**
//  * Add custom fee if more than three article
//  * @param WC_Cart $cart
//  */
// function ClickMisPlugin_rayehe_discount(WC_Cart $cart)
// {
// 	//any of your rules
// 	// Calculate the amount to reduce
// 	$totalPrice = $cart->get_subtotal();
// 	$discount = 0;

// 	$coupon_code = null;
// 	if ($totalPrice >= 500000 && $totalPrice <= 3000000) {
// 		//10%
// 		$coupon_code = 'Emam_Reza_10';
// 		$discount = 10;
// 	} else  if ($totalPrice > 3000000 && $totalPrice <= 10000000) {
// 		//15%
// 		$coupon_code = 'Emam_Reza_15';
// 		$discount = 15;
// 	} else  if ($totalPrice > 10000000 && $totalPrice <= 25000000) {
// 		//20%
// 		$coupon_code = 'Emam_Reza_20';
// 		$discount = 20;
// 	} else  if ($totalPrice > 25000000 && $totalPrice <= 50000000) {
// 		//22%
// 		$coupon_code = 'Emam_Reza_22';
// 		$discount = 22;
// 	} else  if ($totalPrice > 50000000 && $totalPrice <= 75000000) {
// 		//24%
// 		$coupon_code = 'Emam_Reza_24';
// 		$discount = 24;
// 	} else  if ($totalPrice > 75000000 && $totalPrice <= 100000000) {
// 		//26%
// 		$coupon_code = 'Emam_Reza_26';
// 		$discount = 26;
// 	} else  if ($totalPrice > 100000000 && $totalPrice <= 150000000) {
// 		//28%
// 		$coupon_code = 'Emam_Reza_28';
// 		$discount = 28;
// 	} else  if ($totalPrice > 150000000) {
// 		//30%
// 		$discount = 30;
// 		$coupon_code = 'Emam_Reza_30';
// 	}


// 	if ($discount > 0) {
// 		$cart->add_fee( 'تخفیف ویژه میلاد امام‌‌رضا‌(ع)' .' '. $discount. 'درصد', - ($discount * $totalPrice / 100));
// 	}

// }

function ClickMisPlugin_init_copons($data)
{
	$couponList = array(
		"Emam_Reza_10" => 10,
		"Emam_Reza_15" => 15,
		"Emam_Reza_20" => 20,
		"Emam_Reza_22" => 22,
		"Emam_Reza_24" => 24,
		"Emam_Reza_26" => 26,
		"Emam_Reza_28" => 28,
		"Emam_Reza_30" => 30
	);

	foreach ($couponList as $x => $val) {
		ClickMisPlugin_create_coupon(
			$x,
			array(
				'discount_type' => 'percent',
				'coupon_amount' => $val,
				'usage_limit' => 1000000
			)
		);
	}
}

function ClickMisPlugin_create_coupon($coupon_name, $args = array())
{

	$coupon_args = array(
		'post_title' => $coupon_name,
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
		'post_type' => 'shop_coupon'
	);

	$coupon_id = wp_insert_post($coupon_args);

	if (!empty($coupon_id) && !is_wp_error($coupon_id)) {
		foreach ($args as $key => $val) {
			update_post_meta($coupon_id, $key, $val);
		}
	}

	return $coupon_id;
}

// add_action('woocommerce_before_cart_table', 'ClickMisPlugin_rayehe_takhfif');
// function ClickMisPlugin_rayehe_takhfif()
// {
// 	global $woocommerce;

// 	$totalPrice = $woocommerce->cart->get_cart_total();
// 	$coupon_code = null;
// 	if ($totalPrice >= 500000 && $totalPrice <= 3000000) {
// 		//10%
// 		$coupon_code = 'Emam_Reza_10';
// 	} else  if ($totalPrice > 3000000 && $totalPrice <= 10000000) {
// 		//15%
// 		$coupon_code = 'Emam_Reza_15';
// 	} else  if ($totalPrice > 10000000 && $totalPrice <= 25000000) {
// 		//20%
// 		$coupon_code = 'Emam_Reza_20';
// 	} else  if ($totalPrice > 25000000 && $totalPrice <= 50000000) {
// 		//22%
// 		$coupon_code = 'Emam_Reza_22';
// 	} else  if ($totalPrice > 50000000 && $totalPrice <= 75000000) {
// 		//24%
// 		$coupon_code = 'Emam_Reza_24';
// 	} else  if ($totalPrice > 75000000 && $totalPrice <= 100000000) {
// 		//26%
// 		$coupon_code = 'Emam_Reza_26';
// 	} else  if ($totalPrice > 100000000 && $totalPrice <= 150000000) {
// 		//28%
// 		$coupon_code = 'Emam_Reza_28';
// 	} else  if ($totalPrice > 150000000) {
// 		//30%
// 		$coupon_code = 'Emam_Reza_30';
// 	}


// 	if ($coupon_code != null) {

// 		if (!$woocommerce->cart->add_discount(sanitize_text_field($coupon_code))) {
// 			$woocommerce->show_messages();
// 		}
// 		// echo '<div class="woocommerce_message"><strong>Your order is over 100 lbs so a 10% Discount has been Applied!</strong> Your total order weight is <strong>' . $total_weight . '</strong> lbs.</div>';
// 	}
// }

/* Mod: Remove 10% Discount for weight less than or equal to 100 lbs */
// add_action('woocommerce_before_cart_table', 'ClickMisPlugin_rayehe_takhfif_remove');
// function ClickMisPlugin_rayehe_takhfif_remove()
// {
// 	global $woocommerce;

// 	$totalPrice = $woocommerce->cart->get_cart_total();
// 	$coupon_code = null;
// 	if ($totalPrice >= 500000 && $totalPrice <= 3000000) {
// 		//10%
// 		$coupon_code = 'Emam_Reza_10';
// 	} else  if ($totalPrice > 3000000 && $totalPrice <= 10000000) {
// 		//15%
// 		$coupon_code = 'Emam_Reza_15';
// 	} else  if ($totalPrice > 10000000 && $totalPrice <= 25000000) {
// 		//20%
// 		$coupon_code = 'Emam_Reza_20';
// 	} else  if ($totalPrice > 25000000 && $totalPrice <= 50000000) {
// 		//22%
// 		$coupon_code = 'Emam_Reza_22';
// 	} else  if ($totalPrice > 50000000 && $totalPrice <= 75000000) {
// 		//24%
// 		$coupon_code = 'Emam_Reza_24';
// 	} else  if ($totalPrice > 75000000 && $totalPrice <= 100000000) {
// 		//26%
// 		$coupon_code = 'Emam_Reza_26';
// 	} else  if ($totalPrice > 100000000 && $totalPrice <= 150000000) {
// 		//28%
// 		$coupon_code = 'Emam_Reza_26';
// 	} else  if ($totalPrice > 150000000) {
// 		//30%
// 		$coupon_code = 'Emam_Reza_30';
// 	}

// 	if ($coupon_code != null) {

// 		$woocommerce->cart->get_applied_coupons();
// 		if (!$woocommerce->cart->remove_coupons(sanitize_text_field($coupon_code))) {
// 			$woocommerce->show_messages();
// 		}
// 		$woocommerce->cart->calculate_totals();
// 	}
// }

function ClickMisPlugin_prepare_date_response($date)
{
	if ($date > '2500-01-01' && method_exists($date, 'date_i18n')) {
		return $date->date_i18n('Y-m-d H:i:s');
	}

	return wc_rest_prepare_date_response($date);
}

/**
 * Get attribute options.
 *
 * @param int   $product_id Product ID.
 * @param array $attribute  Attribute data.
 * @return array
 */
function ClickMisPlugin_get_attribute_options($product_id, $attribute)
{
	if (isset($attribute['is_taxonomy']) && $attribute['is_taxonomy']) {
		return wc_get_product_terms($product_id, $attribute['name'], array('fields' => 'names'));
	} elseif (isset($attribute['value'])) {
		return array_map('trim', explode('|', $attribute['value']));
	}

	return array();
}


/**
 * Get taxonomy terms.
 *
 * @param WC_Product $product  Product instance.
 * @param string     $taxonomy Taxonomy slug.
 * @return array
 */
function ClickMisPlugin_get_taxonomy_terms($product, $taxonomy = 'cat')
{
	$terms = array();

	foreach (wc_get_object_terms($product->get_id(), 'product_' . $taxonomy) as $term) {
		$terms[] = array(
			'id'   => $term->term_id,
			'name' => $term->name,
			'slug' => $term->slug,
		);
	}

	return $terms;
}


/**
 * Get the attributes for a product or product variation.
 *
 * @param WC_Product|WC_Product_Variation $product Product instance.
 * @return array
 */
function ClickMisPlugin_get_attributes($product)
{
	$attributes = array();

	if ($product->is_type('variation')) {
		// Variation attributes.
		foreach ($product->get_variation_attributes() as $attribute_name => $attribute) {
			$name = str_replace('attribute_', '', $attribute_name);

			if (!$attribute) {
				continue;
			}

			// Taxonomy-based attributes are prefixed with `pa_`, otherwise simply `attribute_`.
			if (0 === strpos($attribute_name, 'attribute_pa_')) {
				$option_term = get_term_by('slug', $attribute, $name);
				$attributes[] = array(
					'id'     => wc_attribute_taxonomy_id_by_name($name),
					'name'   => ClickMisPlugin_get_attribute_taxonomy_label($name),
					'option' => $option_term && !is_wp_error($option_term) ? $option_term->name : $attribute,
				);
			} else {
				$attributes[] = array(
					'id'     => 0,
					'name'   => $name,
					'option' => $attribute,
				);
			}
		}
	} else {
		foreach ($product->get_attributes() as $attribute) {
			if ($attribute['is_taxonomy']) {
				$attributes[] = array(
					'id'        => wc_attribute_taxonomy_id_by_name($attribute['name']),
					'name'      => ClickMisPlugin_get_attribute_taxonomy_label($attribute['name']),
					'position'  => (int) $attribute['position'],
					'visible'   => (bool) $attribute['is_visible'],
					'variation' => (bool) $attribute['is_variation'],
					'options'   => ClickMisPlugin_get_attribute_options($product->get_id(), $attribute),
				);
			} else {
				$attributes[] = array(
					'id'        => 0,
					'name'      => $attribute['name'],
					'position'  => (int) $attribute['position'],
					'visible'   => (bool) $attribute['is_visible'],
					'variation' => (bool) $attribute['is_variation'],
					'options'   => ClickMisPlugin_get_attribute_options($product->get_id(), $attribute),
				);
			}
		}
	}

	return $attributes;
}

/**
 * Get an individual variation's data.
 *
 * @param WC_Product $product Product instance.
 * @return array
 */
function ClickMisPlugin_get_variation_data($product)
{
	$variations = array();

	foreach ($product->get_children() as $child_id) {
		$variation = wc_get_product($child_id);
		if (!$variation || !$variation->exists()) {
			continue;
		}

		$data = $variation->get_data();

		$variations[] = array(
			'id'                 => $data['id'],
			'sku'                 => $data['sku'],
			'price'                 => $data['price'],
			'regular_price'                 => $data['regular_price'],
			'sale_price'                 => $data['sale_price'],
			'on_sale'                 => $data['on_sale'],
			'manage_stock'                 => $data['manage_stock'],
			'stock_quantity'                 => $data['stock_quantity'],

			'attributes'         => ClickMisPlugin_get_attributes($variation),
			'meta_data'          => $variation->get_meta_data(),

		);

		// $variations[] = array(
		// 	'id'                 => $variation->get_id(),
		// 	'sku'                => $variation->get_sku(),
		// 	'price'              => $variation->get_price(),
		// 	'regular_price'      => $variation->get_regular_price(),
		// 	'sale_price'         => $variation->get_sale_price(),
		// 	'on_sale'            => $variation->is_on_sale(),
		// 	'manage_stock'       => $variation->managing_stock(),
		// 	'stock_quantity'     => $variation->get_stock_quantity(),
		// 	'attributes'         => ClickMisPlugin_get_attributes($variation),
		// 	'meta_data'          => $variation->get_meta_data(),
		// );
	}

	return $variations;
}


/**
 * Get attribute taxonomy label.
 *
 * @param  string $name Taxonomy name.
 * @return string
 */
function ClickMisPlugin_get_attribute_taxonomy_label($name)
{
	try {
		//wp functions
		$tax    = get_taxonomy($name);
		$labels = get_taxonomy_labels($tax);

		return $labels->singular_name;
	} catch (\Throwable $e) {
		return '';
	}
}



function ClickMisPlugin_get_product_data($product)
{
	$variations = ClickMisPlugin_get_variation_data($product);
	// $variations = array();

	$data = array(
		'id'                    => $product->get_id(),
		'name'                  => $product->get_name(),
		'slug'                  => $product->get_slug(),
		//'permalink'             => $product->get_permalink(),
		//'date_created'          => ClickMisPlugin_prepare_date_response( $product->get_date_created() ),
		//'date_modified'         => ClickMisPlugin_prepare_date_response( $product->get_date_modified() ),
		//'type'                  => $product->get_type(),
		'status'                => $product->get_status(),
		//'featured'              => $product->is_featured(),
		//'catalog_visibility'    => $product->get_catalog_visibility(),
		//'description'           => wpautop( do_shortcode( $product->get_description() ) ),
		//'short_description'     => apply_filters( 'woocommerce_short_description', $product->get_short_description() ),
		'sku'                   => $product->get_sku(),
		'price'                 => $product->get_price(),
		'regular_price'         => $product->get_regular_price(),
		'sale_price'            => $product->get_sale_price() ? $product->get_sale_price() : '',
		//'date_on_sale_from'     => $product->get_date_on_sale_from() ? date( 'Y-m-d', $product->get_date_on_sale_from()->getTimestamp() ) : '',
		//'date_on_sale_to'       => $product->get_date_on_sale_to() ? date( 'Y-m-d', $product->get_date_on_sale_to()->getTimestamp() ) : '',
		//'price_html'            => $product->get_price_html(),
		'on_sale'               => $product->is_on_sale(),
		//'purchasable'           => $product->is_purchasable(),
		//'total_sales'           => $product->get_total_sales(),
		//'virtual'               => $product->is_virtual(),
		//'downloadable'          => $product->is_downloadable(),
		//'downloads'             => $this->get_downloads( $product ),
		//'download_limit'        => $product->get_download_limit(),
		//'download_expiry'       => $product->get_download_expiry(),
		//'download_type'         => 'standard',
		//'external_url'          => $product->is_type( 'external' ) ? $product->get_product_url() : '',
		//'button_text'           => $product->is_type( 'external' ) ? $product->get_button_text() : '',
		//'tax_status'            => $product->get_tax_status(),
		//'tax_class'             => $product->get_tax_class(),
		//'manage_stock'          => $product->managing_stock(),
		'stock_quantity'        => $product->get_stock_quantity(),
		//'in_stock'              => $product->is_in_stock(),
		//'backorders'            => $product->get_backorders(),
		//'backorders_allowed'    => $product->backorders_allowed(),
		//'backordered'           => $product->is_on_backorder(),
		//'sold_individually'     => $product->is_sold_individually(),
		//'weight'                => $product->get_weight(),

		// 'dimensions'            => array(
		// 	'length' => $product->get_length(),
		// 	'width'  => $product->get_width(),
		// 	'height' => $product->get_height(),
		// ),

		// 'shipping_required'     => $product->needs_shipping(),
		// 'shipping_taxable'      => $product->is_shipping_taxable(),
		// 'shipping_class'        => $product->get_shipping_class(),
		// 'shipping_class_id'     => $product->get_shipping_class_id(),
		// 'reviews_allowed'       => $product->get_reviews_allowed(),
		// 'average_rating'        => wc_format_decimal( $product->get_average_rating(), 2 ),
		//'rating_count'          => $product->get_rating_count(),
		//'related_ids'           => array_map( 'absint', array_values( wc_get_related_products( $product->get_id() ) ) ),
		//'upsell_ids'            => array_map( 'absint', $product->get_upsell_ids() ),
		//'cross_sell_ids'        => array_map( 'absint', $product->get_cross_sell_ids() ),
		//'parent_id'             => $product->get_parent_id(),
		//'purchase_note'         => wpautop( do_shortcode( wp_kses_post( $product->get_purchase_note() ) ) ),
		'categories'            => ClickMisPlugin_get_taxonomy_terms($product),
		// 'tags'                  => $this->get_taxonomy_terms( $product, 'tag' ),
		// 'images'                => $this->get_images( $product ),
		'attributes'            => ClickMisPlugin_get_attributes($product),

		'meta_data'         => $product->get_meta_data(),


		//todo farjad
		// 'brands'           		  => get_the_terms($product->get_id(), 'pa_brand'),

		// 'default_attributes'    => $this->get_default_attributes( $product ),
		'variations_data'            => $variations,
		'variations'            => array_map(function ($v) {
			return $v['id'];
		}, $variations),
		// 'grouped_products'      => array(),
		// 'menu_order'            => $product->get_menu_order(),
	);

	return $data;
}

function ClickMisPlugin_get_productsFull2($data)
{
	try {

		ClickMisPlugin_cleans();

		$products = array();

		function ClickMisPlugin_get_productsFull_get2($index, &$products, $data)
		{

			$args = array(
				'limit' => 500,
				'page' => $index + 1,
				// 'status' => 'publish',
			);


			if (isset($data['ids']) && !empty($data['ids'])) {
				$args['include'] =  json_decode($data['ids']);
			}

			$products_query = wc_get_products($args);

			foreach ($products_query as $product) {
				$products[] = ClickMisPlugin_get_product_data($product);
			}

			if (count($products_query) != 500 || empty($products_query)) {
			} else {
				ClickMisPlugin_get_productsFull_get2($index + 1, $products, $data);
			}
		}

		ClickMisPlugin_get_productsFull_get2(0, $products, $data);

		return $products;
	} catch (\Throwable $e) {
		return $e->getMessage();
	}
}

function ClickMisPlugin_get_productsFull($data)
{
	ClickMisPlugin_cleans();

	try {

		$args = array(
			// 'status' => 'publish',
			'posts_per_page' => -1,
		);

		$all_products = array();

		if (isset($data['ids']) && !empty($data['ids'])) {
			$args = array(
				'posts_per_page' => -1,
			);
			$args['include'] =  json_decode($data['ids']);
		} else if (isset($data['includeDraft'])) {
			$args2 = array(
				'status' => 'draft',
				'posts_per_page' => -1,
			);
			$all_products = wc_get_products($args2);
		}

		$products_query  = wc_get_products($args);

		$all_products = array_merge($products_query, $all_products);

		$products = array();
		foreach ($all_products as $product) {
			$products[] = ClickMisPlugin_get_product_data($product);
		}

		return $products;
	} catch (\Throwable $e) {

		return $e->getMessage();
	}
}

function ClickMisPlugin_get_full_products2($data)
{

	$products = array();

	function ClickMisPlugin_get_products_get2($index, &$products, $data)
	{

		$args = array(
			'limit' => 500,
			'page' => $index + 1,
			// 'status' => 'publish',
		);


		if (isset($data['ids']) && !empty($data['ids'])) {
			$args['include'] =  json_decode($data['ids']);
		}

		$products_query = wc_get_products($args);



		foreach ($products_query as $product) {
			array_push(
				$products,
				array(
					'id'                 => $product->get_id(),
					'name'      => $product->get_name(),
					'stock_quantity'     => $product->get_stock_quantity(),
					'price'              => $product->get_price(),

					'sku'              => $product->get_sku(),
					'date_created_gmt'              => ClickMisPlugin_prepare_date_response($product->get_date_created()),
					'categories'            => ClickMisPlugin_get_taxonomy_terms($product),
				)
			);
		}

		if (count($products_query) != 500 || empty($products_query)) {
		} else {
			ClickMisPlugin_get_products_get2($index + 1, $products, $data);
		}
	}

	ClickMisPlugin_get_products_get2(0, $products, $data);

	return $products;
}

function ClickMisPlugin_get_products2($data)
{
	try {

		$result = array();

		function ClickMisPlugin_get_products_get($index, &$result, $request)
		{
			$args = array(
				'limit' => 100,
				'page' => $index + 1,
				// 'status' => 'publish',
			);


			if (isset($request['ids']) && !empty($request['ids'])) {
				$args['include'] =  json_decode($request['ids']);
			}

			$products = wc_get_products($args);

			foreach ($products as $product) {

				$variations = array();
				if ($product->product_type == 'variable') {
					$childs = $product->get_children();

					foreach ($childs as $child) {
						$variation = wc_get_product($child);
						$data = $variation->get_data();
						// $variations[] = $variation->get_data();
						$variations[] = array(
							'id'                 => $data['id'],
							'regular_price'                 => $data['regular_price'],
							'stock_quantity'                 => $data['stock_quantity'],
							'price'                 => $data['price'],
						);
					}
				}

				$result[] = array(
					'id'                 => $product->get_id(),
					'regular_price'      => $product->get_regular_price(),
					'stock_quantity'     => $product->get_stock_quantity(),
					'price'              => $product->get_price(),
					'variations'         => $variations
				);
			}

			if (count($products) != 100 || empty($products)) {
			} else {
				ClickMisPlugin_get_products_get($index + 1, $result, $data);
			}
		}


		ClickMisPlugin_get_products_get(0, $result, $data);


		if (empty($result)) {
			return new WP_Error('no product', array('status' => 404));
		}

		return $result;
	} catch (\Throwable $e) {

		return $e->getMessage();
	}
}


function ClickMisPlugin_get_full_products($data)
{

	$args = array(
		// 'status' => 'publish',
		'posts_per_page' => -1,
	);

	$all_products = array();

	if (isset($data['ids']) && !empty($data['ids'])) {
		$args = array(
			'posts_per_page' => -1,
		);
		$args['include'] =  json_decode($data['ids']);
	} else if (isset($data['includeDraft'])) {
		$args2 = array(
			'status' => 'draft',
			'posts_per_page' => -1,
		);
		$all_products = wc_get_products($args2);
	}

	$products_query  = wc_get_products($args);

	$all_products = array_merge($products_query, $all_products);
	$products_query = $all_products;

	$products = array();
	foreach ($products_query as $product) {
		array_push(
			$products,
			array(
				'id'                 => $product->get_id(),
				'name'      => $product->get_name(),
				'stock_quantity'     => $product->get_stock_quantity(),
				'price'              => $product->get_price(),

				'sku'              => $product->get_sku(),
				'date_created_gmt'              => ClickMisPlugin_prepare_date_response($product->get_date_created()),
				'categories'            => ClickMisPlugin_get_taxonomy_terms($product),
			)
		);
	}

	return $products;






	$args = array(
		// 'status' => 'publish',
		'posts_per_page' => -1,
	);
	$products_query  = wc_get_products($args);

	$products = array();
	foreach ($products_query as $product) {

		$products[] = $product->get_data();
	}

	return $products;
}

function ClickMisPlugin_get_categories($data)
{

	try {
		$args = array(
			'taxonomy' => 'product_cat',
			'get' => 'all'
		);


		$categories = get_categories($args);
		foreach ($categories as $mc) {

			$mc->id = $mc->term_id;
		}

		return $categories;
	} catch (\Throwable $e) {

		return $e->getMessage();
	}

	return '';
}


function ClickMisPlugin_get_products($data)
{
	try {

		$args = array(
			// 'status' => 'publish',
			'posts_per_page' => -1,
		);

		$all_products = array();

		if (isset($data['ids']) && !empty($data['ids'])) {
			$args = array(
				'posts_per_page' => -1,
			);
			$args['include'] =  json_decode($data['ids']);
		} else if (isset($data['includeDraft'])) {
			$args2 = array(
				'status' => 'draft',
				'posts_per_page' => -1,
			);
			$all_products = wc_get_products($args2);
		}

		$products_query  = wc_get_products($args);

		$all_products = array_merge($products_query, $all_products);

		$products = $all_products;

		$result = array();

		foreach ($products as $product) {

			$variations = array();
			if ($product->product_type == 'variable') {
				$childs = $product->get_children();

				foreach ($childs as $child) {
					$variation = wc_get_product($child);
					$data = $variation->get_data();
					// $variations[] = $variation->get_data();
					$variations[] = array(
						'id'                 => $data['id'],
						'regular_price'                 => $data['regular_price'],
						'stock_quantity'                 => $data['stock_quantity'],
						'price'                 => $data['price'],
					);

					// array_push(
					// 	$variations,
					// 	array(
					// 		'id'                 => $variation->get_id(),
					// 		'regular_price'      => $variation->get_regular_price(),
					// 		'stock_quantity'     => $variation->get_stock_quantity(),
					// 		'price'              => $variation->get_price(),
					// 		'data'               => $variation->get_data(),
					// 	)
					// );
				}
			}

			$result[] = array(
				'id'                 => $product->get_id(),
				'regular_price'      => $product->get_regular_price(),
				'stock_quantity'     => $product->get_stock_quantity(),
				'price'              => $product->get_price(),
				'variations'         => $variations
			);
		}


		if (empty($products)) {
			return new WP_Error('no product', array('status' => 404));
		}

		return $result;
	} catch (\Throwable $e) {

		return $e->getMessage();
	}
}

function ClickMisPlugin_get_variations($data)
{


	$defaults = array(
		'numberposts'      => -1,
		'post_type'        => 'product_variation',
		//'post_status'        => 'publish',
		// 'status'        => 'publish',
	);

	$result = get_posts($defaults);



	return $result;
}

function ClickMisPlugin_sync(WP_REST_Request $request)
{

	// return "TODO FARJAD";

	$result = array();

	try {

		$post_data = json_decode($request->get_body());


		foreach ($post_data as $syncItem) {

			try {
				$item = wc_get_product($syncItem->id);


				if (!$item || !$item->exists()) {

					$result[$syncItem->id ?? 'noid'] = 'not found';

					continue;
				}

				if (isset($syncItem->name)) $item->set_name($syncItem->name);
				if (isset($syncItem->short_description))  $item->set_short_description($syncItem->short_description);


				if ($syncItem->product_type != 'variable') {
					if (isset($syncItem->stock_status)) $item->set_stock_status($syncItem->stock_status);
					if (isset($syncItem->stock_quantity)) $item->set_stock_quantity($syncItem->stock_quantity);
					if (isset($syncItem->manage_stock)) $item->set_manage_stock($syncItem->manage_stock);
					if (isset($syncItem->regular_price)) $item->set_regular_price(intval($syncItem->regular_price));
					if (isset($syncItem->price))  $item->set_price(intval($syncItem->price));
					if (isset($syncItem->price))  $item->set_sale_price(intval($syncItem->price));
					if (isset($syncItem->sale_price)) $item->set_sale_price(intval($syncItem->sale_price));
				}


				//TODO rayeheyesib
				if (isset($syncItem->meta_data)) {
					foreach ($syncItem->meta_data as $meta_data) {
						$item->update_meta_data($meta_data->key, $meta_data->value);
					}
				}

				//TODO rayeheyesib
				// $item->update_meta_data('_custom_for_representation_role', '0');
				// $item->update_meta_data('_custom_for_special_representative_role', '0');
				// $item->update_meta_data('_custom_for_wholesaler_role', '0');

				// echo $item;

				$item->save();

				// echo $item;
			} catch (\Throwable $e) {

				$result[$syncItem->id ?? 'noid'] = $e->getMessage();
			}
		}
	} catch (\Throwable $e) {
		$result['plugin'] = $e->getMessage();
	}

	return $result;
}


function ClickMisPlugin_get_orders_full2($data)
{
	$result = [];
	try {

		$customer_orders = get_posts(array(
			//TODO FARJAD	
			'numberposts' => -1,
			'post_type' => wc_get_order_types(),
			'post_status' => 'any',
			// 'meta_value' => ' ',
			// 'meta_compare' => '!=',
			// 'meta_key' => '_customer_user',
			// 'meta_value' => get_current_user_id(),

		));

		foreach ($customer_orders as $order) {

			$order = wc_get_order($order);

			if (!$order) {
				continue;
			}

			if (is_a($order, 'WC_Order_Refund')) {
				continue;
			}

			$data = $order->get_data();


			$result[] = $data;
		}

		return $result;
	} catch (\Throwable $e) {
		return $e->getMessage();
	}

	return $result;
}


function ClickMisPlugin_get_orders_full($data)
{


	$result = [];
	try {



		$query = array(
			//TODO FARJAD	
			'numberposts' => -1,
			'post_type' => wc_get_order_types(),
			'post_status' => 'any',



			// 'meta_value' => ' ',
			// 'meta_compare' => '!=',
			// 'meta_key' => '_customer_user',
			// 'meta_value' => get_current_user_id(),

		);

		if (isset($data['date'])) {

			$query['date_query'] = array(
				'column' => 'post_date',
				'after' => $data['date']
			);
		}

		if (isset($data['ids']) && !empty($data['ids'])) {
			$query['include'] =  json_decode($data['ids']);
		}

		$customer_orders = get_posts($query);

		foreach ($customer_orders as $order) {

			$order = wc_get_order($order);

			if (!$order) {
				continue;
			}

			if (is_a($order, 'WC_Order_Refund')) {
				continue;
			}

			$data = array(
				'id'                   => $order->get_id(),
				'parent_id'            => $order->get_parent_id(),
				'status'               => $order->get_status(),
				'order_key'            => $order->get_order_key(),
				'number'               => $order->get_order_number(),
				'currency'             => $order->get_currency(),
				'version'              => $order->get_version(),
				'prices_include_tax'   => $order->get_prices_include_tax(),
				'date_created_gmt'         => ClickMisPlugin_prepare_date_response($order->get_date_created()),  // v1 API used UTC.
				'date_modified_gmt'        => ClickMisPlugin_prepare_date_response($order->get_date_modified()), // v1 API used UTC.

				'customer_id'          => $order->get_customer_id(),
				'discount_total'       => $order->get_total_discount(),
				'discount_tax'         => $order->get_discount_tax(),
				'shipping_total'       => $order->get_shipping_total(),
				'shipping_tax'         => $order->get_shipping_tax(),
				'cart_tax'             => $order->get_cart_tax(),
				'total'                => $order->get_total(),
				'total_tax'            => $order->get_total_tax(),
				'payment_method'       => $order->get_payment_method(),
				'payment_method_title' => $order->get_payment_method_title(),
				'transaction_id'       => $order->get_transaction_id(),
				'customer_ip_address'  => $order->get_customer_ip_address(),
				'customer_user_agent'  => $order->get_customer_user_agent(),
				'created_via'          => $order->get_created_via(),
				'customer_note'        => $order->get_customer_note(),
				'date_completed_gmt'       => ClickMisPlugin_prepare_date_response($order->get_date_completed(), false), // v1 API used local time.
				'date_paid_gmt'            => ClickMisPlugin_prepare_date_response($order->get_date_paid(), false), // v1 API used local time.
				'cart_hash'            => $order->get_cart_hash(),
				'meta_data'          => $order->get_meta_data(),

				// 'shipping_method'          => $order->get_shipping_method(),
				// 'shipping_methods'          => $order->get_shipping_methods(),
			);

			// Add addresses.
			$data['billing']  = $order->get_address('billing');
			$data['shipping'] = $order->get_address('shipping');

			$line_items = [];

			foreach ($order->get_items() as $item_id => $item) {
				$line_items[] = array(
					'id'           => $item_id,
					// 'name'         => $item['name'],
					// 'sku'          => $product_sku,
					'product_id'   => $item->get_product_id(),
					'variation_id' => $item->get_variation_id(),

					'quantity'     => $item['qty'],

					'price'        => $order->get_item_total($item, false, false),
					'subtotal'     => $order->get_line_subtotal($item, false, false),
					'subtotal_tax' => $item['line_subtotal_tax'],
					'total'        => $order->get_line_total($item, false, false),
					'total_tax'    => $item['line_tax'],
					'meta_data'    => $item->get_meta_data(),

				);
			}

			$shipping_lines = [];
			foreach ($order->get_shipping_methods() as $item_id => $item) {
				$d = $item->get_data();
				$d['id'] = $item_id;
				$d['taxes'] = array();
				$shipping_lines[] = $d;
			}

			$fee_items = [];
			foreach ($order->get_items('fee') as $item_id => $item_fee) {
				$fee_items[] = $item_fee->get_data();
			}


			$data['line_items'] = $line_items;
			$data['fee_items'] = $fee_items;
			$data['shipping_lines'] = $shipping_lines;

			$result[] = $data;
		}

		return $result;
	} catch (\Throwable $e) {
		return $e->getMessage();
	}

	return $result;
}

function ClickMisPlugin_get_orders($data)
{
	$result = [];
	try {

		$q = array(
			//TODO FARJAD	
			'numberposts' => -1,
			'post_type' => wc_get_order_types(),
			'post_status' => 'any',
			// 'meta_value' => ' ',
			// 'meta_compare' => '!=',
			// 'meta_key' => '_customer_user',
			// 'meta_value' => get_current_user_id(),

		);

		if (isset($data['ids']) && !empty($data['ids'])) {
			$q['include'] =  json_decode($data['ids']);
		}

		if (isset($data['date'])) {

			$q['date_query'] = array(
				'column' => 'post_date',
				'after' => $data['date']
			);
		}


		$customer_orders = get_posts($q);

		foreach ($customer_orders as $order) {

			$order = wc_get_order($order);

			if (!$order) {
				continue;
			}

			if (is_a($order, 'WC_Order_Refund')) {
				continue;
				// $order = wc_get_order($order->get_parent_id());
			}

			// $result[]  = $order->get_data();



			$result[]  = array(
				'id'            => $order->get_id(),
				'customer_id'            => $order->get_customer_id(),
				'number'        => $order->get_order_number(),
				'shipping'        => $order->get_address('shipping'),
				'billing'        => $order->get_address('billing'),
				'date_created_gmt'          => ClickMisPlugin_prepare_date_response($order->get_date_created()),
				'date_paid_gmt'          => ClickMisPlugin_prepare_date_response($order->get_date_paid()),
				'total'         => $order->get_total(),
				'status'         => $order->get_status(),

				//TODO
				'total_tax'         => $order->get_total_tax(),
				'discount_total'         => $order->get_discount_total(),
				'customer_note'         => $order->get_customer_note(),
				'payment_method_title'         => $order->get_payment_method_title(),
				'shipping_total'         => $order->get_shipping_total(),

			);
		}

		return $result;
	} catch (\Throwable $e) {
		return $e->getMessage();
	}

	return $result;
}

function ClickMisPlugin_get_customers_full($data)
{

	try {

		$result = array();

		$customer_query = new WP_User_Query(
			array(
				'role' => 'customer',
			)
		);

		if (isset($data['ids']) && !empty($data['ids'])) {

			$customer_query = new WP_User_Query(
				array(
					'role' => 'customer',
					'include' => json_decode($data['ids'])
				)
			);
		}

		foreach ($customer_query->results as $user_data) {
			$customer    = new WC_Customer($user_data->ID);

			$data = $customer->get_data();

			$result[] =  array(
				'id'                 => $customer->get_id(),

				'date_created'       => ClickMisPlugin_prepare_date_response($data['date_created'], false),
				'date_created_gmt'   => ClickMisPlugin_prepare_date_response($data['date_created']),
				'date_modified'      => ClickMisPlugin_prepare_date_response($data['date_modified'], false),
				'date_modified_gmt'  => ClickMisPlugin_prepare_date_response($data['date_modified']),

				'email'              => $data['email'],
				'first_name'         => $data['first_name'],
				'last_name'          => $data['last_name'],
				'role'               => $data['role'],
				'username'           => $data['username'],
				'billing'            => $data['billing'],
				'shipping'           => $data['shipping'],
				'is_paying_customer' => $data['is_paying_customer'],
				'avatar_url'         => $customer->get_avatar_url(),
				'meta_data'          => $data['meta_data'],
				'display_name'          => $data['display_name'], //TODO FARJAD
				'orders_count'            => $customer->get_order_count()
			);
		}

		return $result;
	} catch (\Throwable $e) {
		return $e->getMessage();
	}
}


function ClickMisPlugin_get_customers($data)
{
	try {

		$result = array();

		$customer_query = new WP_User_Query(
			array(
				'role' => 'customer',
			)
		);

		if (isset($data['ids']) && !empty($data['ids'])) {

			$customer_query = new WP_User_Query(
				array(
					'role' => 'customer',
					'include' => json_decode($data['ids'])
				)
			);
		}


		foreach ($customer_query->results as $user_data) {
			$customer    = new WC_Customer($user_data->ID);
			$result[] = array(
				'id'            => $customer->get_id(),
				'email'            => $customer->get_email(),
				'first_name'            => $customer->get_first_name(),
				'last_name'            => $customer->get_last_name(),
				'username'            => $customer->get_username(),
				'orders_count'            => $customer->get_order_count(),
				'date_created_gmt'     => ClickMisPlugin_prepare_date_response($customer->get_date_created()),
			);
		}

		return $result;
	} catch (\Throwable $e) {
		return $e->getMessage();
	}
}

function ClickMisPlugin_get_Permission($request)
{
	$auth_header = $request->get_header('Authorization');
	if (strpos($auth_header, 'click') !== false && strpos($auth_header, 'plugin') !== false) {
		return true; // Allow access if both "click" and "plugin" are present in the header
	}
	return false; // Deny access if the header does not meet the criteria
}

function ClickMisPlugin_get_test($request)
{
	$auth_header = $request->get_header('Authorization');
	return $auth_header; // Deny access if the header does not meet the criteria
}


add_action('rest_api_init', function () {

	// register_rest_route('ClickPlugin/v1', '/copons', array(
	// 	'methods' => 'GET',
	// 	'callback' => 'ClickMisPlugin_init_copons',
	// 	'permission_callback' => 'ClickMisPlugin_get_Permission',
	// ));

	register_rest_route('ClickPlugin/v1', '/test', array(
		'methods' => 'GET',
		'callback' => 'ClickMisPlugin_get_test',
		'permission_callback' => 'ClickMisPlugin_get_Permission',
	));

	register_rest_route('ClickPlugin/v1', '/products', array(
		'methods' => 'GET',
		'callback' => 'ClickMisPlugin_get_products2',
		'permission_callback' => 'ClickMisPlugin_get_Permission',
	));

	register_rest_route('ClickPlugin/v1', '/full_products', array(
		'methods' => 'GET',
		'callback' => 'ClickMisPlugin_get_full_products2',
		'permission_callback' => 'ClickMisPlugin_get_Permission',
	));

	register_rest_route('ClickPlugin/v1', '/variations', array(
		'methods' => 'GET',
		'callback' => 'ClickMisPlugin_get_variations',
		'permission_callback' => 'ClickMisPlugin_get_Permission',
	));

	register_rest_route('ClickPlugin/v1', '/sync', array(
		'methods' => 'POST',
		'callback' => 'ClickMisPlugin_sync',
		'permission_callback' => 'ClickMisPlugin_get_Permission',
	));

	register_rest_route('ClickPlugin/v1', '/categories', array(
		'methods' => 'GET',
		'callback' => 'ClickMisPlugin_get_categories',
		'permission_callback' => 'ClickMisPlugin_get_Permission',
	));

	register_rest_route('ClickPlugin/v1', '/productsFull', array(
		'methods' => 'GET',
		'callback' => 'ClickMisPlugin_get_productsFull2',
		'permission_callback' => 'ClickMisPlugin_get_Permission',
	));

	register_rest_route('ClickPlugin/v1', '/orders', array(
		'methods' => 'GET',
		'callback' => 'ClickMisPlugin_get_orders',
		'permission_callback' => 'ClickMisPlugin_get_Permission',
	));

	register_rest_route('ClickPlugin/v1', '/ordersFull', array(
		'methods' => 'GET',
		'callback' => 'ClickMisPlugin_get_orders_full',
		'permission_callback' => 'ClickMisPlugin_get_Permission',
	));

	register_rest_route('ClickPlugin/v1', '/customers', array(
		'methods' => 'GET',
		'callback' => 'ClickMisPlugin_get_customers',
		'permission_callback' => 'ClickMisPlugin_get_Permission',
	));

	register_rest_route('ClickPlugin/v1', '/customersFull', array(
		'methods' => 'GET',
		'callback' => 'ClickMisPlugin_get_customers_full',
		'permission_callback' => 'ClickMisPlugin_get_Permission',
	));
});
