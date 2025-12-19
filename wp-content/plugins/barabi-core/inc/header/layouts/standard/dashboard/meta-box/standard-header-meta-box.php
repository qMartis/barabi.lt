<?php

if ( ! function_exists( 'barabi_core_add_standard_header_meta' ) ) {
	/**
	 * Function that add additional header layout meta box options
	 *
	 * @param object $page
	 */
	function barabi_core_add_standard_header_meta( $page ) {
		$section = $page->add_section_element(
			array(
				'name'       => 'qodef_standard_header_section',
				'title'      => esc_html__( 'Standard Header', 'barabi-core' ),
				'dependency' => array(
					'show' => array(
						'qodef_header_layout' => array(
							'values'        => array( '', 'standard' ),
							'default_value' => '',
						),
					),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'    => 'select',
				'name'          => 'qodef_standard_header_in_grid',
				'title'         => esc_html__( 'Content in Grid', 'barabi-core' ),
				'description'   => esc_html__( 'Set content to be in grid', 'barabi-core' ),
				'default_value' => '',
				'options'       => barabi_core_get_select_type_options_pool( 'no_yes' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_standard_header_height',
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
				'name'        => 'qodef_standard_header_side_padding',
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
				'name'        => 'qodef_standard_header_background_color',
				'title'       => esc_html__( 'Header Background Color', 'barabi-core' ),
				'description' => esc_html__( 'Enter header background color', 'barabi-core' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_standard_header_border_color',
				'title'       => esc_html__( 'Header Border Color', 'barabi-core' ),
				'description' => esc_html__( 'Enter header border color', 'barabi-core' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_standard_header_border_width',
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
				'name'        => 'qodef_standard_header_border_style',
				'title'       => esc_html__( 'Header Border Style', 'barabi-core' ),
				'description' => esc_html__( 'Choose header border style', 'barabi-core' ),
				'options'     => barabi_core_get_select_type_options_pool( 'border_style' ),
			)
		);

        $section->add_field_element(
            array(
                'field_type'  => 'select',
                'name'        => 'qodef_standard_header_box_shadow',
                'title'       => esc_html__( 'Enable Header Box Shadow', 'barabi-core' ),
                'options'     => barabi_core_get_select_type_options_pool( 'no_yes' ),
            )
        );

		$section->add_field_element(
			array(
				'field_type'    => 'select',
				'name'          => 'qodef_standard_header_menu_position',
				'title'         => esc_html__( 'Menu position', 'barabi-core' ),
				'default_value' => '',
				'options'       => array(
					''       => esc_html__( 'Default', 'barabi-core' ),
					'left'   => esc_html__( 'Left', 'barabi-core' ),
					'center' => esc_html__( 'Center', 'barabi-core' ),
					'right'  => esc_html__( 'Right', 'barabi-core' ),
				),
			)
		);
	}

	add_action( 'barabi_core_action_after_page_header_meta_map', 'barabi_core_add_standard_header_meta' );
}
