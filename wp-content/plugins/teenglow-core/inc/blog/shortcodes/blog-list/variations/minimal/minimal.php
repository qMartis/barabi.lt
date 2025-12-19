<?php

if ( ! function_exists( 'teenglow_core_add_blog_list_variation_minimal' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_add_blog_list_variation_minimal( $variations ) {
		$variations['minimal'] = esc_html__( 'Minimal', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_blog_list_layouts', 'teenglow_core_add_blog_list_variation_minimal' );
	add_filter( 'teenglow_core_filter_simple_blog_list_widget_layouts', 'teenglow_core_add_blog_list_variation_minimal' );
}
