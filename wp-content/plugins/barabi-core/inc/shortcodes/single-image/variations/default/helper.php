<?php

if ( ! function_exists( 'barabi_core_add_single_image_variation_default' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function barabi_core_add_single_image_variation_default( $variations ) {
		$variations['default'] = esc_html__( 'Default', 'barabi-core' );

		return $variations;
	}

	add_filter( 'barabi_core_filter_single_image_layouts', 'barabi_core_add_single_image_variation_default' );
}
