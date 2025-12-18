<?php

if ( ! function_exists( 'teenglow_core_add_product_list_variation_info_below_boxed' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_add_product_list_variation_info_below_boxed( $variations ) {
		$variations['info-below-boxed'] = esc_html__( 'Info Below Boxed', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_product_list_layouts', 'teenglow_core_add_product_list_variation_info_below_boxed' );
}
