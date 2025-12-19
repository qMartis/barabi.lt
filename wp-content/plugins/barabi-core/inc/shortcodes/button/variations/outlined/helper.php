<?php

if ( ! function_exists( 'barabi_core_add_button_variation_outlined' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function barabi_core_add_button_variation_outlined( $variations ) {
		$variations['outlined'] = esc_html__( 'Outlined', 'barabi-core' );

		return $variations;
	}

	add_filter( 'barabi_core_filter_button_layouts', 'barabi_core_add_button_variation_outlined' );
}
