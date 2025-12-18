<?php

if ( ! function_exists( 'teenglow_core_add_atom_spinner_layout_option' ) ) {
	/**
	 * Function that set new value into page spinner layout options map
	 *
	 * @param array $layouts - module layouts
	 *
	 * @return array
	 */
	function teenglow_core_add_atom_spinner_layout_option( $layouts ) {
		$layouts['atom'] = esc_html__( 'Atom', 'teenglow-core' );

		return $layouts;
	}

	add_filter( 'teenglow_core_filter_page_spinner_layout_options', 'teenglow_core_add_atom_spinner_layout_option' );
}
