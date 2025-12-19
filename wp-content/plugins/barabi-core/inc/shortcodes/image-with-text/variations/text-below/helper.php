<?php

if ( ! function_exists( 'barabi_core_add_image_with_text_variation_text_below' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function barabi_core_add_image_with_text_variation_text_below( $variations ) {
		$variations['text-below'] = esc_html__( 'Text Below', 'barabi-core' );

		return $variations;
	}

	add_filter( 'barabi_core_filter_image_with_text_layouts', 'barabi_core_add_image_with_text_variation_text_below' );
}
