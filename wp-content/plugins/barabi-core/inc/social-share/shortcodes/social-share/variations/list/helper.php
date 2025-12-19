<?php

if ( ! function_exists( 'barabi_core_add_social_share_variation_list' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function barabi_core_add_social_share_variation_list( $variations ) {
		$variations['list'] = esc_html__( 'List', 'barabi-core' );

		return $variations;
	}

	add_filter( 'barabi_core_filter_social_share_layouts', 'barabi_core_add_social_share_variation_list' );
	add_filter( 'barabi_core_filter_social_share_layout_options', 'barabi_core_add_social_share_variation_list' );
}

if ( ! function_exists( 'barabi_core_set_default_social_share_variation_list' ) ) {
	/**
	 * Function that set default variation layout for this module
	 *
	 * @return string
	 */
	function barabi_core_set_default_social_share_variation_list() {
		return 'list';
	}

	add_filter( 'barabi_core_filter_social_share_layout_default_value', 'barabi_core_set_default_social_share_variation_list' );
}
