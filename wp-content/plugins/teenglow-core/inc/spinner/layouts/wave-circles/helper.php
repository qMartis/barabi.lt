<?php

if ( ! function_exists( 'teenglow_core_add_wave_circles_spinner_layout_option' ) ) {
	/**
	 * Function that set new value into page spinner layout options map
	 *
	 * @param array $layouts - module layouts
	 *
	 * @return array
	 */
	function teenglow_core_add_wave_circles_spinner_layout_option( $layouts ) {
		$layouts['wave-circles'] = esc_html__( 'Wave Circles', 'teenglow-core' );

		return $layouts;
	}

	add_filter( 'teenglow_core_filter_page_spinner_layout_options', 'teenglow_core_add_wave_circles_spinner_layout_option' );
}
