<?php

if ( ! function_exists( 'barabi_core_add_product_list_variation_info_below_boxed' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function barabi_core_add_product_list_variation_info_below_boxed( $variations ) {
		$variations['info-below-boxed'] = esc_html__( 'Info Below Boxed', 'barabi-core' );

		return $variations;
	}

	add_filter( 'barabi_core_filter_product_list_layouts', 'barabi_core_add_product_list_variation_info_below_boxed' );
}
