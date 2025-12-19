<?php

if ( ! function_exists( 'teenglow_core_add_tutorial_archive_list_options' ) ) {
	/**
	 * Function that add list options for tutorial archive module
	 */
	function teenglow_core_add_tutorial_archive_list_options( $tab ) {
		$list_item_layouts = apply_filters( 'teenglow_core_filter_tutorial_list_layouts', array() );
		$options_map       = teenglow_core_get_variations_options_map( $list_item_layouts );

		if ( $tab ) {

			if ( sizeof( $list_item_layouts ) > 1 ) {
				$tab->add_field_element(
					array(
						'field_type'    => 'select',
						'name'          => 'qodef_tutorial_archive_item_layout',
						'title'         => esc_html__( 'Item Layout', 'teenglow-core' ),
						'description'   => esc_html__( 'Choose layout for list item on archive page', 'teenglow-core' ),
						'options'       => $list_item_layouts,
						'default_value' => $options_map['default_value'],
					)
				);
			}

			$tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_tutorial_archive_behavior',
					'title'       => esc_html__( 'List Appearance', 'teenglow-core' ),
					'description' => esc_html__( 'Choose an appearance style for archive list', 'teenglow-core' ),
					'options'     => teenglow_core_get_select_type_options_pool( 'list_behavior' ),
				)
			);

			$tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_tutorial_archive_columns',
					'title'       => esc_html__( 'Number of Columns', 'teenglow-core' ),
					'description' => esc_html__( 'Choose number of columns for archive list', 'teenglow-core' ),
					'options'     => teenglow_core_get_select_type_options_pool( 'columns_number' ),
				)
			);

			$tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_tutorial_archive_space',
					'title'       => esc_html__( 'Items Horizontal Spacing', 'teenglow-core' ),
					'description' => esc_html__( 'Choose horizontal space between items for archive list', 'teenglow-core' ),
					'options'     => teenglow_core_get_select_type_options_pool( 'items_space' ),
				)
			);

			$tutorial_archive_space_row = $tab->add_row_element(
				array(
					'name'       => 'qodef_tutorial_archive_space_row',
					'dependency' => array(
						'show' => array(
							'qodef_tutorial_archive_space' => array(
								'values'        => 'custom',
								'default_value' => '',
							),
						),
					),
				)
			);

			$tutorial_archive_space_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_tutorial_archive_space_custom',
					'title'       => esc_html__( 'Custom Horizontal Spacing', 'teenglow-core' ),
					'description' => esc_html__( 'Enter horizontal space between items in pixels', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$tutorial_archive_space_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_tutorial_archive_space_custom_1440',
					'title'       => esc_html__( 'Custom Horizontal Spacing - 1440', 'teenglow-core' ),
					'description' => esc_html__( 'Enter horizontal space between items in pixels below 1440px', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$tutorial_archive_space_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_tutorial_archive_space_custom_1024',
					'title'       => esc_html__( 'Custom Horizontal Spacing - 1024', 'teenglow-core' ),
					'description' => esc_html__( 'Enter horizontal space between items in pixels below 1024px', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$tutorial_archive_space_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_tutorial_archive_space_custom_680',
					'title'       => esc_html__( 'Custom Horizontal Spacing - 680', 'teenglow-core' ),
					'description' => esc_html__( 'Enter horizontal space between items in pixels below 680px', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_tutorial_archive_vertical_space',
					'title'       => esc_html__( 'Items Vertical Spacing', 'teenglow-core' ),
					'description' => esc_html__( 'Choose vertical space between items for archive lists', 'teenglow-core' ),
					'options'     => teenglow_core_get_select_type_options_pool( 'items_space' ),
				)
			);

			$tutorial_archive_vertical_space_row = $tab->add_row_element(
				array(
					'name'       => 'qodef_tutorial_archive_vertical_space_row',
					'dependency' => array(
						'show' => array(
							'qodef_tutorial_archive_vertical_space' => array(
								'values'        => 'custom',
								'default_value' => '',
							),
						),
					),
				)
			);

			$tutorial_archive_vertical_space_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_tutorial_archive_vertical_space_custom',
					'title'       => esc_html__( 'Custom Vertical Spacing', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$tutorial_archive_vertical_space_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_tutorial_archive_vertical_space_custom_1440',
					'title'       => esc_html__( 'Custom Vertical Spacing - 1440', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 1440px', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$tutorial_archive_vertical_space_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_tutorial_archive_vertical_space_custom_1024',
					'title'       => esc_html__( 'Custom Vertical Spacing - 1024', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 1024px', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$tutorial_archive_vertical_space_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_tutorial_archive_vertical_space_custom_680',
					'title'       => esc_html__( 'Custom Vertical Spacing - 680', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 680px', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_tutorial_archive_columns_responsive',
					'title'       => esc_html__( 'Columns Responsive', 'teenglow-core' ),
					'description' => esc_html__( 'Choose whether you wish to use predefined column number responsive settings, or to set column numbers for each responsive stage individually', 'teenglow-core' ),
					'options'     => teenglow_core_get_select_type_options_pool( 'columns_responsive' ),
				)
			);

			$tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_tutorial_archive_columns_1440',
					'title'         => esc_html__( 'Number of Columns 1367px - 1440px', 'teenglow-core' ),
					'description'   => esc_html__( 'Choose number of columns for screens between 1367 and 1440 px for archive list', 'teenglow-core' ),
					'default_value' => '3',
					'options'       => teenglow_core_get_select_type_options_pool( 'columns_number' ),
					'dependency'    => array(
						'show' => array(
							'qodef_tutorial_archive_columns_responsive' => array(
								'values'        => 'custom',
								'default_value' => '',
							),
						),
					),
				)
			);

			$tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_tutorial_archive_columns_1366',
					'title'         => esc_html__( 'Number of Columns 1025px - 1366px', 'teenglow-core' ),
					'description'   => esc_html__( 'Choose number of columns for screens between 1025 and 1366 px for archive list', 'teenglow-core' ),
					'default_value' => '3',
					'options'       => teenglow_core_get_select_type_options_pool( 'columns_number' ),
					'dependency'    => array(
						'show' => array(
							'qodef_tutorial_archive_columns_responsive' => array(
								'values'        => 'custom',
								'default_value' => '',
							),
						),
					),
				)
			);

			$tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_tutorial_archive_columns_1024',
					'title'         => esc_html__( 'Number of Columns 769px - 1024px', 'teenglow-core' ),
					'description'   => esc_html__( 'Choose number of columns for screens between 769 and 1024 px for archive list', 'teenglow-core' ),
					'default_value' => '3',
					'options'       => teenglow_core_get_select_type_options_pool( 'columns_number' ),
					'dependency'    => array(
						'show' => array(
							'qodef_tutorial_archive_columns_responsive' => array(
								'values'        => 'custom',
								'default_value' => '',
							),
						),
					),
				)
			);

			$tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_tutorial_archive_columns_768',
					'title'         => esc_html__( 'Number of Columns 681px - 768px', 'teenglow-core' ),
					'description'   => esc_html__( 'Choose number of columns for screens between 681 and 768 px for archive list', 'teenglow-core' ),
					'default_value' => '3',
					'options'       => teenglow_core_get_select_type_options_pool( 'columns_number' ),
					'dependency'    => array(
						'show' => array(
							'qodef_tutorial_archive_columns_responsive' => array(
								'values'        => 'custom',
								'default_value' => '',
							),
						),
					),
				)
			);

			$tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_tutorial_archive_columns_680',
					'title'         => esc_html__( 'Number of Columns 481px - 680px', 'teenglow-core' ),
					'description'   => esc_html__( 'Choose number of columns for screens between 481 and 680 px for archive list', 'teenglow-core' ),
					'default_value' => '3',
					'options'       => teenglow_core_get_select_type_options_pool( 'columns_number' ),
					'dependency'    => array(
						'show' => array(
							'qodef_tutorial_archive_columns_responsive' => array(
								'values'        => 'custom',
								'default_value' => '',
							),
						),
					),
				)
			);

			$tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_tutorial_archive_columns_480',
					'title'         => esc_html__( 'Number of Columns 0 - 480px', 'teenglow-core' ),
					'description'   => esc_html__( 'Choose number of columns for screens between 0 and 480 px for archive list', 'teenglow-core' ),
					'default_value' => '3',
					'options'       => teenglow_core_get_select_type_options_pool( 'columns_number' ),
					'dependency'    => array(
						'show' => array(
							'qodef_tutorial_archive_columns_responsive' => array(
								'values'        => 'custom',
								'default_value' => '',
							),
						),
					),
				)
			);

			$tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_tutorial_archive_slider_loop',
					'title'       => esc_html__( 'Enable Slider Loop', 'teenglow-core' ),
					'description' => esc_html__( 'Enable loop for slider display of archive list', 'teenglow-core' ),
					'options'     => teenglow_core_get_select_type_options_pool( 'yes_no' ),
					'dependency'  => array(
						'show' => array(
							'qodef_tutorial_archive_behavior' => array(
								'values'        => 'slider',
								'default_value' => '',
							),
						),
					),
				)
			);

			$tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_tutorial_archive_slider_autoplay',
					'title'       => esc_html__( 'Enable Slider Autoplay', 'teenglow-core' ),
					'description' => esc_html__( 'Enable autoplay for slider display of archive list', 'teenglow-core' ),
					'options'     => teenglow_core_get_select_type_options_pool( 'yes_no' ),
					'dependency'  => array(
						'show' => array(
							'qodef_tutorial_archive_behavior' => array(
								'values'        => 'slider',
								'default_value' => '',
							),
						),
					),
				)
			);

			$tab->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_tutorial_archive_slider_speed',
					'title'       => esc_html__( 'Slider Speed', 'teenglow-core' ),
					'description' => esc_html__( 'Enter slider speed for slider display of archive list', 'teenglow-core' ),
					'dependency'  => array(
						'show' => array(
							'qodef_tutorial_archive_behavior' => array(
								'values'        => 'slider',
								'default_value' => '',
							),
						),
					),
				)
			);

			$tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_tutorial_archive_slider_navigation',
					'title'         => esc_html__( 'Enable Slider Navigation', 'teenglow-core' ),
					'description'   => esc_html__( 'Enable navigation for slider display of archive list', 'teenglow-core' ),
					'default_value' => '3',
					'options'       => teenglow_core_get_select_type_options_pool( 'yes_no' ),
					'dependency'    => array(
						'show' => array(
							'qodef_tutorial_archive_behavior' => array(
								'values'        => 'slider',
								'default_value' => '',
							),
						),
					),
				)
			);

			$tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_tutorial_archive_slider_pagination',
					'title'         => esc_html__( 'Enable Slider Pagination', 'teenglow-core' ),
					'description'   => esc_html__( 'Enable pagination for slider display of archive list', 'teenglow-core' ),
					'default_value' => '3',
					'options'       => teenglow_core_get_select_type_options_pool( 'yes_no' ),
					'dependency'    => array(
						'show' => array(
							'qodef_tutorial_archive_behavior' => array(
								'values'        => 'slider',
								'default_value' => '',
							),
						),
					),
				)
			);

			$tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_tutorial_archive_pagination_type',
					'title'       => esc_html__( 'Pagination', 'teenglow-core' ),
					'description' => esc_html__( 'Choose pagination type for archive list', 'teenglow-core' ),
					'options'     => teenglow_core_get_select_type_options_pool( 'pagination_type' ),
					'dependency'  => array(
						'hide' => array(
							'qodef_tutorial_archive_behavior' => array(
								'values'        => 'slider',
								'default_value' => '',
							),
						),
					),
				)
			);
		}
	}

	add_action( 'teenglow_core_action_after_tutorial_options_archive', 'teenglow_core_add_tutorial_archive_list_options' );
}
