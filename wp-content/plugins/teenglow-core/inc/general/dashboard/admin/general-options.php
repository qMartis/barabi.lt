<?php

if ( ! function_exists( 'teenglow_core_add_general_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function teenglow_core_add_general_options( $page ) {

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_main_color',
					'title'       => esc_html__( 'Main Color', 'teenglow-core' ),
					'description' => esc_html__( 'Choose the most dominant theme color', 'teenglow-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_second_main_color',
					'title'       => esc_html__( 'Second Main Color', 'teenglow-core' ),
					'description' => esc_html__( 'Choose the second most dominant theme color', 'teenglow-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_page_background_color',
					'title'       => esc_html__( 'Page Background Color', 'teenglow-core' ),
					'description' => esc_html__( 'Set background color', 'teenglow-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_page_background_image',
					'title'       => esc_html__( 'Page Background Image', 'teenglow-core' ),
					'description' => esc_html__( 'Set background image', 'teenglow-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_page_background_repeat',
					'title'       => esc_html__( 'Page Background Image Repeat', 'teenglow-core' ),
					'description' => esc_html__( 'Set background image repeat', 'teenglow-core' ),
					'options'     => array(
						''          => esc_html__( 'Default', 'teenglow-core' ),
						'no-repeat' => esc_html__( 'No Repeat', 'teenglow-core' ),
						'repeat'    => esc_html__( 'Repeat', 'teenglow-core' ),
						'repeat-x'  => esc_html__( 'Repeat-x', 'teenglow-core' ),
						'repeat-y'  => esc_html__( 'Repeat-y', 'teenglow-core' ),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_page_background_size',
					'title'       => esc_html__( 'Page Background Image Size', 'teenglow-core' ),
					'description' => esc_html__( 'Set background image size', 'teenglow-core' ),
					'options'     => array(
						''        => esc_html__( 'Default', 'teenglow-core' ),
						'contain' => esc_html__( 'Contain', 'teenglow-core' ),
						'cover'   => esc_html__( 'Cover', 'teenglow-core' ),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_page_background_attachment',
					'title'       => esc_html__( 'Page Background Image Attachment', 'teenglow-core' ),
					'description' => esc_html__( 'Set background image attachment', 'teenglow-core' ),
					'options'     => array(
						''       => esc_html__( 'Default', 'teenglow-core' ),
						'fixed'  => esc_html__( 'Fixed', 'teenglow-core' ),
						'scroll' => esc_html__( 'Scroll', 'teenglow-core' ),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_content_padding',
					'title'       => esc_html__( 'Page Content Padding', 'teenglow-core' ),
					'description' => esc_html__( 'Set padding that will be applied for page content in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'teenglow-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_content_margin',
					'title'       => esc_html__( 'Page Content Margin', 'teenglow-core' ),
					'description' => esc_html__( 'Set margin that will be applied for page content in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'teenglow-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_content_padding_mobile',
					'title'       => esc_html__( 'Page Content Padding Mobile', 'teenglow-core' ),
					'description' => esc_html__( 'Set padding that will be applied for page content on mobile screens (1024px and below) in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'teenglow-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_content_margin_mobile',
					'title'       => esc_html__( 'Page Content Margin Mobile', 'teenglow-core' ),
					'description' => esc_html__( 'Set margin that will be applied for page content on mobile screens (1024px and below) in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'teenglow-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_boxed',
					'title'         => esc_html__( 'Boxed Layout', 'teenglow-core' ),
					'description'   => esc_html__( 'Set boxed layout', 'teenglow-core' ),
					'default_value' => 'no',
				)
			);

			$boxed_section = $page->add_section_element(
				array(
					'name'       => 'qodef_boxed_section',
					'title'      => esc_html__( 'Boxed Layout Section', 'teenglow-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_boxed' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			$boxed_section->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_boxed_background_color',
					'title'       => esc_html__( 'Boxed Background Color', 'teenglow-core' ),
					'description' => esc_html__( 'Set boxed background color', 'teenglow-core' ),
				)
			);

			$boxed_section->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_boxed_background_pattern',
					'title'       => esc_html__( 'Boxed Background Pattern', 'teenglow-core' ),
					'description' => esc_html__( 'Set boxed background pattern', 'teenglow-core' ),
				)
			);

			$boxed_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_boxed_background_pattern_behavior',
					'title'       => esc_html__( 'Boxed Background Pattern Behavior', 'teenglow-core' ),
					'description' => esc_html__( 'Set boxed background pattern behavior', 'teenglow-core' ),
					'options'     => array(
						'fixed'  => esc_html__( 'Fixed', 'teenglow-core' ),
						'scroll' => esc_html__( 'Scroll', 'teenglow-core' ),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_passepartout',
					'title'         => esc_html__( 'Passepartout', 'teenglow-core' ),
					'description'   => esc_html__( 'Enabling this option will display a passepartout around website content', 'teenglow-core' ),
					'default_value' => 'no',
				)
			);

			$passepartout_section = $page->add_section_element(
				array(
					'name'       => 'qodef_passepartout_section',
					'title'      => esc_html__( 'Passepartout Section', 'teenglow-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_passepartout' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			$passepartout_section->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_passepartout_color',
					'title'       => esc_html__( 'Passepartout Color', 'teenglow-core' ),
					'description' => esc_html__( 'Choose background color for passepartout', 'teenglow-core' ),
				)
			);

			$passepartout_section->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_passepartout_image',
					'title'       => esc_html__( 'Passepartout Background Image', 'teenglow-core' ),
					'description' => esc_html__( 'Set background image for passepartout', 'teenglow-core' ),
				)
			);

			$passepartout_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_passepartout_size',
					'title'       => esc_html__( 'Passepartout Size', 'teenglow-core' ),
					'description' => esc_html__( 'Enter size amount for passepartout', 'teenglow-core' ),
					'args'        => array(
						'suffix' => esc_html__( 'px or %', 'teenglow-core' ),
					),
				)
			);

			$passepartout_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_passepartout_size_responsive',
					'title'       => esc_html__( 'Passepartout Responsive Size', 'teenglow-core' ),
					'description' => esc_html__( 'Enter size amount for passepartout for smaller screens (1024px and below)', 'teenglow-core' ),
					'args'        => array(
						'suffix' => esc_html__( 'px or %', 'teenglow-core' ),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_content_width',
					'title'         => esc_html__( 'Initial Width of Content', 'teenglow-core' ),
					'description'   => esc_html__( 'Choose the initial width of content which is in grid (applies to pages set to "Default Template" and rows set to "In Grid")', 'teenglow-core' ),
					'options'       => teenglow_core_get_select_type_options_pool( 'content_width', false ),
					'default_value' => '1100',
				)
			);

			// Hook to include additional options after module options
			do_action( 'teenglow_core_action_after_general_options_map', $page );

			$page->add_field_element(
				array(
					'field_type'  => 'textarea',
					'name'        => 'qodef_custom_js',
					'title'       => esc_html__( 'Custom JS', 'teenglow-core' ),
					'description' => esc_html__( 'Enter your custom JavaScript here', 'teenglow-core' ),
				)
			);
		}
	}

	add_action( 'teenglow_core_action_default_options_init', 'teenglow_core_add_general_options', teenglow_core_get_admin_options_map_position( 'general' ) );
}
