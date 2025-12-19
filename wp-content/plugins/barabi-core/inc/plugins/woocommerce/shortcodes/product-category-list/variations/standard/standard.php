<?php

if ( ! function_exists( 'barabi_core_add_product_category_list_variation_standard' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function barabi_core_add_product_category_list_variation_standard( $variations ) {
		$variations['standard'] = esc_html__( 'Standard', 'barabi-core' );

		return $variations;
	}

	add_filter( 'barabi_core_filter_product_category_list_layouts', 'barabi_core_add_product_category_list_variation_standard' );
}
