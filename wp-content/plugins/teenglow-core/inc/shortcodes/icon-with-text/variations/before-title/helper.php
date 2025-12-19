<?php

if ( ! function_exists( 'teenglow_core_add_icon_with_text_variation_before_title' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_add_icon_with_text_variation_before_title( $variations ) {
		$variations['before-title'] = esc_html__( 'Before Title', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_icon_with_text_layouts', 'teenglow_core_add_icon_with_text_variation_before_title' );
}
