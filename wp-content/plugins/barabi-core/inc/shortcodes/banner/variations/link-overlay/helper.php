<?php

if ( ! function_exists( 'barabi_core_add_banner_variation_link_overlay' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function barabi_core_add_banner_variation_link_overlay( $variations ) {
		$variations['link-overlay'] = esc_html__( 'Link Overlay', 'barabi-core' );

		return $variations;
	}

	add_filter( 'barabi_core_filter_banner_layouts', 'barabi_core_add_banner_variation_link_overlay' );
}
