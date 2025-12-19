<?php

if ( ! function_exists( 'barabi_core_add_divided_header_options' ) ) {
	/**
	 * Function that add additional header layout options
	 *
	 * @param object $page
	 * @param array  $general_header_tab
	 */
	function barabi_core_add_divided_header_options( $page, $general_header_tab ) {

		$section = $general_header_tab->add_section_element(
			array(
				'name'       => 'qodef_divided_header_section',
				'title'      => esc_html__( 'Divided Header', 'barabi-core' ),
				'dependency' => array(
					'show' => array(
						'qodef_header_layout' => array(
							'values'        => 'divided',
							'default_value' => '',
						),
					),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_divided_header_height',
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
				'name'        => 'qodef_divided_header_side_padding',
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
				'name'        => 'qodef_divided_header_background_color',
				'title'       => esc_html__( 'Header Background Color', 'barabi-core' ),
				'description' => esc_html__( 'Enter header background color', 'barabi-core' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_divided_header_border_color',
				'title'       => esc_html__( 'Header Border Color', 'barabi-core' ),
				'description' => esc_html__( 'Enter header border color', 'barabi-core' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_divided_header_border_width',
				'title'       => esc_html__( 'Header Border Width', 'barabi-core' ),
				'description' => esc_html__( 'Enter header border width size', 'barabi-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'barabi-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_divided_header_border_style',
				'title'       => esc_html__( 'Header Border Style', 'barabi-core' ),
				'description' => esc_html__( 'Choose header border style', 'barabi-core' ),
				'options'     => barabi_core_get_select_type_options_pool( 'border_style' ),
			)
		);

        $section->add_field_element(
            array(
                'field_type'  => 'select',
                'name'        => 'qodef_divided_header_box_shadow',
                'title'       => esc_html__( 'Enable Header Box Shadow', 'barabi-core' ),
                'options'     => barabi_core_get_select_type_options_pool( 'no_yes', false ),
            )
        );
	}

	add_action( 'barabi_core_action_after_header_options_map', 'barabi_core_add_divided_header_options', 10, 2 );
}
