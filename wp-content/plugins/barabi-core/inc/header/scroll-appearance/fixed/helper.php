<?php

if ( ! function_exists( 'barabi_core_add_fixed_header_option' ) ) {
	/**
	 * This function set header scrolling appearance value for global header option map
	 */
	function barabi_core_add_fixed_header_option( $options ) {
		$options['fixed'] = esc_html__( 'Fixed', 'barabi-core' );

		return $options;
	}

	add_filter( 'barabi_core_filter_header_scroll_appearance_option', 'barabi_core_add_fixed_header_option' );
}
