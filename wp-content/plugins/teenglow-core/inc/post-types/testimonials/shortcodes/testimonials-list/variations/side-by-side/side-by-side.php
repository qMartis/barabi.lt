<?php

if ( ! function_exists( 'teenglow_core_add_testimonials_list_variation_side_by_side' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_add_testimonials_list_variation_side_by_side( $variations ) {
		$variations['side-by-side'] = esc_html__( 'Side By Side', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_testimonials_list_layouts', 'teenglow_core_add_testimonials_list_variation_side_by_side' );
}