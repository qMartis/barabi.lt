<?php

if ( ! function_exists( 'barabi_core_add_social_share_variation_dropdown' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function barabi_core_add_social_share_variation_dropdown( $variations ) {
		$variations['dropdown'] = esc_html__( 'Dropdown', 'barabi-core' );

		return $variations;
	}

	add_filter( 'barabi_core_filter_social_share_layouts', 'barabi_core_add_social_share_variation_dropdown' );
	add_filter( 'barabi_core_filter_social_share_layout_options', 'barabi_core_add_social_share_variation_dropdown' );
}
