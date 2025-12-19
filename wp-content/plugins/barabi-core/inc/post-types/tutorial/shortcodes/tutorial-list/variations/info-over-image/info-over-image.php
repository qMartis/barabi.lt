<?php

if ( ! function_exists( 'barabi_core_add_tutorial_list_variation_info_over_image' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function barabi_core_add_tutorial_list_variation_info_over_image( $variations ) {
		$variations['info-over-image'] = esc_html__( 'Info Over Image', 'barabi-core' );

		return $variations;
	}

	add_filter( 'barabi_core_filter_tutorial_list_layouts', 'barabi_core_add_tutorial_list_variation_info_over_image' );
}
