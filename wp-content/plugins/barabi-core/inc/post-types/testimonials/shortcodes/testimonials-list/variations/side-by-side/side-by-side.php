<?php

if ( ! function_exists( 'barabi_core_add_testimonials_list_variation_side_by_side' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function barabi_core_add_testimonials_list_variation_side_by_side( $variations ) {
		$variations['side-by-side'] = esc_html__( 'Side By Side', 'barabi-core' );

		return $variations;
	}

	add_filter( 'barabi_core_filter_testimonials_list_layouts', 'barabi_core_add_testimonials_list_variation_side_by_side' );
}