<?php

if ( ! function_exists( 'teenglow_core_add_top_area_options' ) ) {
	/**
	 * Function that add additional header layout options
	 *
	 * @param object $page
	 * @param array $general_header_tab
	 */
	function teenglow_core_add_top_area_options( $page, $general_header_tab ) {

		$top_area_section = $general_header_tab->add_section_element(
			array(
				'name'        => 'qodef_top_area_section',
				'title'       => esc_html__( 'Top Area', 'teenglow-core' ),
				'description' => esc_html__( 'Options related to top area', 'teenglow-core' ),
				'dependency'  => array(
					'hide' => array(
						'qodef_header_layout' => array(
							'values'        => teenglow_core_dependency_for_top_area_options(),
							'default_value' => apply_filters( 'teenglow_core_filter_header_layout_default_option_value', '' ),
						),
					),
				),
			)
		);

		$top_area_section->add_field_element(
			array(
				'field_type'    => 'yesno',
				'default_value' => 'no',
				'name'          => 'qodef_top_area_header',
				'title'         => esc_html__( 'Top Area', 'teenglow-core' ),
				'description'   => esc_html__( 'Enable top area', 'teenglow-core' ),
			)
		);

		$top_area_options_section = $top_area_section->add_section_element(
			array(
				'name'        => 'qodef_top_area_options_section',
				'title'       => esc_html__( 'Top Area Options', 'teenglow-core' ),
				'description' => esc_html__( 'Set desired values for top area', 'teenglow-core' ),
				'dependency'  => array(
					'show' => array(
						'qodef_top_area_header' => array(
							'values'        => 'yes',
							'default_value' => 'no',
						),
					),
				),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'    => 'yesno',
				'name'          => 'qodef_top_area_header_in_grid',
				'title'         => esc_html__( 'Content in Grid', 'teenglow-core' ),
				'description'   => esc_html__( 'Set content to be in grid', 'teenglow-core' ),
				'default_value' => 'no',
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_top_area_header_height',
				'title'       => esc_html__( 'Top Area Height', 'teenglow-core' ),
				'description' => esc_html__( 'Enter top area height (default is 30px)', 'teenglow-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'teenglow-core' ),
				),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type' => 'text',
				'name'       => 'qodef_top_area_header_side_padding',
				'title'      => esc_html__( 'Top Area Side Padding', 'teenglow-core' ),
				'args'       => array(
					'suffix' => esc_html__( 'px or %', 'teenglow-core' ),
				),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_set_top_area_header_content_alignment',
				'title'       => esc_html__( 'Content Alignment', 'teenglow-core' ),
				'description' => esc_html__( 'Set widgets content alignment inside top header area', 'teenglow-core' ),
				'options'     => array(
					''       => esc_html__( 'Default', 'teenglow-core' ),
					'center' => esc_html__( 'Center', 'teenglow-core' ),
				),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_top_area_header_background_color',
				'title'       => esc_html__( 'Top Area Background Color', 'teenglow-core' ),
				'description' => esc_html__( 'Choose top area background color', 'teenglow-core' ),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_top_area_header_border_color',
				'title'       => esc_html__( 'Top Area Border Color', 'teenglow-core' ),
				'description' => esc_html__( 'Enter top area border color', 'teenglow-core' ),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_top_area_header_border_width',
				'title'       => esc_html__( 'Top Area Border Width', 'teenglow-core' ),
				'description' => esc_html__( 'Enter top area border width size', 'teenglow-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'teenglow-core' ),
				),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_top_area_header_border_style',
				'title'       => esc_html__( 'Top Area Border Style', 'teenglow-core' ),
				'description' => esc_html__( 'Choose top area border style', 'teenglow-core' ),
				'options'     => teenglow_core_get_select_type_options_pool( 'border_style' ),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type' => 'select',
				'name'       => 'qodef_top_area_header_text_skin',
				'title'      => esc_html__( 'Top Area Text Skin', 'teenglow-core' ),
				'options'    => array(
					''      => esc_html__( 'Default', 'teenglow-core' ),
					'light' => esc_html__( 'Light', 'teenglow-core' ),
				),
			)
		);
	}

	add_action( 'teenglow_core_action_after_header_options_map', 'teenglow_core_add_top_area_options', 20, 2 );
}
