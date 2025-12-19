<?php

if ( ! function_exists( 'barabi_core_add_button_variation_textual' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function barabi_core_add_button_variation_textual( $variations ) {
		$variations['textual'] = esc_html__( 'Textual', 'barabi-core' );

		return $variations;
	}

	add_filter( 'barabi_core_filter_button_layouts', 'barabi_core_add_button_variation_textual' );
}
