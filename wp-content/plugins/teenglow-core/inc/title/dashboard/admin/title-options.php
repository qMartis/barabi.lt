<?php

if ( ! function_exists( 'teenglow_core_add_page_title_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function teenglow_core_add_page_title_options() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope'       => TEENGLOW_CORE_OPTIONS_NAME,
				'type'        => 'admin',
				'slug'        => 'title',
				'icon'        => 'fa fa-cog',
				'title'       => esc_html__( 'Title', 'teenglow-core' ),
				'description' => esc_html__( 'Global Title Options', 'teenglow-core' ),
			)
		);

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_page_title',
					'title'         => esc_html__( 'Enable Page Title', 'teenglow-core' ),
					'description'   => esc_html__( 'Use this option to enable/disable page title', 'teenglow-core' ),
					'default_value' => 'yes',
				)
			);

			$page_title_section = $page->add_section_element(
				array(
					'name'       => 'qodef_page_title_section',
					'title'      => esc_html__( 'Title Area', 'teenglow-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_enable_page_title' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_title_layout',
					'title'         => esc_html__( 'Title Layout', 'teenglow-core' ),
					'description'   => esc_html__( 'Choose a title layout', 'teenglow-core' ),
					'options'       => apply_filters( 'teenglow_core_filter_title_layout_options', array() ),
					'default_value' => 'standard',
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_page_title_predefined_layout',
					'title'         => esc_html__( 'Page Title Predefined Layout', 'teenglow-core' ),
					'default_value' => 'no',
					'dependency'    => array(
						'show' => array(
							'qodef_title_layout' => array(
								'values' => 'standard',
								'default_value' => ''
							)
						)
					)
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_set_page_title_area_in_grid',
					'title'         => esc_html__( 'Page Title In Grid', 'teenglow-core' ),
					'description'   => esc_html__( 'Enabling this option will set page title area to be in grid', 'teenglow-core' ),
					'default_value' => 'yes',
				)
			);



			$page_title_section->add_field_element(
				array(
					'field_type'    => 'text',
					'name'          => 'qodef_page_title_side_padding',
					'title'         => esc_html__( 'Page Title Side Padding', 'teenglow-core' ),
					'args'        => array(
						'suffix' => esc_html__( 'px or %', 'teenglow-core' ),
					),
					'dependency'    => array(
						'show' => array (
							'qodef_set_page_title_area_in_grid' => array(
								'values' => 'no',
								'default_value' => ''
							)
						)
					)
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_title_height',
					'title'       => esc_html__( 'Height', 'teenglow-core' ),
					'description' => esc_html__( 'Enter title height', 'teenglow-core' ),
					'args'        => array(
						'suffix' => esc_html__( 'px', 'teenglow-core' ),
					),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_title_height_on_smaller_screens',
					'title'       => esc_html__( 'Height on Smaller Screens', 'teenglow-core' ),
					'description' => esc_html__( 'Enter title height to be displayed on smaller screens with active mobile header', 'teenglow-core' ),
					'args'        => array(
						'suffix' => esc_html__( 'px', 'teenglow-core' ),
					),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_title_additional_bottom_offset',
					'title'       => esc_html__( 'Page Title Additional Bottom Offset', 'teenglow-core' ),
					'description' => esc_html__( 'Enter additional offset for title, that will be applied from bottom', 'teenglow-core' ),
					'args'        => array(
						'suffix' => esc_html__( 'px', 'teenglow-core' ),
					),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_page_title_background_color',
					'title'       => esc_html__( 'Background Color', 'teenglow-core' ),
					'description' => esc_html__( 'Enter page title area background color', 'teenglow-core' ),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_page_title_background_image',
					'title'       => esc_html__( 'Background Image', 'teenglow-core' ),
					'description' => esc_html__( 'Enter page title area background image', 'teenglow-core' ),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_page_title_background_image_behavior',
					'title'      => esc_html__( 'Background Image Behavior', 'teenglow-core' ),
					'options'    => array(
						''           => esc_html__( 'Default', 'teenglow-core' ),
						'responsive' => esc_html__( 'Set Responsive Image', 'teenglow-core' ),
						'parallax'   => esc_html__( 'Set Parallax Image', 'teenglow-core' ),
					),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_page_title_color',
					'title'      => esc_html__( 'Title Color', 'teenglow-core' ),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_page_title_tag',
					'title'         => esc_html__( 'Title Tag', 'teenglow-core' ),
					'description'   => esc_html__( 'Enabling this option will set title tag', 'teenglow-core' ),
					'options'       => teenglow_core_get_select_type_options_pool( 'title_tag', false ),
					'default_value' => 'h1',
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_page_title_text_alignment',
					'title'         => esc_html__( 'Text Alignment', 'teenglow-core' ),
					'options'       => array(
						'left'   => esc_html__( 'Left', 'teenglow-core' ),
						'center' => esc_html__( 'Center', 'teenglow-core' ),
						'right'  => esc_html__( 'Right', 'teenglow-core' ),
					),
					'default_value' => 'left',
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_page_title_vertical_text_alignment',
					'title'         => esc_html__( 'Vertical Text Alignment', 'teenglow-core' ),
					'options'       => array(
						'header-bottom' => esc_html__( 'From Bottom of Header', 'teenglow-core' ),
						'window-top'    => esc_html__( 'From Window Top', 'teenglow-core' ),
					),
					'default_value' => 'header-bottom',
				)
			);

			// Hook to include additional options after module options
			do_action( 'teenglow_core_action_after_page_title_options_map', $page_title_section );
		}
	}

	add_action( 'teenglow_core_action_default_options_init', 'teenglow_core_add_page_title_options', teenglow_core_get_admin_options_map_position( 'title' ) );
}
