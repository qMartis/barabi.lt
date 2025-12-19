<?php

if ( ! function_exists( 'barabi_core_add_subscribe_button_variation_button' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function barabi_core_add_subscribe_button_variation_button( $variations ) {
		$variations['button'] = esc_html__( 'Button', 'barabi-core' );

		return $variations;
	}

	add_filter( 'barabi_core_filter_subscribe_button_layouts', 'barabi_core_add_subscribe_button_variation_button' );
}
