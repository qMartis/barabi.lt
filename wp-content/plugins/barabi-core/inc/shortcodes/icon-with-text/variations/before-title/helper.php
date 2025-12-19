<?php

if ( ! function_exists( 'barabi_core_add_icon_with_text_variation_before_title' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function barabi_core_add_icon_with_text_variation_before_title( $variations ) {
		$variations['before-title'] = esc_html__( 'Before Title', 'barabi-core' );

		return $variations;
	}

	add_filter( 'barabi_core_filter_icon_with_text_layouts', 'barabi_core_add_icon_with_text_variation_before_title' );
}
