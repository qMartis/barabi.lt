<?php

if ( ! function_exists( 'barabi_load_page_mobile_header' ) ) {
	/**
	 * Function which loads page template module
	 */
	function barabi_load_page_mobile_header() {
		// Include mobile header template
		echo apply_filters( 'barabi_filter_mobile_header_template', barabi_get_template_part( 'mobile-header', 'templates/mobile-header' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	add_action( 'barabi_action_page_header_template', 'barabi_load_page_mobile_header' );
}

if ( ! function_exists( 'barabi_register_mobile_navigation_menus' ) ) {
	/**
	 * Function which registers navigation menus
	 */
	function barabi_register_mobile_navigation_menus() {
		$navigation_menus = apply_filters( 'barabi_filter_register_mobile_navigation_menus', array( 'mobile-navigation' => esc_html__( 'Mobile Navigation', 'barabi' ) ) );

		if ( ! empty( $navigation_menus ) ) {
			register_nav_menus( $navigation_menus );
		}
	}

	add_action( 'barabi_action_after_include_modules', 'barabi_register_mobile_navigation_menus' );
}
