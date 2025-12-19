<?php

if ( ! function_exists( 'barabi_core_add_rotate_circles_spinner_layout_option' ) ) {
	/**
	 * Function that set new value into page spinner layout options map
	 *
	 * @param array $layouts - module layouts
	 *
	 * @return array
	 */
	function barabi_core_add_rotate_circles_spinner_layout_option( $layouts ) {
		$layouts['rotate-circles'] = esc_html__( 'Rotate Circles', 'barabi-core' );

		return $layouts;
	}

	add_filter( 'barabi_core_filter_page_spinner_layout_options', 'barabi_core_add_rotate_circles_spinner_layout_option' );
}
