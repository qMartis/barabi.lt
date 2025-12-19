<?php

if ( ! function_exists( 'barabi_core_add_blog_list_variation_basic' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function barabi_core_add_blog_list_variation_basic( $variations ) {
		$variations['basic'] = esc_html__( 'Basic', 'barabi-core' );

		return $variations;
	}

	add_filter( 'barabi_core_filter_blog_list_layouts', 'barabi_core_add_blog_list_variation_basic' );
}
