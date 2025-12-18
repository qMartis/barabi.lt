<?php

if ( ! function_exists( 'teenglow_core_add_text_marquee_variation_default' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_add_text_marquee_variation_default( $variations ) {
		$variations['default'] = esc_html__( 'Default', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_text_marquee_layouts', 'teenglow_core_add_text_marquee_variation_default' );
}
