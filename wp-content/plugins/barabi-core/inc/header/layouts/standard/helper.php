<?php

if ( ! function_exists( 'barabi_core_add_standard_header_global_option' ) ) {
	/**
	 * This function set header type value for global header option map
	 */
	function barabi_core_add_standard_header_global_option( $header_layout_options ) {
		$header_layout_options['standard'] = array(
			'image' => BARABI_CORE_HEADER_LAYOUTS_URL_PATH . '/standard/assets/img/standard-header.png',
			'label' => esc_html__( 'Standard', 'barabi-core' ),
		);

		return $header_layout_options;
	}

	add_filter( 'barabi_core_filter_header_layout_option', 'barabi_core_add_standard_header_global_option' );
}

if ( ! function_exists( 'barabi_core_set_standard_header_as_default_global_option' ) ) {
	/**
	 * This function set header type as default option value for global header option map
	 */
	function barabi_core_set_standard_header_as_default_global_option() {
		return 'standard';
	}

	add_filter( 'barabi_core_filter_header_layout_default_option_value', 'barabi_core_set_standard_header_as_default_global_option' );
}

if ( ! function_exists( 'barabi_core_register_standard_header_layout' ) ) {
	/**
	 * Function which add header layout into global list
	 *
	 * @param array $header_layouts
	 *
	 * @return array
	 */
	function barabi_core_register_standard_header_layout( $header_layouts ) {
		$header_layouts['standard'] = 'BarabiCore_Standard_Header';

		return $header_layouts;
	}

	add_filter( 'barabi_core_filter_register_header_layouts', 'barabi_core_register_standard_header_layout' );
}
