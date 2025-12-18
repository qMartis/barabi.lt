<?php

if ( ! function_exists( 'teenglow_core_add_button_variation_filled' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_add_button_variation_filled( $variations ) {
		$variations['filled'] = esc_html__( 'Filled', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_button_layouts', 'teenglow_core_add_button_variation_filled' );
}
