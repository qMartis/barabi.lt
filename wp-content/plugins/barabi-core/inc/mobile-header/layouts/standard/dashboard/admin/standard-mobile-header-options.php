<?php

if ( ! function_exists( 'barabi_core_add_standard_mobile_header_options' ) ) {
	/**
	 * Function that add additional header layout options
	 *
	 * @param object $page
	 * @param array  $general_tab
	 */
	function barabi_core_add_standard_mobile_header_options( $page, $general_tab ) {

		$section = $general_tab->add_section_element(
			array(
				'name'       => 'qodef_standard_mobile_header_section',
				'title'      => esc_html__( 'Standard Mobile Header', 'barabi-core' ),
				'dependency' => array(
					'show' => array(
						'qodef_mobile_header_layout' => array(
							'values'        => 'standard',
							'default_value' => '',
						),
					),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_standard_mobile_header_height',
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
				'name'        => 'qodef_standard_mobile_header_side_padding',
				'title'       => esc_html__( 'Header Side Padding', 'barabi-core' ),
				'description' => esc_html__( 'Enter side padding for header area', 'barabi-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px or %', 'barabi-core' ),
				),
				'dependency'  => array(
					'show' => array(
						'qodef_mobile_header_in_grid' => array(
							'values'        => 'no',
							'default_value' => 'no',
						),
					),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_standard_mobile_header_background_color',
				'title'       => esc_html__( 'Header Background Color', 'barabi-core' ),
				'description' => esc_html__( 'Enter header background color', 'barabi-core' ),
			)
		);
	}

	add_action( 'barabi_core_action_after_mobile_header_options_map', 'barabi_core_add_standard_mobile_header_options', 10, 2 );
}
