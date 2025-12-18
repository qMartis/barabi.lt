<?php

if ( ! function_exists( 'teenglow_core_add_icon_with_text_variation_before_content' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_add_icon_with_text_variation_before_content( $variations ) {
		$variations['before-content'] = esc_html__( 'Before Content', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_icon_with_text_layouts', 'teenglow_core_add_icon_with_text_variation_before_content' );
}
