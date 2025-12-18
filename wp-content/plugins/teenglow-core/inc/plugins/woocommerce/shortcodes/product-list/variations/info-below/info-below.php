<?php

if ( ! function_exists( 'teenglow_core_add_product_list_variation_info_below' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_add_product_list_variation_info_below( $variations ) {
		$variations['info-below'] = esc_html__( 'Info Below', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_product_list_layouts', 'teenglow_core_add_product_list_variation_info_below' );
}

if ( ! function_exists( 'teenglow_core_register_shop_list_info_below_actions' ) ) {
	/**
	 * Function that override product item layout for current variation type
	 */
	function teenglow_core_register_shop_list_info_below_actions() {

		// IMPORTANT - THIS CODE NEED TO COPY/PASTE ALSO INTO THEME FOLDER MAIN WOOCOMMERCE FILE - set_default_layout method

        // Add additional tags around product list item
        add_action( 'woocommerce_before_shop_loop_item', 'teenglow_add_product_list_item_holder', 5 ); // permission 5 is set because woocommerce_template_loop_product_link_open hook is added on 10
        add_action( 'woocommerce_after_shop_loop_item', 'teenglow_add_product_list_item_holder_end', 30 ); // permission 30 is set because woocommerce_template_loop_add_to_cart hook is added on 10

        // Add additional tags around product list item image
        add_action( 'woocommerce_before_shop_loop_item_title', 'teenglow_add_product_list_item_media_holder', 5 ); // permission 5 is set because woocommerce_show_product_loop_sale_flash hook is added on 10
        add_action( 'woocommerce_before_shop_loop_item_title', 'teenglow_add_product_list_item_media_holder_end', 20 ); // permission 30 is set because woocommerce_template_loop_product_thumbnail hook is added on 10

        // Add additional tags around product list item image
        add_action( 'woocommerce_before_shop_loop_item_title', 'teenglow_add_product_list_item_media_image_holder', 6 ); // permission 5 is set because woocommerce_show_product_loop_sale_flash hook is added on 10
        add_action( 'woocommerce_before_shop_loop_item_title', 'teenglow_add_product_list_item_media_image_holder_end', 14 ); // permission 30 is set because woocommerce_template_loop_product_thumbnail hook is added on 10

        // Add link at the end of woocommerce_before_shop_loop_item_title
        add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 17 ); // permission 28 is set because teenglow_add_product_list_item_media_holder_end is 30
        add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 18 ); // permission 29 is set because teenglow_add_product_list_item_media_holder_end is 30

        // Add additional tags around product list item content
        add_action( 'woocommerce_shop_loop_item_title', 'teenglow_add_product_list_item_content_holder', 5 ); // permission 5 is set because woocommerce_template_loop_product_title hook is added on 10
        add_action( 'woocommerce_after_shop_loop_item', 'teenglow_add_product_list_item_content_holder_end', 20 ); // permission 30 is set because woocommerce_template_loop_add_to_cart hook is added on 10

        // Removed rating
        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	}

	add_action( 'teenglow_core_action_shop_list_item_layout_info-below', 'teenglow_core_register_shop_list_info_below_actions' );
}
