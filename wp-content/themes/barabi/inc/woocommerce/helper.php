<?php

if ( ! function_exists( 'barabi_enqueue_woocommerce_css_assets' ) ) {
	/**
	 * Function that enqueue 3rd party plugins script
	 */
	function barabi_enqueue_woocommerce_css_assets() {

		if ( barabi_is_woo_page( 'single' ) && barabi_get_post_value_through_levels( 'qodef_woo_single_enable_image_lightbox' ) === 'magnific-popup' ) {
			wp_enqueue_style( 'magnific-popup' );
			wp_enqueue_script( 'jquery-magnific-popup' );
		}
	}

	add_action( 'barabi_action_before_main_css', 'barabi_enqueue_woocommerce_css_assets' );
}

if ( ! function_exists( 'barabi_is_woo_page' ) ) {
	/**
	 * Function that check WooCommerce pages
	 *
	 * @param string $page
	 *
	 * @return bool
	 */
	function barabi_is_woo_page( $page ) {
		switch ( $page ) {
			case 'shop':
				return function_exists( 'is_shop' ) && is_shop();
			case 'single':
				return is_singular( 'product' );
			case 'cart':
				return function_exists( 'is_cart' ) && is_cart();
			case 'checkout':
				return function_exists( 'is_checkout' ) && is_checkout();
			case 'account':
				return function_exists( 'is_account_page' ) && is_account_page();
			case 'category':
				return function_exists( 'is_product_category' ) && is_product_category();
			case 'tag':
				return function_exists( 'is_product_tag' ) && is_product_tag();
			case 'any':
				return (
					function_exists( 'is_shop' ) && is_shop() ||
					is_singular( 'product' ) ||
					function_exists( 'is_cart' ) && is_cart() ||
					function_exists( 'is_checkout' ) && is_checkout() ||
					function_exists( 'is_account_page' ) && is_account_page() ||
					function_exists( 'is_product_category' ) && is_product_category() ||
					function_exists( 'is_product_tag' ) && is_product_tag()
				);
			case 'archive':
				return ( function_exists( 'is_shop' ) && is_shop() ) || ( function_exists( 'is_product_category' ) && is_product_category() ) || ( function_exists( 'is_product_tag' ) && is_product_tag() );
			default:
				return false;
		}
	}
}

if ( ! function_exists( 'barabi_get_woo_main_page_classes' ) ) {
	/**
	 * Function that return current WooCommerce page class name
	 *
	 * @return string
	 */
	function barabi_get_woo_main_page_classes() {
		$classes = array();

		if ( barabi_is_woo_page( 'shop' ) ) {
			$classes[] = 'qodef--list';
		}

		if ( barabi_is_woo_page( 'single' ) ) {
			$classes[] = 'qodef--single';

			if ( barabi_get_post_value_through_levels( 'qodef_woo_single_enable_image_lightbox' ) === 'photo-swipe' ) {
				$classes[] = 'qodef-popup--photo-swipe';
			}

			if ( barabi_get_post_value_through_levels( 'qodef_woo_single_enable_image_lightbox' ) === 'magnific-popup' ) {
				$classes[] = 'qodef-popup--magnific-popup';
				// add classes to initialize lightbox from theme
				$classes[] = 'qodef-magnific-popup';
				$classes[] = 'qodef-popup-gallery';
			}
		}

		if ( barabi_is_woo_page( 'cart' ) ) {
			$classes[] = 'qodef--cart';
		}

		if ( barabi_is_woo_page( 'checkout' ) ) {
			$classes[] = 'qodef--checkout';
		}

		if ( barabi_is_woo_page( 'account' ) ) {
			$classes[] = 'qodef--account';
		}

		return apply_filters( 'barabi_filter_main_page_classes', implode( ' ', $classes ) );
	}
}

if ( ! function_exists( 'barabi_woo_get_global_product' ) ) {
	/**
	 * Function that return global WooCommerce object
	 *
	 * @return object
	 */
	function barabi_woo_get_global_product() {
		global $product;

		return $product;
	}
}

if ( ! function_exists( 'barabi_woo_get_main_shop_page_id' ) ) {
	/**
	 * Function that return main shop page ID
	 *
	 * @return int
	 */
	function barabi_woo_get_main_shop_page_id() {
		// Get page id from options table
		$shop_id = get_option( 'woocommerce_shop_page_id' );

		if ( ! empty( $shop_id ) ) {
			return $shop_id;
		}

		return false;
	}
}

if ( ! function_exists( 'barabi_woo_set_main_shop_page_id' ) ) {
	/**
	 * Function that set main shop page ID for get_post_meta options
	 *
	 * @param int $post_id
	 *
	 * @return int
	 */
	function barabi_woo_set_main_shop_page_id( $post_id ) {

		if ( barabi_is_woo_page( 'archive' ) || barabi_is_woo_page( 'single' ) ) {
			$shop_id = barabi_woo_get_main_shop_page_id();

			if ( ! empty( $shop_id ) ) {
				$post_id = $shop_id;
			}
		}

		return $post_id;
	}

	add_filter( 'barabi_filter_page_id', 'barabi_woo_set_main_shop_page_id' );
	add_filter( 'qode_framework_filter_page_id', 'barabi_woo_set_main_shop_page_id' );
}

if ( ! function_exists( 'barabi_woo_set_page_title_text' ) ) {
	/**
	 * Function that returns current page title text for WooCommerce pages
	 *
	 * @param string $title
	 *
	 * @return string
	 */
	function barabi_woo_set_page_title_text( $title ) {

		if ( barabi_is_woo_page( 'shop' ) || barabi_is_woo_page( 'single' ) ) {
			$shop_id = barabi_woo_get_main_shop_page_id();

			$title = ! empty( $shop_id ) ? get_the_title( $shop_id ) : esc_html__( 'Shop', 'barabi' );
		} elseif ( barabi_is_woo_page( 'category' ) || barabi_is_woo_page( 'tag' ) ) {
			$taxonomy_slug = barabi_is_woo_page( 'tag' ) ? 'product_tag' : 'product_cat';
			$taxonomy      = get_term( get_queried_object_id(), $taxonomy_slug );

			if ( ! empty( $taxonomy ) ) {
				$title = esc_html( $taxonomy->name );
			}
		}

		return $title;
	}

	add_filter( 'barabi_filter_page_title_text', 'barabi_woo_set_page_title_text' );
}

if ( ! function_exists( 'barabi_woo_breadcrumbs_title' ) ) {
	/**
	 * Improve main breadcrumb template with additional cases
	 *
	 * @param string $wrap_child
	 * @param array $settings
	 *
	 * @return string
	 */
	function barabi_woo_breadcrumbs_title( $wrap_child, $settings ) {
		$shop_id    = barabi_woo_get_main_shop_page_id();
		$shop_title = ! empty( $shop_id ) ? get_the_title( $shop_id ) : esc_html__( 'Shop', 'barabi' );

		if ( barabi_is_woo_page( 'category' ) || barabi_is_woo_page( 'tag' ) ) {
			$wrap_child    = '';
			$taxonomy_slug = barabi_is_woo_page( 'tag' ) ? 'product_tag' : 'product_cat';
			$taxonomy      = get_term( get_queried_object_id(), $taxonomy_slug );

			// Added shop page item
			$wrap_child .= sprintf( $settings['link'], get_the_permalink( $shop_id ), $shop_title ) . $settings['separator'];

			if ( isset( $taxonomy->parent ) && 0 !== $taxonomy->parent ) {
				$parent      = get_term( $taxonomy->parent );
				$wrap_child .= sprintf( $settings['link'], get_term_link( $parent->term_id ), $parent->name ) . $settings['separator'];
			}

			if ( ! empty( $taxonomy ) ) {
				$wrap_child .= sprintf( $settings['current_item'], esc_attr( $taxonomy->name ) );
			}
		} elseif ( barabi_is_woo_page( 'shop' ) && ! is_search() ) {
			$wrap_child .= sprintf( $settings['current_item'], $shop_title );

		} elseif ( barabi_is_woo_page( 'single' ) ) {
			$wrap_child = '';
			$post_terms = wp_get_post_terms( get_the_ID(), 'product_cat' );

			// Added shop page item
			$wrap_child .= sprintf( $settings['link'], get_the_permalink( $shop_id ), $shop_title ) . $settings['separator'];

			// Added taxonomy items
			if ( ! empty( $post_terms ) ) {
				$post_term = $post_terms[0];

				if ( isset( $post_term->parent ) && 0 !== $post_term->parent ) {
					$parent      = get_term( $post_term->parent );
					$wrap_child .= sprintf( $settings['link'], get_term_link( $parent->term_id ), $parent->name ) . $settings['separator'];
				}
				$wrap_child .= sprintf( $settings['link'], get_term_link( $post_term ), $post_term->name ) . $settings['separator'];
			}

			$wrap_child .= sprintf( $settings['current_item'], get_the_title() );
		}

		return $wrap_child;
	}

	add_filter( 'barabi_core_filter_breadcrumbs_content', 'barabi_woo_breadcrumbs_title', 10, 2 );
}

if ( ! function_exists( 'barabi_woo_single_add_theme_supports' ) ) {
	/**
	 * Function that add native WooCommerce supports
	 */
	function barabi_woo_single_add_theme_supports() {
		// Add featured image zoom functionality on product single page
		$is_zoom_enabled = barabi_get_post_value_through_levels( 'qodef_woo_single_enable_image_zoom' ) !== 'no';

		if ( $is_zoom_enabled ) {
			add_theme_support( 'wc-product-gallery-zoom' );
		}

		// Add photo swipe lightbox functionality on product single images page
		$is_photo_swipe_enabled = barabi_get_post_value_through_levels( 'qodef_woo_single_enable_image_lightbox' ) === 'photo-swipe';

		if ( $is_photo_swipe_enabled ) {
			add_theme_support( 'wc-product-gallery-lightbox' );
		}
	}

	add_action( 'wp_loaded', 'barabi_woo_single_add_theme_supports', 11 ); // permission 11 is set because options are init with permission 10 inside framework plugin
}

if ( ! function_exists( 'barabi_woo_single_disable_page_title' ) ) {
	/**
	 * Function that disable page title area for single product page
	 *
	 * @param bool $enable_page_title
	 *
	 * @return bool
	 */
	function barabi_woo_single_disable_page_title( $enable_page_title ) {
		$is_enabled = barabi_get_post_value_through_levels( 'qodef_woo_single_enable_page_title' ) !== 'no';

		if ( ! $is_enabled && barabi_is_woo_page( 'single' ) ) {
			$enable_page_title = false;
		}

		return $enable_page_title;
	}

	add_filter( 'barabi_filter_enable_page_title', 'barabi_woo_single_disable_page_title' );
}

if ( ! function_exists( 'barabi_woo_single_thumb_images_position' ) ) {
	/**
	 * Function that changes the layout of thumbnails on single product page
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	function barabi_woo_single_thumb_images_position( $classes ) {
		global $product;
		$id = $product->get_id();

		$woo_single_layout = '';
		if ( barabi_is_installed( 'core' ) ) {
			$woo_single_layout = barabi_core_generate_woo_product_single_layout();
		}

		if ( 'gallery' !== $woo_single_layout ) {

			$product_thumbnail_position = barabi_is_installed( 'core' ) ? barabi_get_post_value_through_levels( 'qodef_woo_single_thumb_images_position' ) : 'below';
			$product_thumb_position     = get_post_meta( $id, 'qodef_single_thumb_images_position', true );

			if ( ! empty( $product_thumb_position ) ) {
				$classes[] = 'qodef-position--' . $product_thumb_position;
			} elseif ( ! empty( $product_thumbnail_position ) ) {
				$classes[] = 'qodef-position--' . $product_thumbnail_position;
			}
		}

		return $classes;
	}

	add_filter( 'woocommerce_single_product_image_gallery_classes', 'barabi_woo_single_thumb_images_position' );
}

if ( ! function_exists( 'barabi_set_woo_custom_sidebar_name' ) ) {
	/**
	 * Function that return sidebar name
	 *
	 * @param string $sidebar_name
	 *
	 * @return string
	 */
	function barabi_set_woo_custom_sidebar_name( $sidebar_name ) {

		if ( barabi_is_woo_page( 'archive' ) ) {
			$option = barabi_get_post_value_through_levels( 'qodef_woo_product_list_custom_sidebar' );

			if ( isset( $option ) && ! empty( $option ) ) {
				$sidebar_name = $option;
			}
		}

		return $sidebar_name;
	}

	add_filter( 'barabi_filter_sidebar_name', 'barabi_set_woo_custom_sidebar_name' );
}

if ( ! function_exists( 'barabi_set_woo_sidebar_layout' ) ) {
	/**
	 * Function that return sidebar layout
	 *
	 * @param string $layout
	 *
	 * @return string
	 */
	function barabi_set_woo_sidebar_layout( $layout ) {

		if ( barabi_is_woo_page( 'archive' ) ) {
			$option = barabi_get_post_value_through_levels( 'qodef_woo_product_list_sidebar_layout' );

			if ( isset( $option ) && ! empty( $option ) ) {
				$layout = $option;
			}
		}

		return $layout;
	}

	add_filter( 'barabi_filter_sidebar_layout', 'barabi_set_woo_sidebar_layout' );
}

if ( ! function_exists( 'barabi_set_woo_sidebar_grid_gutter_classes' ) ) {
	/**
	 * Function that returns grid gutter classes
	 *
	 * @param string $classes
	 *
	 * @return string
	 */
	function barabi_set_woo_sidebar_grid_gutter_classes( $classes ) {

		if ( barabi_is_woo_page( 'archive' ) ) {
			$option = barabi_get_post_value_through_levels( 'qodef_woo_product_list_sidebar_grid_gutter' );

			if ( isset( $option ) && ! empty( $option ) ) {
				$classes = 'qodef-gutter--' . esc_attr( $option );
			}
		}

		return $classes;
	}

	add_filter( 'barabi_filter_grid_gutter_classes', 'barabi_set_woo_sidebar_grid_gutter_classes' );
}

if ( ! function_exists( 'barabi_set_woo_sidebar_grid_gutter_styles' ) ) {
	/**
	 * Function that returns grid gutter styles
	 *
	 * @param array $styles
	 *
	 * @return array
	 */
	function barabi_set_woo_sidebar_grid_gutter_styles( $styles ) {

		if ( barabi_is_woo_page( 'archive' ) ) {
			$styles = barabi_get_gutter_custom_styles( 'qodef_woo_product_list_sidebar_grid_gutter_' );
		}

		return $styles;
	}

	add_filter( 'barabi_filter_grid_gutter_styles', 'barabi_set_woo_sidebar_grid_gutter_styles' );
}

if ( ! function_exists( 'barabi_set_woo_review_form_fields' ) ) {
	/**
	 * Function that add woo rating to WordPress comment form fields
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	function barabi_set_woo_review_form_fields( $args ) {
		$comment_args = barabi_get_comment_form_args( array( 'comment_placeholder' => esc_attr__( 'Your Review *', 'barabi' ) ) );

		if ( key_exists( 'comment_field', $comment_args ) ) {

			if ( wc_review_ratings_enabled() ) {
				$ratings_html = '<p class="stars qodef-comment-form-ratings">';
				for ( $i = 1; $i <= 5; $i ++ ) {
					$ratings_html .= '<a class="star-' . esc_attr( $i ) . '" href="#">' . esc_html( $i ) . barabi_get_svg_icon( 'star' ) . '</a>';
				}
				$ratings_html .= '</p>';

				// add rating stuff before textarea element
				// copied from wp-content/plugins/woocommerce/templates/single-product-reviews.php
				$comment_args['comment_field'] = '<div class="comment-form-rating">
					<label for="rating">' . esc_html__( 'Your Rating ', 'barabi' ) . ( wc_review_ratings_required() ? '<span class="required">*</span>' : '' ) . '</label>
					' . $ratings_html . '
					<select name="rating" id="rating" required>
						<option value="">' . esc_html__( 'Rate&hellip;', 'barabi' ) . '</option>
						<option value="5">' . esc_html__( 'Perfect', 'barabi' ) . '</option>
						<option value="4">' . esc_html__( 'Good', 'barabi' ) . '</option>
						<option value="3">' . esc_html__( 'Average', 'barabi' ) . '</option>
						<option value="2">' . esc_html__( 'Not that bad', 'barabi' ) . '</option>
						<option value="1">' . esc_html__( 'Very poor', 'barabi' ) . '</option>
					</select>
				</div>' . $comment_args['comment_field'];
			}
		}

		// Removed url field from form
		if ( isset( $comment_args['fields']['url'] ) ) {
			unset( $comment_args['fields']['url'] );
		}

		// Override WooCommerce review arguments with ours
		return array_merge( $args, $comment_args );
	}

	add_filter( 'woocommerce_product_review_comment_form_args', 'barabi_set_woo_review_form_fields' );
}

if ( ! function_exists( 'barabi_woo_single_page_content_styles' ) ) {

	function barabi_woo_single_page_content_styles( $style ) {

		$page_content_style   = array();
		$page_content_padding = barabi_get_post_value_through_levels( 'qodef_woo_single_page_content_padding', get_the_ID() );

		if ( ! empty( $page_content_padding ) ) {
			$page_content_style['padding'] = $page_content_padding;
		}

		if ( ! empty( $page_content_style ) ) {
			$style .= qode_framework_dynamic_style( '.single-product #qodef-page-inner', $page_content_style );
		}

		$page_content_style_mobile   = array();
		$page_content_padding_mobile = barabi_get_post_value_through_levels( 'qodef_woo_single_page_content_padding_mobile', get_the_ID() );

		if ( ! empty( $page_content_padding_mobile ) ) {
			$page_content_style_mobile['padding'] = $page_content_padding_mobile;
		}

		if ( ! empty( $page_content_style_mobile ) ) {
			$style .= qode_framework_dynamic_style_responsive( '.single-product #qodef-page-inner', $page_content_style_mobile, '', '1024' );
		}

		return $style;
	}

	add_filter( 'barabi_filter_add_inline_style', 'barabi_woo_single_page_content_styles' );
}

if ( ! function_exists( 'barabi_adjust_add_to_cart_button' ) ) {
	function barabi_adjust_add_to_cart_button( $add_to_cart_markup, $product, $args ) {
		$button_text = $product->add_to_cart_text();

		if ( ! isset( $args['button_type'] ) || 'simple-with-icon' === $args['button_type'] ) {
			$args['class'] .= ' qodef-simple-with-icon';
			$button_text   .= '<span class="qodef-m-icon">' . barabi_get_svg_icon( 'arrow-right' ) . '</span>';
		}

		if ( isset( $args['button_type'] ) ) {
			if ( 'filled-with-price' === $args['button_type'] ) {
				$args['class'] .= ' qodef-filled-with-price';
				$button_text   .= '<span class="qodef-m-price">' . $product->get_price_html() . '</span>';
			} elseif ( 'simple' === $args['button_type'] ) {
				$args['class'] .= ' qodef-simple';
			}
		}

		return sprintf(
			'<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
			esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
			isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
			barabi_wp_kses_html( 'html', $button_text )
		);
	}

	add_filter( 'woocommerce_loop_add_to_cart_link', 'barabi_adjust_add_to_cart_button', 10, 3 );
}

if ( ! function_exists( 'barabi_woo_get_display_price' ) ) {
	/**
	 * Function that formats price by adding currency to number
	 *
	 * @param mixed $amount
	 * @return string
	 */
	function barabi_woo_get_display_price( $amount ) {
		$currency        = function_exists( 'get_woocommerce_currency' ) ? get_woocommerce_currency() : '';
		$currency_symbol = ! empty( $currency ) && function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol( $currency ) : '';
		$currency_pos    = get_option( 'woocommerce_currency_pos' );
		$currency_pos    = isset( $currency_pos ) && ! empty( $currency_pos ) ? $currency_pos : null;

		switch ( $currency_pos ) {
			case 'left':
				return esc_html( $currency_symbol . $amount );
			case 'right':
				return esc_html( $amount . $currency_symbol );
			case 'left_space':
				return esc_html( $currency_symbol . '&nbsp;' . $amount );
			case 'right_space':
				return esc_html( $amount . '&nbsp;' . $currency_symbol );
			default:
				return esc_html( $amount );
		}
	}
}
