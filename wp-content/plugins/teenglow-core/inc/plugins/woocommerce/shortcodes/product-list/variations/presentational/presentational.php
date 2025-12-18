<?php

if ( ! function_exists( 'teenglow_core_add_product_list_variation_presentational' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_add_product_list_variation_presentational( $variations ) {
		$variations['presentational'] = esc_html__( 'Presentational', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_product_list_layouts', 'teenglow_core_add_product_list_variation_presentational' );
}
