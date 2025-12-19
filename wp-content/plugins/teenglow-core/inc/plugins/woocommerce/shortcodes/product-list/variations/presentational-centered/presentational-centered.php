<?php

if ( ! function_exists( 'teenglow_core_add_product_list_variation_presentational_centered' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_add_product_list_variation_presentational_centered( $variations ) {
		$variations['presentational-centered'] = esc_html__( 'Presentational Centered', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_product_list_layouts', 'teenglow_core_add_product_list_variation_presentational_centered' );
}
