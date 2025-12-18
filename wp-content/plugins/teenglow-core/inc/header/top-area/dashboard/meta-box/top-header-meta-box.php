<?php
if ( ! function_exists( 'teenglow_core_add_top_area_meta_options' ) ) {
	/**
	 * Function that add additional header layout meta box options
	 *
	 * @param object $page
	 */
	function teenglow_core_add_top_area_meta_options( $page ) {
		$top_area_section = $page->add_section_element(
			array(
				'name'       => 'qodef_top_area_section',
				'title'      => esc_html__( 'Top Area', 'teenglow-core' ),
				'dependency' => array(
					'hide' => array(
						'qodef_header_layout' => array(
							'values'        => teenglow_core_dependency_for_top_area_options(),
							'default_value' => '',
						),
					),
				),
			)
		);

		$top_area_section->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_top_area_header',
				'title'       => esc_html__( 'Top Area', 'teenglow-core' ),
				'description' => esc_html__( 'Enable top area', 'teenglow-core' ),
				'options'     => teenglow_core_get_select_type_options_pool( 'yes_no' ),
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
				'field_type'    => 'select',
				'name'          => 'qodef_top_area_header_in_grid',
				'title'         => esc_html__( 'Content in Grid', 'teenglow-core' ),
				'description'   => esc_html__( 'Set content to be in grid', 'teenglow-core' ),
				'options'       => teenglow_core_get_select_type_options_pool( 'no_yes' ),
				'default_value' => '',
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

		$custom_sidebars = teenglow_core_get_custom_sidebars();
		if ( ! empty( $custom_sidebars ) && count( $custom_sidebars ) > 1 ) {
			$custom_sidebars = array_merge( $custom_sidebars, array( 'no' => esc_html__( 'None', 'teenglow-core' ) ) );
			$top_area_options_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_top_area_header_custom_widget_area_left',
					'title'       => esc_html__( 'Choose Custom Left Widget Area for Top Area Header', 'teenglow-core' ),
					'description' => esc_html__( 'Choose custom widget area to display in top area header inside left widget area', 'teenglow-core' ),
					'options'     => $custom_sidebars,
				)
			);

			$top_area_options_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_top_area_header_custom_widget_area_center',
					'title'       => esc_html__( 'Choose Custom Center Widget Area for Top Area Header', 'teenglow-core' ),
					'description' => esc_html__( 'Choose custom widget area to display in in the center of top header area', 'teenglow-core' ),
					'options'     => $custom_sidebars,
				)
			);

			$top_area_options_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_top_area_header_custom_widget_area_right',
					'title'       => esc_html__( 'Choose Custom Right Widget Area for Top Area Header', 'teenglow-core' ),
					'description' => esc_html__( 'Choose custom widget area to display in top area header inside right widget area', 'teenglow-core' ),
					'options'     => $custom_sidebars,
				)
			);
		}
		
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

	add_action( 'teenglow_core_action_after_page_header_meta_map', 'teenglow_core_add_top_area_meta_options', 20 );
}
