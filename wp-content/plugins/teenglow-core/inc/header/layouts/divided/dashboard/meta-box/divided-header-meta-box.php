<?php

if ( ! function_exists( 'teenglow_core_add_divided_header_meta' ) ) {
	/**
	 * Function that add additional header layout meta box options
	 *
	 * @param object $page
	 */
	function teenglow_core_add_divided_header_meta( $page ) {

		$section = $page->add_section_element(
			array(
				'name'       => 'qodef_divided_header_section',
				'title'      => esc_html__( 'Divided Header', 'teenglow-core' ),
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
				'name'        => 'qodef_divided_header_side_padding',
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
				'name'        => 'qodef_divided_header_background_color',
				'title'       => esc_html__( 'Header Background Color', 'teenglow-core' ),
				'description' => esc_html__( 'Enter header background color', 'teenglow-core' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_divided_header_border_color',
				'title'       => esc_html__( 'Header Border Color', 'teenglow-core' ),
				'description' => esc_html__( 'Enter header border color', 'teenglow-core' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_divided_header_border_width',
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
				'name'        => 'qodef_divided_header_border_style',
				'title'       => esc_html__( 'Header Border Style', 'teenglow-core' ),
				'description' => esc_html__( 'Choose header border style', 'teenglow-core' ),
				'options'     => teenglow_core_get_select_type_options_pool( 'border_style' ),
			)
		);

        $section->add_field_element(
            array(
                'field_type'  => 'select',
                'name'        => 'qodef_divided_header_box_shadow',
                'title'       => esc_html__( 'Enable Header Box Shadow', 'teenglow-core' ),
                'options'     => teenglow_core_get_select_type_options_pool( 'no_yes' ),
            )
        );
	}

	add_action( 'teenglow_core_action_after_page_header_meta_map', 'teenglow_core_add_divided_header_meta' );
}
