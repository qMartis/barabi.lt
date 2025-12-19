<?php

if ( ! function_exists( 'barabi_core_add_tabs_variation_simple' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function barabi_core_add_tabs_variation_simple( $variations ) {
		$variations['simple'] = esc_html__( 'Simple', 'barabi-core' );

		return $variations;
	}

	add_filter( 'barabi_core_filter_tabs_layouts', 'barabi_core_add_tabs_variation_simple' );
}
