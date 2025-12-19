<?php

if ( ! function_exists( 'barabi_core_add_progress_bar_spinner_layout_option' ) ) {
	/**
	 * Function that set new value into page spinner layout options map
	 *
	 * @param array $layouts - module layouts
	 *
	 * @return array
	 */
	function barabi_core_add_progress_bar_spinner_layout_option( $layouts ) {
		$layouts['progress-bar'] = esc_html__( 'Progress Bar', 'barabi-core' );

		return $layouts;
	}

	add_filter( 'barabi_core_filter_page_spinner_layout_options', 'barabi_core_add_progress_bar_spinner_layout_option' );
}

if ( ! function_exists( 'barabi_core_add_progress_bar_spinner_layout_classes' ) ) {
	/**
	 * Function that return classes for page spinner area
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	function barabi_core_add_progress_bar_spinner_layout_classes( $classes ) {
		$type = barabi_core_get_post_value_through_levels( 'qodef_page_spinner_type' );

		if ( 'progress-bar' === $type ) {
			$classes[] = 'qodef--custom-spinner';
		}

		return $classes;
	}

	add_filter( 'barabi_core_filter_page_spinner_classes', 'barabi_core_add_progress_bar_spinner_layout_classes' );
}
