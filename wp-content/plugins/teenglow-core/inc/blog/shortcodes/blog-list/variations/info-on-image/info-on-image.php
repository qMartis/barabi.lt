<?php

if ( ! function_exists( 'teenglow_core_add_blog_list_variation_info_on_image' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_add_blog_list_variation_info_on_image( $variations ) {
		$variations['info-on-image'] = esc_html__( 'Info On Image', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_blog_list_layouts', 'teenglow_core_add_blog_list_variation_info_on_image' );
}
