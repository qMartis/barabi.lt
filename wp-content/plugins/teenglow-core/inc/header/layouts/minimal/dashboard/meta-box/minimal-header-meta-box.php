<?php

if ( ! function_exists( 'teenglow_core_add_minimal_header_meta' ) ) {
	/**
	 * Function that add additional header layout meta box options
	 *
	 * @param object $page
	 */
	function teenglow_core_add_minimal_header_meta( $page ) {

		$section = $page->add_section_element(
			array(
				'name'       => 'qodef_minimal_header_section',
				'title'      => esc_html__( 'Minimal Header', 'teenglow-core' ),
				'dependency' => array(
					'show' => array(
						'qodef_header_layout' => array(
							'values'        => 'minimal',
							'default_value' => '',
						),
					),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'    => 'select',
				'name'          => 'qodef_minimal_header_in_grid',
				'title'         => esc_html__( 'Content in Grid', 'teenglow-core' ),
				'description'   => esc_html__( 'Set content to be in grid', 'teenglow-core' ),
				'default_value' => '',
				'options'       => teenglow_core_get_select_type_options_pool( 'no_yes' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_minimal_header_height',
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
				'name'        => 'qodef_minimal_header_side_padding',
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
				'name'        => 'qodef_minimal_header_background_color',
				'title'       => esc_html__( 'Header Background Color', 'teenglow-core' ),
				'description' => esc_html__( 'Enter header background color', 'teenglow-core' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_minimal_header_border_color',
				'title'       => esc_html__( 'Header Border Color', 'teenglow-core' ),
				'description' => esc_html__( 'Enter header border color', 'teenglow-core' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_minimal_header_border_width',
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
				'name'        => 'qodef_minimal_header_border_style',
				'title'       => esc_html__( 'Header Border Style', 'teenglow-core' ),
				'description' => esc_html__( 'Choose header border style', 'teenglow-core' ),
				'options'     => teenglow_core_get_select_type_options_pool( 'border_style' ),
			)
		);
	}

	add_action( 'teenglow_core_action_after_page_header_meta_map', 'teenglow_core_add_minimal_header_meta' );
}
