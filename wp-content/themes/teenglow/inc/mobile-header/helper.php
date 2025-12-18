<?php

if ( ! function_exists( 'teenglow_load_page_mobile_header' ) ) {
	/**
	 * Function which loads page template module
	 */
	function teenglow_load_page_mobile_header() {
		// Include mobile header template
		echo apply_filters( 'teenglow_filter_mobile_header_template', teenglow_get_template_part( 'mobile-header', 'templates/mobile-header' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	add_action( 'teenglow_action_page_header_template', 'teenglow_load_page_mobile_header' );
}

if ( ! function_exists( 'teenglow_register_mobile_navigation_menus' ) ) {
	/**
	 * Function which registers navigation menus
	 */
	function teenglow_register_mobile_navigation_menus() {
		$navigation_menus = apply_filters( 'teenglow_filter_register_mobile_navigation_menus', array( 'mobile-navigation' => esc_html__( 'Mobile Navigation', 'teenglow' ) ) );

		if ( ! empty( $navigation_menus ) ) {
			register_nav_menus( $navigation_menus );
		}
	}

	add_action( 'teenglow_action_after_include_modules', 'teenglow_register_mobile_navigation_menus' );
}
