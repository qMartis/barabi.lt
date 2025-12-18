<?php

if ( ! function_exists( 'teenglow_core_add_banner_variation_link_button' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_add_banner_variation_link_button( $variations ) {
		$variations['link-button'] = esc_html__( 'Link Button', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_banner_layouts', 'teenglow_core_add_banner_variation_link_button' );
}
