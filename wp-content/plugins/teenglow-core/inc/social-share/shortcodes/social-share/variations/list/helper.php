<?php

if ( ! function_exists( 'teenglow_core_add_social_share_variation_list' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_add_social_share_variation_list( $variations ) {
		$variations['list'] = esc_html__( 'List', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_social_share_layouts', 'teenglow_core_add_social_share_variation_list' );
	add_filter( 'teenglow_core_filter_social_share_layout_options', 'teenglow_core_add_social_share_variation_list' );
}

if ( ! function_exists( 'teenglow_core_set_default_social_share_variation_list' ) ) {
	/**
	 * Function that set default variation layout for this module
	 *
	 * @return string
	 */
	function teenglow_core_set_default_social_share_variation_list() {
		return 'list';
	}

	add_filter( 'teenglow_core_filter_social_share_layout_default_value', 'teenglow_core_set_default_social_share_variation_list' );
}
