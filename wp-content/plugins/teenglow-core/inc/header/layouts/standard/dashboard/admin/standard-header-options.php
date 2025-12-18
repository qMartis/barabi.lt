<?php

if ( ! function_exists( 'teenglow_core_add_standard_header_options' ) ) {
	/**
	 * Function that add additional header layout options
	 *
	 * @param object $page
	 * @param array $general_header_tab
	 */
	function teenglow_core_add_standard_header_options( $page, $general_header_tab ) {

		$section = $general_header_tab->add_section_element(
			array(
				'name'        => 'qodef_standard_header_section',
				'title'       => esc_html__( 'Standard Header', 'teenglow-core' ),
				'description' => esc_html__( 'Standard header settings', 'teenglow-core' ),
				'dependency'  => array(
					'show' => array(
						'qodef_header_layout' => array(
							'values'        => 'standard',
							'default_value' => '',
						),
					),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'    => 'yesno',
				'name'          => 'qodef_standard_header_in_grid',
				'title'         => esc_html__( 'Content in Grid', 'teenglow-core' ),
				'description'   => esc_html__( 'Set content to be in grid', 'teenglow-core' ),
				'default_value' => 'no',
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_standard_header_height',
				'title'       => esc_html__( 'Header Height', 'teenglow-core' ),
				'description' => esc_html__( 'Enter header height', 'teenglow-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'teenglow-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_standard_header_side_padding',
				'title'       => esc_html__( 'Header Side Padding', 'teenglow-core' ),
				'description' => esc_html__( 'Enter side padding for header area', 'teenglow-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px or %', 'teenglow-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_standard_header_background_color',
				'title'       => esc_html__( 'Header Background Color', 'teenglow-core' ),
				'description' => esc_html__( 'Enter header background color', 'teenglow-core' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_standard_header_border_color',
				'title'       => esc_html__( 'Header Border Color', 'teenglow-core' ),
				'description' => esc_html__( 'Enter header border color', 'teenglow-core' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_standard_header_border_width',
				'title'       => esc_html__( 'Header Border Width', 'teenglow-core' ),
				'description' => esc_html__( 'Enter header border width size', 'teenglow-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'teenglow-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_standard_header_border_style',
				'title'       => esc_html__( 'Header Border Style', 'teenglow-core' ),
				'description' => esc_html__( 'Choose header border style', 'teenglow-core' ),
				'options'     => teenglow_core_get_select_type_options_pool( 'border_style' ),
			)
		);

        $section->add_field_element(
            array(
                'field_type'  => 'select',
                'name'        => 'qodef_standard_header_box_shadow',
                'title'       => esc_html__( 'Enable Header Box Shadow', 'teenglow-core' ),
                'options'     => teenglow_core_get_select_type_options_pool( 'no_yes', false ),
            )
        );

		$section->add_field_element(
			array(
				'field_type'    => 'select',
				'name'          => 'qodef_standard_header_menu_position',
				'title'         => esc_html__( 'Menu position', 'teenglow-core' ),
				'default_value' => 'right',
				'options'       => array(
					'left'   => esc_html__( 'Left', 'teenglow-core' ),
					'center' => esc_html__( 'Center', 'teenglow-core' ),
					'right'  => esc_html__( 'Right', 'teenglow-core' ),
				),
			)
		);
	}

	add_action( 'teenglow_core_action_after_header_options_map', 'teenglow_core_add_standard_header_options', 10, 2 );
}
