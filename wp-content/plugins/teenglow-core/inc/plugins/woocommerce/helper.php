<?php

if ( ! function_exists( 'teenglow_core_register_product_for_meta_options' ) ) {
	/**
	 * Function that register product post type for meta box options
	 *
	 * @param array $post_types
	 *
	 * @return array
	 */
	function teenglow_core_register_product_for_meta_options( $post_types ) {
		$post_types[] = 'product';

		return $post_types;
	}

	add_filter( 'qode_framework_filter_meta_box_save', 'teenglow_core_register_product_for_meta_options' );
	add_filter( 'qode_framework_filter_meta_box_remove', 'teenglow_core_register_product_for_meta_options' );
}

if ( ! function_exists( 'teenglow_core_woo_get_global_product' ) ) {
	/**
	 * Function that return global WooCommerce object
	 *
	 * @return object
	 */
	function teenglow_core_woo_get_global_product() {
		global $product;

		return $product;
	}
}

if ( ! function_exists( 'teenglow_core_woo_set_admin_options_map_position' ) ) {
	/**
	 * Function that set dashboard admin options map position for this module
	 *
	 * @param int    $position
	 * @param string $map
	 *
	 * @return int
	 */
	function teenglow_core_woo_set_admin_options_map_position( $position, $map ) {

		if ( 'woocommerce' === $map ) {
			$position = 70;
		}

		return $position;
	}

	add_filter( 'teenglow_core_filter_admin_options_map_position', 'teenglow_core_woo_set_admin_options_map_position', 10, 2 );
}

if ( ! function_exists( 'teenglow_core_include_woocommerce_shortcodes' ) ) {
	/**
	 * Function that includes shortcodes
	 */
	function teenglow_core_include_woocommerce_shortcodes() {
		foreach ( glob( TEENGLOW_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/*/include.php' ) as $shortcode ) {
			include_once $shortcode;
		}
	}

	add_action( 'qode_framework_action_before_shortcodes_register', 'teenglow_core_include_woocommerce_shortcodes' );
}

if ( ! function_exists( 'teenglow_core_woo_product_get_rating_html' ) ) {
	/**
	 * Function that return ratings templates
	 *
	 * @param string $html - contains html content
	 * @param float  $rating
	 * @param int    $count - total number of ratings
	 *
	 * @return string
	 */
	function teenglow_core_woo_product_get_rating_html( $html, $rating, $count ) {
		return qode_framework_is_installed( 'theme' ) ? teenglow_woo_product_get_rating_html( $html, $rating, $count ) : '';
	}
}

if ( ! function_exists( 'teenglow_core_set_product_styles' ) ) {
	/**
	 * Function that generates module inline styles
	 *
	 * @param string $style
	 *
	 * @return string
	 */
	function teenglow_core_set_product_styles( $style ) {
		$price_styles        = teenglow_core_get_typography_styles( 'qodef_product_price' );
		$price_single_styles = teenglow_core_get_typography_styles( 'qodef_product_single_price' );

		if ( ! empty( $price_styles ) ) {
			$style .= qode_framework_dynamic_style(
				array(
					'#qodef-woo-page .price',
					'.qodef-woo-shortcode .price',
				),
				$price_styles
			);
		}

		if ( ! empty( $price_single_styles ) ) {
			$style .= qode_framework_dynamic_style(
				array(
					'#qodef-woo-page.qodef--single .entry-summary .price',
				),
				$price_single_styles
			);
		}

		$price_discount_styles        = array();
		$price_discount_color         = teenglow_core_get_option_value( 'admin', 'qodef_product_price_discount_color' );
		$price_single_discount_styles = array();
		$price_single_discount_color  = teenglow_core_get_option_value( 'admin', 'qodef_product_single_price_discount_color' );

		if ( ! empty( $price_discount_color ) ) {
			$price_discount_styles['color'] = $price_discount_color;
		}

		if ( ! empty( $price_single_discount_color ) ) {
			$price_single_discount_styles['color'] = $price_single_discount_color;
		}

		if ( ! empty( $price_discount_styles ) ) {
			$style .= qode_framework_dynamic_style(
				array(
					'#qodef-woo-page .price del',
					'.qodef-woo-shortcode .price del',
				),
				$price_discount_styles
			);
		}

		if ( ! empty( $price_single_discount_styles ) ) {
			$style .= qode_framework_dynamic_style(
				array(
					'#qodef-woo-page.qodef--single .entry-summary .price del',
				),
				$price_single_discount_styles
			);
		}

		$label_styles      = teenglow_core_get_typography_styles( 'qodef_product_label' );
		$info_styles       = teenglow_core_get_typography_styles( 'qodef_product_info' );
		$info_hover_styles = teenglow_core_get_typography_hover_styles( 'qodef_product_info' );

		if ( ! empty( $label_styles ) ) {
			$style .= qode_framework_dynamic_style(
				array(
					'#qodef-woo-page.qodef--single .product_meta .qodef-woo-meta-label',
					'#qodef-woo-page.qodef--single .entry-summary .qodef-custom-label',
				),
				$label_styles
			);
		}

		if ( ! empty( $info_styles ) ) {
			$style .= qode_framework_dynamic_style(
				array(
					'#qodef-woo-page.qodef--single .product_meta .qodef-woo-meta-value',
					'#qodef-woo-page.qodef--single .shop_attributes th',
					'#qodef-woo-page.qodef--single .woocommerce-Reviews .woocommerce-review__author',
				),
				$info_styles
			);
		}

		if ( ! empty( $info_hover_styles ) ) {
			$style .= qode_framework_dynamic_style(
				array(
					'#qodef-woo-page.qodef--single .product_meta .qodef-woo-meta-value a:hover',
				),
				$info_hover_styles
			);
		}

		return $style;
	}

	add_filter( 'teenglow_filter_add_inline_style', 'teenglow_core_set_product_styles' );
}

if ( ! function_exists( 'teenglow_core_generate_woo_product_single_layout' ) ) {
	/**
	 * Function that return default layout for custom post type single page
	 *
	 * @return string
	 */
	function teenglow_core_generate_woo_product_single_layout() {

		$single_template = teenglow_core_get_post_value_through_levels( 'qodef_woo_single_layout', get_the_ID() );
		$single_template = ! empty( $single_template ) ? $single_template : '';

		return $single_template;
	}
}

if ( ! function_exists( 'teenglow_core_load_single_woo_template_hooks' ) ) {
	/**
	 * Function that add hook depend of item layout
	 *
	 */
	function teenglow_core_load_single_woo_template_hooks() {

		if ( is_singular( 'product' ) ) {
			$item_layout = teenglow_core_generate_woo_product_single_layout();

			$item_layout = str_replace( '-', '_', $item_layout );

			do_action( 'teenglow_core_action_load_template_hooks_' . $item_layout );
		}
	}

	add_action( 'wp', 'teenglow_core_load_single_woo_template_hooks' );
}

if ( ! function_exists( 'teenglow_core_set_woo_product_body_classes' ) ) {

	function teenglow_core_set_woo_product_body_classes( $classes ) {
		if ( is_singular( 'product' ) ) {
			$item_layout = teenglow_core_generate_woo_product_single_layout();

			if ( ! empty( $item_layout ) ) {
				$classes[] = ' qodef-product-layout--' . $item_layout;
			}
		}
		
		if ( is_singular( 'product' ) ) {
			$woo_single_layout = '';
			
			if ( teenglow_is_installed( 'core' ) ) {
				$woo_single_layout = teenglow_core_generate_woo_product_single_layout();
			}
			
			if ( 'gallery' !== $woo_single_layout ) {
				
				$product_thumbnail_position = teenglow_is_installed( 'core' ) ? teenglow_get_post_value_through_levels( 'qodef_woo_single_thumb_images_position' ) : 'below';
				$product_thumb_position     = get_post_meta( get_the_ID(), 'qodef_single_thumb_images_position', true );
				
				if ( ! empty( $product_thumb_position ) ) {
					$classes[] = 'qodef-product-layout--thumbs-' . $product_thumb_position;
				} elseif ( ! empty( $product_thumbnail_position ) ) {
					$classes[] = 'qodef-product-layout--thumbs-' . $product_thumbnail_position;
				}
			} else {
				$classes[] = 'qodef-product-layout--gallery';
			}
		}

		return $classes;
	}

	add_filter( 'body_class', 'teenglow_core_set_woo_product_body_classes' );
}

if ( ! function_exists( 'teenglow_core_woo_get_fake_live_viewing_message' ) ) {
	/**
	 * Function for adding fake live viewing message
	 *
	 */
	function teenglow_core_woo_get_fake_live_viewing_message() {
		$fake_lw_enabled = 'yes' === teenglow_core_get_post_value_through_levels( 'qodef_woo_single_enable_fake_live_viewing' );

		if ( $fake_lw_enabled ) {
			$flw_min   = teenglow_core_get_post_value_through_levels( 'qodef_woo_single_fake_live_viewing_min' );
			$flw_min   = ! empty( $flw_min ) ? intval( $flw_min ) : 2;
			$flw_max   = teenglow_core_get_post_value_through_levels( 'qodef_woo_single_fake_live_viewing_max' );
			$flw_max   = ! empty( $flw_max ) ? intval( $flw_max ) : 9;
			$flw_count = wp_rand( $flw_min, $flw_max );
			echo '<div class="qodef-woo-live-viewing">';
			// translators: %s - number of fake live viewers
			echo '<div class="qodef-woo-live-viewing-message">' . teenglow_get_svg_icon( 'eyes' ) . esc_html( sprintf( _n( '%s person currently viewing this item', '%s people currently viewing this item', $flw_count, 'teenglow' ), $flw_count ) ) . '</div>';
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'teenglow_core_woo_get_sales_count_message' ) ) {
	/**
	 * Function for adding sale count message
	 *
	 */
	function teenglow_core_woo_get_sales_count_message() {
		$sale_count_enabled = 'yes' === teenglow_core_get_post_value_through_levels( 'qodef_woo_single_enable_sales_count' );

		if ( $sale_count_enabled ) {
			$sale_count_type = teenglow_core_get_post_value_through_levels( 'qodef_woo_single_sales_count_type' );
			$product         = teenglow_core_woo_get_global_product();

			echo '<div class="qodef-woo-sales-count">';
			if ( 'fake' === $sale_count_type ) {
				$fsc_min         = teenglow_core_get_post_value_through_levels( 'qodef_woo_single_fake_sales_count_min' );
				$fsc_min         = ! empty( $fsc_min ) ? intval( $fsc_min ) : 1;
				$fsc_max         = teenglow_core_get_post_value_through_levels( 'qodef_woo_single_fake_sales_count_max' );
				$fsc_max         = ! empty( $fsc_max ) ? intval( $fsc_max ) : 5;
				$fsc_count       = wp_rand( $fsc_min, $fsc_max );
				$fsc_time_frame  = teenglow_core_get_post_value_through_levels( 'qodef_woo_single_fake_sales_time_frame' );
				$fsc_time_frame  = ! empty( $fsc_time_frame ) ? intval( $fsc_time_frame ) : 3;
				$fsc_time_period = teenglow_core_get_post_value_through_levels( 'qodef_woo_single_fake_sales_time_period' );
				$fsc_time_period = ! empty( $fsc_time_period ) ? $fsc_time_period : 'hour';
				switch ( $fsc_time_period ) {
					case 'minute':
						// translators: %s - time frame
						$fsc_time_period = sprintf( _n( '%s minute', '%s minutes', $fsc_time_frame, 'teenglow' ), $fsc_time_frame );
						break;
					case 'hour':
						// translators: %s - time frame
						$fsc_time_period = sprintf( _n( '%s hour', '%s hours', $fsc_time_frame, 'teenglow' ), $fsc_time_frame );
						break;
					case 'day':
						// translators: %s - time frame
						$fsc_time_period = sprintf( _n( '%s day', '%s days', $fsc_time_frame, 'teenglow' ), $fsc_time_frame );
						break;
					case 'week':
						// translators: %s - time frame
						$fsc_time_period = sprintf( _n( '%s week', '%s weeks', $fsc_time_frame, 'teenglow' ), $fsc_time_frame );
						break;
				}
				echo '<div class="qodef-woo-sales-count-message">';
				teenglow_render_svg_icon( 'fire' );
				// translators: %s - fake sales count
				echo esc_html( sprintf( _n( '%s item sold in last ', '%s items sold in last ', $fsc_count, 'teenglow' ), $fsc_count ) . $fsc_time_period );
				echo '</div>';
			} else {
				$total_sales = $product->get_total_sales();
				// translators: %s - total sales count
				echo '<div class="qodef-woo-sales-count-message">' . teenglow_get_svg_icon( 'fire' ) . esc_html( sprintf( _n( '%s item sold', '%s items sold', $total_sales, 'teenglow' ), $total_sales ) ) . '</div>';
			}
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'teenglow_core_woo_get_sale_booster_features' ) ) {
	/**
	 * Function for adding fake live viewing message and sale count message
	 *
	 */
	function teenglow_core_woo_get_sale_booster_features() {
		$fake_lw_enabled    = 'yes' === teenglow_core_get_post_value_through_levels( 'qodef_woo_single_enable_fake_live_viewing' );
		$sale_count_enabled = 'yes' === teenglow_core_get_post_value_through_levels( 'qodef_woo_single_enable_sales_count' );

		if ( $fake_lw_enabled || $sale_count_enabled ) {
			echo '<div class="qodef-sale-boosters">';
			teenglow_core_woo_get_fake_live_viewing_message();
			teenglow_core_woo_get_sales_count_message();
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'teenglow_core_woo_get_progress_bar' ) ) {
	/**
	 * Function for adding free shipping progress bar
	 *
	 */
	function teenglow_core_woo_get_progress_bar() {
		$progress_bar_enabled = 'yes' === teenglow_core_get_post_value_through_levels( 'qodef_woo_cart_enable_progress_bar' );

		if ( $progress_bar_enabled ) {
			$pb_max               = teenglow_core_get_post_value_through_levels( 'qodef_woo_cart_progress_bar_amount' );
			$pb_prefix            = teenglow_core_get_post_value_through_levels( 'qodef_woo_cart_progress_bar_amount_prefix' );
			$pb_suffix            = teenglow_core_get_post_value_through_levels( 'qodef_woo_cart_progress_bar_amount_suffix' );
			$free_shipping_amount = ! empty( $pb_max ) ? intval( $pb_max ) : 85;
			$cart_subtotal        = 0;

			if ( is_object( WC()->cart ) ) {
				$cart_subtotal = WC()->cart->get_displayed_subtotal();
			}
			echo '<div class="qodef-woo-cart-progress-bar">';
			if ( $cart_subtotal >= $free_shipping_amount ) {
				echo '<div class="qodef-woo-cart-progress-bar-message qodef-full-progress">' . teenglow_get_svg_icon( 'truck' ) . esc_html__( "Congratulations! You've got the free shipping.", 'teenglow' ) . '</div>';
			} else {
				echo '<div class="qodef-woo-cart-progress-bar-message">' . teenglow_get_svg_icon( 'truck' ) . esc_html( $pb_prefix ) . '<span class="qodef-woo-cart-progress-bar-amount">' . teenglow_woo_get_display_price( $free_shipping_amount ) . '</span>' . esc_html( $pb_suffix ) . '</div>';
				if ( class_exists( 'TeenglowCore_Progress_Bar_Shortcode' ) ) {
					$params = array(
						'number'              => intval( ( $cart_subtotal / $free_shipping_amount ) * 100 ),
						'title'               => '',
						'active_line_width'   => 10,
						'active_line_color'   => '#0000b4',
						'inactive_line_width' => 10,
						'inactive_line_color' => '#e6e6e6',
					);
					echo TeenglowCore_Progress_Bar_Shortcode::call_shortcode( $params );
				}
			}
			echo '</div>';
		}
	}
}


if ( ! function_exists( 'teenglow_core_woo_get_countdown' ) ) {
	/**
	 * Function for adding countdown on cart
	 *
	 */
	function teenglow_core_woo_get_countdown() {
		$countdown_enabled = 'yes' === teenglow_core_get_post_value_through_levels( 'qodef_woo_cart_enable_countdown' );

		if ( $countdown_enabled ) {
			$data                 = array();
			$minutes              = teenglow_core_get_post_value_through_levels( 'qodef_woo_cart_countdown_minutes' );
			$minutes              = ! empty( $minutes ) ? intval( $minutes ) : 5;
			$data['data-minutes'] = $minutes;

			echo '<div class="qodef-woo-cart-countdown"' . qode_framework_get_inline_attrs( $data ) . '>';
			echo '<div class="qodef-woo-cart-countdown-message">' . teenglow_get_svg_icon( 'fire' ) . esc_html__( 'Limited quantities available. Checkout within ', 'teenglow' ) . '<span class="qodef-woo-cart-countdown-counter">' . $minutes . ':00</span></div>';
			echo '<div class="qodef-woo-cart-countdown-expired-message qodef--hidden">' . esc_html__( 'You are out of time! Checkout now to avoid losing your order!', 'teenglow' ) . '</div>';
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'teenglow_core_woo_get_cart_sale_booster_features' ) ) {
	/**
	 * Function for adding fake live viewing message and sale count message
	 *
	 */
	function teenglow_core_woo_get_cart_sale_booster_features() {
		$progress_bar_enabled = 'yes' === teenglow_core_get_post_value_through_levels( 'qodef_woo_cart_enable_progress_bar' );
		$countdown_enabled    = 'yes' === teenglow_core_get_post_value_through_levels( 'qodef_woo_cart_enable_countdown' );

		if ( $progress_bar_enabled || $countdown_enabled ) {
			echo '<div class="qodef-sale-boosters">';
			teenglow_core_woo_get_countdown();
			teenglow_core_woo_get_progress_bar();
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'teenglow_core_woo_show_overall_reviews' ) ) {
	/**
	 * Function for adding overall reviews info
	 *
	 */
	function teenglow_core_woo_show_overall_reviews( $reviews_title, $count, $product ) {
		$unset_params = array( 'with_title' );
		return $reviews_title . teenglow_core_list_review_details( 'per-mark', 'rating', $unset_params );
	}
}

if ( ! function_exists( 'teenglow_core_add_rest_api_author_pagination_global_variables' ) ) {
	/**
	 * Extend main rest api variables with new case
	 *
	 * @param array $global - list of variables
	 * @param string $namespace - rest namespace url
	 *
	 * @return array
	 */
	function teenglow_core_add_rest_api_woo_refresh_free_shipping_global_variables( $global, $namespace ) {
		$global['wooFreeShippingRestRoute'] = $namespace . '/woo-refresh-free-shipping';

		return $global;
	}

	add_filter( 'teenglow_filter_rest_api_global_variables', 'teenglow_core_add_rest_api_woo_refresh_free_shipping_global_variables', 10, 2 );
}

if ( ! function_exists( 'teenglow_core_add_rest_api_woo_refresh_free_shipping_route' ) ) {
	/**
	 * Extend main rest api routes with new case
	 *
	 * @param array $routes - list of rest routes
	 *
	 * @return array
	 */
	function teenglow_core_add_rest_api_woo_refresh_free_shipping_route( $routes ) {
		$routes['woo-refresh-free-shipping'] = array(
			'route'    => 'woo-refresh-free-shipping',
			'methods'  => WP_REST_Server::READABLE,
			'callback' => 'teenglow_core_woo_refresh_free_shipping',
			'args'     => array(
				'options' => array(
					'required'          => false,
					'validate_callback' => function ( $param, $request, $key ) {
						// Simple solution for validation can be 'is_array' value instead of callback function
						return is_array( $param ) ? $param : (array) $param;
					},
					'description'       => esc_html__( 'Options data is array with all selected shortcode parameters value', 'teenglow-core' ),
				),
			),
		);

		return $routes;
	}

	add_filter( 'teenglow_filter_rest_api_routes', 'teenglow_core_add_rest_api_woo_refresh_free_shipping_route' );
}

if ( ! function_exists( 'teenglow_core_woo_refresh_free_shipping' ) ) {
	/**
	 * Function for adding overall reviews info
	 *
	 */
	function teenglow_core_woo_refresh_free_shipping() {

		ob_start();
		teenglow_core_woo_get_progress_bar();
		$content = ob_get_contents();
		ob_end_clean();

		qode_framework_get_ajax_status( 'success', esc_html__( 'Html is loaded', 'teenglow-core' ), $content );

	}
}

if ( ! function_exists( 'teenglow_core_remove_from_rest_api' ) ) {
	/**
	 * Function for adding overall reviews info
	 *
	 */
	function teenglow_core_remove_from_rest_api( $is_rest_api_request ) {

		if ( false !== strpos( $_SERVER['REQUEST_URI'], 'woo-refresh-free-shipping' ) ) {
			return false;
		}

		return $is_rest_api_request;
	}

	add_filter( 'woocommerce_is_rest_api_request', 'teenglow_core_remove_from_rest_api' );
}
