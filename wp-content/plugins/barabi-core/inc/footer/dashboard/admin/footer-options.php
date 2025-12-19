<?php

if ( ! function_exists( 'barabi_core_add_page_footer_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function barabi_core_add_page_footer_options() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope'       => BARABI_CORE_OPTIONS_NAME,
				'type'        => 'admin',
				'slug'        => 'footer',
				'icon'        => 'fa fa-cog',
				'title'       => esc_html__( 'Footer', 'barabi-core' ),
				'description' => esc_html__( 'Global Footer Options', 'barabi-core' ),
			)
		);

		if ( $page ) {

			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_page_footer',
					'title'         => esc_html__( 'Enable Page Footer', 'barabi-core' ),
					'description'   => esc_html__( 'Use this option to enable/disable page footer', 'barabi-core' ),
					'default_value' => 'yes',
				)
			);

			$page_footer_section = $page->add_section_element(
				array(
					'name'       => 'qodef_page_footer_section',
					'title'      => esc_html__( 'Footer Area', 'barabi-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_enable_page_footer' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			// General Footer Area Options

			$page_footer_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_uncovering_footer',
					'title'         => esc_html__( 'Enable Uncovering Footer', 'barabi-core' ),
					'description'   => esc_html__( 'Enabling this option will make Footer gradually appear on scroll', 'barabi-core' ),
					'default_value' => 'no',
				)
			);

			$page_footer_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_footer_skin',
					'title'         => esc_html__( 'Footer Area Skin', 'barabi-core' ),
					'options'       => array(
						'' => esc_html__( 'Default', 'barabi-core' ),
						'light' => esc_html__( 'Light', 'barabi-core' ),
						'dark' => esc_html__( 'Dark', 'barabi-core' ),
					),
					'default_value' => ''
				)
			);

			// Top Footer Area Section

			$page_footer_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_top_footer_area',
					'title'         => esc_html__( 'Enable Top Footer Area', 'barabi-core' ),
					'description'   => esc_html__( 'Use this option to enable/disable top footer area', 'barabi-core' ),
					'default_value' => 'yes',
				)
			);

			$top_footer_area_section = $page_footer_section->add_section_element(
				array(
					'name'       => 'qodef_top_footer_area_section',
					'title'      => esc_html__( 'Top Footer Area', 'barabi-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_enable_top_footer_area' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			$top_footer_area_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_set_footer_top_area_in_grid',
					'title'         => esc_html__( 'Top Footer Area In Grid', 'barabi-core' ),
					'description'   => esc_html__( 'Enabling this option will set page top footer area to be in grid', 'barabi-core' ),
					'default_value' => 'yes',
				)
			);

			$top_footer_area_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_set_footer_top_area_columns',
					'title'         => esc_html__( 'Top Footer Area Columns', 'barabi-core' ),
					'description'   => esc_html__( 'Choose number of columns for top footer area', 'barabi-core' ),
					'options'       => barabi_core_get_select_type_options_pool( 'columns_number', true, array( '5', '6' ) ),
					'default_value' => '4',
				)
			);

			$top_footer_area_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_set_footer_top_column_proportions',
					'title'         => esc_html__( 'Column Proportions', 'barabi-core' ),
					'options'       => array(
						'qodef-proportions--standard'  => '1/4 + 1/4 + 1/4 + 1/4',
						'qodef-proportions--predefined' => '1/2 + 1/6 + 1/6 + 1/6',
					),
					'default_value' => 'qodef-proportions--predefined',
					'dependency' => array(
						'show' => array(
							'qodef_set_footer_top_area_columns' => array(
								'values'        => '4',
								'default_value' => '4',
							)
						)
					)
				)
			);

			$top_footer_area_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_set_footer_top_area_grid_gutter',
					'title'       => esc_html__( 'Top Footer Area Grid Gutter', 'barabi-core' ),
					'description' => esc_html__( 'Choose grid gutter size to set space between columns for top footer area', 'barabi-core' ),
					'options'     => barabi_core_get_select_type_options_pool( 'items_space' ),
				)
			);

			$footer_top_area_grid_gutter_row = $top_footer_area_section->add_row_element(
				array(
					'name'       => 'qodef_set_footer_top_area_grid_gutter_row',
					'dependency' => array(
						'show' => array(
							'qodef_set_footer_top_area_grid_gutter' => array(
								'values'        => 'custom',
								'default_value' => '',
							),
						),
					),
				)
			);

			$footer_top_area_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_set_footer_top_area_grid_gutter_custom',
					'title'       => esc_html__( 'Custom Grid Gutter', 'barabi-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels', 'barabi-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$footer_top_area_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_set_footer_top_area_grid_gutter_custom_1440',
					'title'       => esc_html__( 'Custom Grid Gutter - 1440', 'barabi-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 1440px', 'barabi-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$footer_top_area_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_set_footer_top_area_grid_gutter_custom_1024',
					'title'       => esc_html__( 'Custom Grid Gutter - 1024', 'barabi-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 1024px', 'barabi-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$footer_top_area_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_set_footer_top_area_grid_gutter_custom_680',
					'title'       => esc_html__( 'Custom Grid Gutter - 680', 'barabi-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 680px', 'barabi-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$top_footer_area_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_set_footer_top_area_content_alignment',
					'title'       => esc_html__( 'Content Alignment', 'barabi-core' ),
					'description' => esc_html__( 'Set widgets content alignment inside top footer area', 'barabi-core' ),
					'options'     => array(
						''       => esc_html__( 'Default', 'barabi-core' ),
						'left'   => esc_html__( 'Left', 'barabi-core' ),
						'center' => esc_html__( 'Center', 'barabi-core' ),
						'right'  => esc_html__( 'Right', 'barabi-core' ),
					),
				)
			);

			$top_footer_area_styles_section = $top_footer_area_section->add_section_element(
				array(
					'name'  => 'qodef_top_footer_area_styles_section',
					'title' => esc_html__( 'Top Footer Area Styles', 'barabi-core' ),
				)
			);

			$top_footer_area_styles_row = $top_footer_area_styles_section->add_row_element(
				array(
					'name'  => 'qodef_top_footer_area_styles_row',
					'title' => '',
				)
			);

			$top_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_top_footer_area_padding_top',
					'title'      => esc_html__( 'Padding Top', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$top_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_top_footer_area_padding_bottom',
					'title'      => esc_html__( 'Padding Bottom', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$top_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_top_footer_area_side_padding',
					'title'      => esc_html__( 'Side Padding', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$top_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_top_footer_area_background_color',
					'title'      => esc_html__( 'Background Color', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$top_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'image',
					'name'       => 'qodef_top_footer_area_background_image',
					'title'      => esc_html__( 'Background Image', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$top_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_top_footer_area_top_border_color',
					'title'      => esc_html__( 'Top Border Color', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$top_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_top_footer_area_top_border_width',
					'title'      => esc_html__( 'Top Border Width', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
						'suffix'    => esc_html__( 'px', 'barabi-core' ),
					),
				)
			);

			$top_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_top_footer_area_top_border_style',
					'title'      => esc_html__( 'Top Border Style', 'barabi-core' ),
					'options'    => barabi_core_get_select_type_options_pool( 'border_style' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$top_footer_area_styles_row_2 = $top_footer_area_styles_section->add_row_element(
				array(
					'name'  => 'qodef_top_footer_area_styles_row_2',
					'title' => '',
				)
			);

			$top_footer_area_styles_row_2->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_top_footer_area_widgets_margin_bottom',
					'title'       => esc_html__( 'Widgets Margin Bottom', 'barabi-core' ),
					'description' => esc_html__( 'Set space value between widgets', 'barabi-core' ),
					'args'        => array(
						'col_width' => 4,
					),
				)
			);

			$top_footer_area_styles_row_2->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_top_footer_area_widgets_title_margin_bottom',
					'title'       => esc_html__( 'Widgets Title Margin Bottom', 'barabi-core' ),
					'description' => esc_html__( 'Set space value between widget title and widget content', 'barabi-core' ),
					'args'        => array(
						'col_width' => 4,
					),
				)
			);

			// Bottom Footer Area Section

			$page_footer_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_bottom_footer_area',
					'title'         => esc_html__( 'Enable Bottom Footer Area', 'barabi-core' ),
					'description'   => esc_html__( 'Use this option to enable/disable bottom footer area', 'barabi-core' ),
					'default_value' => 'yes',
				)
			);

			$bottom_footer_area_section = $page_footer_section->add_section_element(
				array(
					'name'       => 'qodef_bottom_footer_area_section',
					'title'      => esc_html__( 'Bottom Footer Area', 'barabi-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_enable_bottom_footer_area' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			$bottom_footer_area_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_set_footer_bottom_area_in_grid',
					'title'         => esc_html__( 'Bottom Footer Area In Grid', 'barabi-core' ),
					'description'   => esc_html__( 'Enabling this option will set page bottom footer area to be in grid', 'barabi-core' ),
					'default_value' => 'yes',
				)
			);

			$bottom_footer_area_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_set_footer_bottom_area_columns',
					'title'         => esc_html__( 'Bottom Footer Area Columns', 'barabi-core' ),
					'description'   => esc_html__( 'Choose number of columns for bottom footer area', 'barabi-core' ),
					'options'       => barabi_core_get_select_type_options_pool( 'columns_number', true, array( '5', '6' ) ),
					'default_value' => '4',
				)
			);

			$bottom_footer_area_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_set_footer_bottom_column_proportions',
					'title'         => esc_html__( 'Column Proportions', 'barabi-core' ),
					'options'       => array(
						'qodef-proportions--standard'  => '1/4 + 1/4 + 1/4 + 1/4',
						'qodef-proportions--predefined' => '1/2 + 1/6 + 1/6 + 1/6',
					),
					'default_value' => 'qodef-proportions--predefined',
					'dependency' => array(
						'show' => array(
							'qodef_set_footer_bottom_area_columns' => array(
								'values'        => '4',
								'default_value' => '4',
							)
						)
					)
				)
			);

			$bottom_footer_area_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_set_footer_bottom_area_grid_gutter',
					'title'       => esc_html__( 'Bottom Footer Area Grid Gutter', 'barabi-core' ),
					'description' => esc_html__( 'Choose grid gutter size to set space between columns for bottom footer area', 'barabi-core' ),
					'options'     => barabi_core_get_select_type_options_pool( 'items_space' ),
				)
			);

			$footer_bottom_area_grid_gutter_row = $bottom_footer_area_section->add_row_element(
				array(
					'name'       => 'qodef_set_footer_bottom_area_grid_gutter_row',
					'dependency' => array(
						'show' => array(
							'qodef_set_footer_bottom_area_grid_gutter' => array(
								'values'        => 'custom',
								'default_value' => '',
							),
						),
					),
				)
			);

			$footer_bottom_area_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_set_footer_bottom_area_grid_gutter_custom',
					'title'       => esc_html__( 'Custom Grid Gutter', 'barabi-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels', 'barabi-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$footer_bottom_area_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_set_footer_bottom_area_grid_gutter_custom_1440',
					'title'       => esc_html__( 'Custom Grid Gutter - 1440', 'barabi-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 1440px', 'barabi-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$footer_bottom_area_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_set_footer_bottom_area_grid_gutter_custom_1024',
					'title'       => esc_html__( 'Custom Grid Gutter - 1024', 'barabi-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 1024px', 'barabi-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$footer_bottom_area_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_set_footer_bottom_area_grid_gutter_custom_680',
					'title'       => esc_html__( 'Custom Grid Gutter - 680', 'barabi-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 680px', 'barabi-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$bottom_footer_area_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_set_footer_bottom_area_content_alignment',
					'title'       => esc_html__( 'Content Alignment', 'barabi-core' ),
					'description' => esc_html__( 'Set widgets content alignment inside bottom footer area', 'barabi-core' ),
					'options'     => array(
						''              => esc_html__( 'Default', 'barabi-core' ),
						'left'          => esc_html__( 'Left', 'barabi-core' ),
						'center'        => esc_html__( 'Center', 'barabi-core' ),
						'right'         => esc_html__( 'Right', 'barabi-core' ),
						'space-between' => esc_html__( 'Space Between', 'barabi-core' ),
					),
				)
			);

			$bottom_footer_area_section->add_field_element(
				array(
					'field_type' => 'yesno',
					'name'       => 'qodef_bottom_footer_enable_label',
					'title'      => esc_html__( 'Display Footer Bottom Label', 'barabi-core' ),
					'default_value' => 'yes'
				)
			);

			$bottom_footer_area_section->add_field_element(
				array(
					'field_type'    => 'text',
					'name'          => 'qodef_bottom_footer_label_text',
					'title'         => esc_html__( 'Label: ', 'barabi-core' ),
					'default_value' => 'Teenglo',
					'dependency'    => array(
						'show' => array(
							'qodef_bottom_footer_enable_label' => array(
								'values' => 'yes',
								'default_value' => ''
							)
						)
					)
				)
			);

			$bottom_footer_area_styles_section = $bottom_footer_area_section->add_section_element(
				array(
					'name'  => 'qodef_bottom_footer_area_styles_section',
					'title' => esc_html__( 'Bottom Footer Area Styles', 'barabi-core' ),
				)
			);

			$bottom_footer_area_styles_row = $bottom_footer_area_styles_section->add_row_element(
				array(
					'name'  => 'qodef_bottom_footer_area_styles_row',
					'title' => '',
				)
			);

			$bottom_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_bottom_footer_area_padding_top',
					'title'      => esc_html__( 'Padding Top', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$bottom_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_bottom_footer_area_padding_bottom',
					'title'      => esc_html__( 'Padding Bottom', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$bottom_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_bottom_footer_area_side_padding',
					'title'      => esc_html__( 'Side Padding', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$bottom_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_bottom_footer_area_background_color',
					'title'      => esc_html__( 'Background Color', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$bottom_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_bottom_footer_area_top_border_color',
					'title'      => esc_html__( 'Top Border Color', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$bottom_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_bottom_footer_area_top_border_width',
					'title'      => esc_html__( 'Top Border Width', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
						'suffix'    => esc_html__( 'px', 'barabi-core' ),
					),
				)
			);

			$bottom_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_bottom_footer_area_top_border_style',
					'title'      => esc_html__( 'Top Border Style', 'barabi-core' ),
					'options'    => barabi_core_get_select_type_options_pool( 'border_style' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			// Hook to include additional options after module options
			do_action( 'barabi_core_action_after_page_footer_options_map', $page );
		}
	}

	add_action( 'barabi_core_action_default_options_init', 'barabi_core_add_page_footer_options', barabi_core_get_admin_options_map_position( 'footer' ) );
}
