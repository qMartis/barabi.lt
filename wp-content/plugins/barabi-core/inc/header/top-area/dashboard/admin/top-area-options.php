<?php

if ( ! function_exists( 'barabi_core_add_top_area_options' ) ) {
	/**
	 * Function that add additional header layout options
	 *
	 * @param object $page
	 * @param array $general_header_tab
	 */
	function barabi_core_add_top_area_options( $page, $general_header_tab ) {

		$top_area_section = $general_header_tab->add_section_element(
			array(
				'name'        => 'qodef_top_area_section',
				'title'       => esc_html__( 'Top Area', 'barabi-core' ),
				'description' => esc_html__( 'Options related to top area', 'barabi-core' ),
				'dependency'  => array(
					'hide' => array(
						'qodef_header_layout' => array(
							'values'        => barabi_core_dependency_for_top_area_options(),
							'default_value' => apply_filters( 'barabi_core_filter_header_layout_default_option_value', '' ),
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
				'title'         => esc_html__( 'Top Area', 'barabi-core' ),
				'description'   => esc_html__( 'Enable top area', 'barabi-core' ),
			)
		);

		$top_area_options_section = $top_area_section->add_section_element(
			array(
				'name'        => 'qodef_top_area_options_section',
				'title'       => esc_html__( 'Top Area Options', 'barabi-core' ),
				'description' => esc_html__( 'Set desired values for top area', 'barabi-core' ),
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
				'title'         => esc_html__( 'Content in Grid', 'barabi-core' ),
				'description'   => esc_html__( 'Set content to be in grid', 'barabi-core' ),
				'default_value' => 'no',
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_top_area_header_height',
				'title'       => esc_html__( 'Top Area Height', 'barabi-core' ),
				'description' => esc_html__( 'Enter top area height (default is 30px)', 'barabi-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'barabi-core' ),
				),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type' => 'text',
				'name'       => 'qodef_top_area_header_side_padding',
				'title'      => esc_html__( 'Top Area Side Padding', 'barabi-core' ),
				'args'       => array(
					'suffix' => esc_html__( 'px or %', 'barabi-core' ),
				),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_set_top_area_header_content_alignment',
				'title'       => esc_html__( 'Content Alignment', 'barabi-core' ),
				'description' => esc_html__( 'Set widgets content alignment inside top header area', 'barabi-core' ),
				'options'     => array(
					''       => esc_html__( 'Default', 'barabi-core' ),
					'center' => esc_html__( 'Center', 'barabi-core' ),
				),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_top_area_header_background_color',
				'title'       => esc_html__( 'Top Area Background Color', 'barabi-core' ),
				'description' => esc_html__( 'Choose top area background color', 'barabi-core' ),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_top_area_header_border_color',
				'title'       => esc_html__( 'Top Area Border Color', 'barabi-core' ),
				'description' => esc_html__( 'Enter top area border color', 'barabi-core' ),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_top_area_header_border_width',
				'title'       => esc_html__( 'Top Area Border Width', 'barabi-core' ),
				'description' => esc_html__( 'Enter top area border width size', 'barabi-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'barabi-core' ),
				),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_top_area_header_border_style',
				'title'       => esc_html__( 'Top Area Border Style', 'barabi-core' ),
				'description' => esc_html__( 'Choose top area border style', 'barabi-core' ),
				'options'     => barabi_core_get_select_type_options_pool( 'border_style' ),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type' => 'select',
				'name'       => 'qodef_top_area_header_text_skin',
				'title'      => esc_html__( 'Top Area Text Skin', 'barabi-core' ),
				'options'    => array(
					''      => esc_html__( 'Default', 'barabi-core' ),
					'light' => esc_html__( 'Light', 'barabi-core' ),
				),
			)
		);
	}

	add_action( 'barabi_core_action_after_header_options_map', 'barabi_core_add_top_area_options', 20, 2 );
}
