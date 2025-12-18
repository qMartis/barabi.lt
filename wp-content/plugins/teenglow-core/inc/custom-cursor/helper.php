<?php

if ( ! function_exists( 'teenglow_core_set_custom_cursor_icon' ) ) {
	/**
	 * Function that add drag cursor icon into global js object
	 *
	 * @param $array
	 *
	 * @return mixed
	 */
	function teenglow_core_set_custom_cursor_icon( $array ) {
		$array['dragCursor'] = teenglow_core_get_svg_icon( 'drag-cursor' );

		return $array;
	}

	add_filter( 'teenglow_filter_localize_main_js', 'teenglow_core_set_custom_cursor_icon' );
}
