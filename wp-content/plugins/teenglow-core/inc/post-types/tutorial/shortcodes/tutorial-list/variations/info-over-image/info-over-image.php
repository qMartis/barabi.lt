<?php

if ( ! function_exists( 'teenglow_core_add_tutorial_list_variation_info_over_image' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_add_tutorial_list_variation_info_over_image( $variations ) {
		$variations['info-over-image'] = esc_html__( 'Info Over Image', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_tutorial_list_layouts', 'teenglow_core_add_tutorial_list_variation_info_over_image' );
}
