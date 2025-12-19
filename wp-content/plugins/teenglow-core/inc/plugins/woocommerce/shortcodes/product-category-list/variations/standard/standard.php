<?php

if ( ! function_exists( 'teenglow_core_add_product_category_list_variation_standard' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_add_product_category_list_variation_standard( $variations ) {
		$variations['standard'] = esc_html__( 'Standard', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_product_category_list_layouts', 'teenglow_core_add_product_category_list_variation_standard' );
}
