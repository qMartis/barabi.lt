<?php

if ( ! function_exists( 'barabi_core_add_blog_list_variation_minimal' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function barabi_core_add_blog_list_variation_minimal( $variations ) {
		$variations['minimal'] = esc_html__( 'Minimal', 'barabi-core' );

		return $variations;
	}

	add_filter( 'barabi_core_filter_blog_list_layouts', 'barabi_core_add_blog_list_variation_minimal' );
	add_filter( 'barabi_core_filter_simple_blog_list_widget_layouts', 'barabi_core_add_blog_list_variation_minimal' );
}
