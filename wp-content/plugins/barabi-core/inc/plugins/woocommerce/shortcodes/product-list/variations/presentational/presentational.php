<?php

if ( ! function_exists( 'barabi_core_add_product_list_variation_presentational' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function barabi_core_add_product_list_variation_presentational( $variations ) {
		$variations['presentational'] = esc_html__( 'Presentational', 'barabi-core' );

		return $variations;
	}

	add_filter( 'barabi_core_filter_product_list_layouts', 'barabi_core_add_product_list_variation_presentational' );
}
