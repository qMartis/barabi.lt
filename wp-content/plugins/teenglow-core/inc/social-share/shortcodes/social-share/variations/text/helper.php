<?php

if ( ! function_exists( 'teenglow_core_add_social_share_variation_text' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_add_social_share_variation_text( $variations ) {
		$variations['text'] = esc_html__( 'Text', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_social_share_layouts', 'teenglow_core_add_social_share_variation_text' );
	add_filter( 'teenglow_core_filter_social_share_layout_options', 'teenglow_core_add_social_share_variation_text' );
}
