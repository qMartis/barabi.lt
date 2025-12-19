<?php

if ( ! function_exists( 'barabi_core_register_covers_header_search_layout' ) ) {
	/**
	 * Function that add variation layout into global list
	 *
	 * @param array $search_layouts
	 *
	 * @return array
	 */
	function barabi_core_register_covers_header_search_layout( $search_layouts ) {
		$search_layouts['covers-header'] = 'BarabiCore_Covers_Header_Search';

		return $search_layouts;
	}

	add_filter( 'barabi_core_filter_register_search_layouts', 'barabi_core_register_covers_header_search_layout' );
}
