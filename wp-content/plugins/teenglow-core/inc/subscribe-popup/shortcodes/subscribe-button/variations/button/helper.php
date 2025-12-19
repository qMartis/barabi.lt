<?php

if ( ! function_exists( 'teenglow_core_add_subscribe_button_variation_button' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_add_subscribe_button_variation_button( $variations ) {
		$variations['button'] = esc_html__( 'Button', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_subscribe_button_layouts', 'teenglow_core_add_subscribe_button_variation_button' );
}
