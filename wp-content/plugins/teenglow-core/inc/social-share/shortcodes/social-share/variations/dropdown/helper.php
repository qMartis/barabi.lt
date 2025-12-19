<?php

if ( ! function_exists( 'teenglow_core_add_social_share_variation_dropdown' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_add_social_share_variation_dropdown( $variations ) {
		$variations['dropdown'] = esc_html__( 'Dropdown', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_social_share_layouts', 'teenglow_core_add_social_share_variation_dropdown' );
	add_filter( 'teenglow_core_filter_social_share_layout_options', 'teenglow_core_add_social_share_variation_dropdown' );
}
