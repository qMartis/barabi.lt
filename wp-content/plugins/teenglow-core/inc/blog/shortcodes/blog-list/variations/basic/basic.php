<?php

if ( ! function_exists( 'teenglow_core_add_blog_list_variation_basic' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_add_blog_list_variation_basic( $variations ) {
		$variations['basic'] = esc_html__( 'Basic', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_blog_list_layouts', 'teenglow_core_add_blog_list_variation_basic' );
}
