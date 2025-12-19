<?php

if ( ! function_exists( 'barabi_core_set_custom_cursor_icon' ) ) {
	/**
	 * Function that add drag cursor icon into global js object
	 *
	 * @param $array
	 *
	 * @return mixed
	 */
	function barabi_core_set_custom_cursor_icon( $array ) {
		$array['dragCursor'] = barabi_core_get_svg_icon( 'drag-cursor' );

		return $array;
	}

	add_filter( 'barabi_filter_localize_main_js', 'barabi_core_set_custom_cursor_icon' );
}
