<?php

if ( ! function_exists( 'barabi_core_add_product_list_variation_info_on_image' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function barabi_core_add_product_list_variation_info_on_image( $variations ) {
		$variations['info-on-image'] = esc_html__( 'Info On Image', 'barabi-core' );

		return $variations;
	}

	add_filter( 'barabi_core_filter_product_list_layouts', 'barabi_core_add_product_list_variation_info_on_image' );
}

if ( ! function_exists( 'barabi_core_register_shop_list_info_on_image_actions' ) ) {
	/**
	 * Function that override product item layout for current variation type
	 */
	function barabi_core_register_shop_list_info_on_image_actions() {

		// Add additional tags around product list item
		add_action( 'woocommerce_before_shop_loop_item', 'barabi_add_product_list_item_holder', 5 ); // permission 5 is set because woocommerce_template_loop_product_link_open hook is added on 10
		add_action( 'woocommerce_after_shop_loop_item', 'barabi_add_product_list_item_holder_end', 30 ); // permission 30 is set because woocommerce_template_loop_add_to_cart hook is added on 10

		// Add additional tags around product list item image
		add_action( 'woocommerce_before_shop_loop_item_title', 'barabi_add_product_list_item_media_holder', 5 ); // permission 5 is set because woocommerce_show_product_loop_sale_flash hook is added on 10
		add_action( 'woocommerce_before_shop_loop_item_title', 'barabi_add_product_list_item_media_holder_end', 20 ); // permission 30 is set because woocommerce_template_loop_product_thumbnail hook is added on 10

		// Add additional tags around product list item image
		add_action( 'woocommerce_before_shop_loop_item_title', 'barabi_add_product_list_item_media_image_holder', 6 ); // permission 5 is set because woocommerce_show_product_loop_sale_flash hook is added on 10
		add_action( 'woocommerce_before_shop_loop_item_title', 'barabi_add_product_list_item_media_image_holder_end', 14 ); // permission 30 is set because woocommerce_template_loop_product_thumbnail hook is added on 10

		// Add link at the end of woocommerce_before_shop_loop_item_title
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_open', 21 ); // permission 28 is set because barabi_add_product_list_item_media_holder_end is 30
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 22 ); // permission 29 is set because barabi_add_product_list_item_media_holder_end is 30

		// Add additional tags around product list item content
		add_action( 'woocommerce_shop_loop_item_title', 'barabi_add_product_list_item_additional_image_holder', 5 ); // permission 5 is set because woocommerce_template_loop_product_title hook is added on 10
		add_action( 'woocommerce_after_shop_loop_item', 'barabi_add_product_list_item_additional_image_holder_end', 20 ); // permission 30 is set because woocommerce_template_loop_add_to_cart hook is added on 10

		// Add additional tags around categories
		add_action( 'woocommerce_shop_loop_item_title', 'barabi_add_product_list_item_top_and_info_holder', 7 ); // permission 5 is set because woocommerce_template_loop_product_title hook is added on 10
		add_action( 'woocommerce_shop_loop_item_title', 'barabi_add_product_list_item_categories', 8 ); // permission 8 is set to be before woocommerce_template_loop_product_title hook it's added on 10
		add_action( 'woocommerce_shop_loop_item_title', 'barabi_add_product_list_item_top_and_info_holder_end', 9 ); // permission 30 is set because woocommerce_template_loop_add_to_cart hook is added on 10

		// Change add to cart position on product list
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 ); // permission 10 is default
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 19 ); // permission 20 is set because barabi_add_product_list_item_additional_image_holder hook is added on 15
	}

	add_action( 'barabi_core_action_shop_list_item_layout_info-on-image', 'barabi_core_register_shop_list_info_on_image_actions' );
}
