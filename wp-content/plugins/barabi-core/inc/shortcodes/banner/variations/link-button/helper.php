<?php

if ( ! function_exists( 'barabi_core_add_banner_variation_link_button' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function barabi_core_add_banner_variation_link_button( $variations ) {
		$variations['link-button'] = esc_html__( 'Link Button', 'barabi-core' );

		return $variations;
	}

	add_filter( 'barabi_core_filter_banner_layouts', 'barabi_core_add_banner_variation_link_button' );
}
