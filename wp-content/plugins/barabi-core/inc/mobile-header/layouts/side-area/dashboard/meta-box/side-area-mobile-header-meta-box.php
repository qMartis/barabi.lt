<?php

if ( ! function_exists( 'barabi_core_add_side_area_mobile_header_meta' ) ) {
	/**
	 * Function that add additional header layout meta box options
	 *
	 * @param object $page
	 */
	function barabi_core_add_side_area_mobile_header_meta( $page ) {

		$section = $page->add_section_element(
			array(
				'name'       => 'qodef_side_area_mobile_header_section',
				'title'      => esc_html__( 'Side Area Mobile Header', 'barabi-core' ),
				'dependency' => array(
					'show' => array(
						'qodef_mobile_header_layout' => array(
							'values'        => 'side-area',
							'default_value' => '',
						),
					),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_side_area_mobile_header_height',
				'title'       => esc_html__( 'Header Height', 'barabi-core' ),
				'description' => esc_html__( 'Enter header height', 'barabi-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'barabi-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_side_area_mobile_header_side_padding',
				'title'       => esc_html__( 'Header Side Padding', 'barabi-core' ),
				'description' => esc_html__( 'Enter side padding for header area', 'barabi-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px or %', 'barabi-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_side_area_mobile_header_background_color',
				'title'       => esc_html__( 'Header Background Color', 'barabi-core' ),
				'description' => esc_html__( 'Enter header background color', 'barabi-core' ),
			)
		);
	}

	add_action( 'barabi_core_action_after_page_mobile_header_meta_map', 'barabi_core_add_side_area_mobile_header_meta', 10, 2 );
}
