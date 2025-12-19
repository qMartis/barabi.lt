<?php

if ( ! function_exists( 'teenglow_core_add_counter_variation_simple' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_add_counter_variation_simple( $variations ) {
		$variations['simple'] = esc_html__( 'Simple', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_counter_layouts', 'teenglow_core_add_counter_variation_simple' );
}
