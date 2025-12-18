<?php

if ( ! function_exists( 'teenglow_core_add_tutorial_archive_sidebar_options' ) ) {
	/**
	 * Function that add sidebar options for tutorial archive module
	 */
	function teenglow_core_add_tutorial_archive_sidebar_options( $tab ) {

		if ( $tab ) {
			$tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_tutorial_archive_sidebar_layout',
					'title'         => esc_html__( 'Sidebar Layout', 'teenglow-core' ),
					'description'   => esc_html__( 'Choose default sidebar layout for tutorial archives', 'teenglow-core' ),
					'default_value' => 'no-sidebar',
					'options'       => teenglow_core_get_select_type_options_pool( 'sidebar_layouts', false ),
				)
			);

			$custom_sidebars = teenglow_core_get_custom_sidebars();
			if ( ! empty( $custom_sidebars ) && count( $custom_sidebars ) > 1 ) {
				$tab->add_field_element(
					array(
						'field_type'  => 'select',
						'name'        => 'qodef_tutorial_archive_custom_sidebar',
						'title'       => esc_html__( 'Custom Sidebar', 'teenglow-core' ),
						'description' => esc_html__( 'Choose a custom sidebar to display on tutorial archives', 'teenglow-core' ),
						'options'     => $custom_sidebars,
					)
				);
			}

			$tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_tutorial_archive_sidebar_grid_gutter',
					'title'       => esc_html__( 'Set Grid Gutter', 'teenglow-core' ),
					'description' => esc_html__( 'Choose grid gutter size to set space between content and sidebar', 'teenglow-core' ),
					'options'     => teenglow_core_get_select_type_options_pool( 'items_space' ),
				)
			);

			$tutorial_archive_sidebar_grid_gutter_row = $tab->add_row_element(
				array(
					'name'       => 'qodef_tutorial_archive_sidebar_grid_gutter_row',
					'dependency' => array(
						'show' => array(
							'qodef_tutorial_archive_sidebar_grid_gutter' => array(
								'values'        => 'custom',
								'default_value' => '',
							),
						),
					),
				)
			);

			$tutorial_archive_sidebar_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_tutorial_archive_sidebar_grid_gutter_custom',
					'title'       => esc_html__( 'Custom Grid Gutter', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$tutorial_archive_sidebar_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_tutorial_archive_sidebar_grid_gutter_custom_1440',
					'title'       => esc_html__( 'Custom Grid Gutter - 1440', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 1440px', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$tutorial_archive_sidebar_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_tutorial_archive_sidebar_grid_gutter_custom_1024',
					'title'       => esc_html__( 'Custom Grid Gutter - 1024', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 1024px', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$tutorial_archive_sidebar_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_tutorial_archive_sidebar_grid_gutter_custom_680',
					'title'       => esc_html__( 'Custom Grid Gutter - 680', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 680px', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);
		}
	}

	add_action( 'teenglow_core_action_after_tutorial_options_archive', 'teenglow_core_add_tutorial_archive_sidebar_options' );
}

if ( ! function_exists( 'teenglow_core_add_tutorial_single_sidebar_options' ) ) {
	/**
	 * Function that add sidebar options for tutorial single module
	 */
	function teenglow_core_add_tutorial_single_sidebar_options( $tab ) {

		if ( $tab ) {
			$tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_tutorial_single_sidebar_layout',
					'title'         => esc_html__( 'Sidebar Layout', 'teenglow-core' ),
					'description'   => esc_html__( 'Choose default sidebar layout for tutorial singles', 'teenglow-core' ),
					'default_value' => 'no-sidebar',
					'options'       => teenglow_core_get_select_type_options_pool( 'sidebar_layouts', false ),
				)
			);

			$custom_sidebars = teenglow_core_get_custom_sidebars();
			if ( ! empty( $custom_sidebars ) && count( $custom_sidebars ) > 1 ) {
				$tab->add_field_element(
					array(
						'field_type'  => 'select',
						'name'        => 'qodef_tutorial_single_custom_sidebar',
						'title'       => esc_html__( 'Custom Sidebar', 'teenglow-core' ),
						'description' => esc_html__( 'Choose a custom sidebar to display on tutorial singles', 'teenglow-core' ),
						'options'     => $custom_sidebars,
					)
				);
			}

			$tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_tutorial_single_sidebar_grid_gutter',
					'title'       => esc_html__( 'Set Grid Gutter', 'teenglow-core' ),
					'description' => esc_html__( 'Choose grid gutter size to set space between content and sidebar', 'teenglow-core' ),
					'options'     => teenglow_core_get_select_type_options_pool( 'items_space' ),
				)
			);

			$tutorial_single_sidebar_grid_gutter_row = $tab->add_row_element(
				array(
					'name'       => 'qodef_tutorial_single_sidebar_grid_gutter_row',
					'dependency' => array(
						'show' => array(
							'qodef_tutorial_single_sidebar_grid_gutter' => array(
								'values'        => 'custom',
								'default_value' => '',
							),
						),
					),
				)
			);

			$tutorial_single_sidebar_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_tutorial_single_sidebar_grid_gutter_custom',
					'title'       => esc_html__( 'Custom Grid Gutter', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$tutorial_single_sidebar_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_tutorial_single_sidebar_grid_gutter_custom_1440',
					'title'       => esc_html__( 'Custom Grid Gutter - 1440', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 1440px', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$tutorial_single_sidebar_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_tutorial_single_sidebar_grid_gutter_custom_1024',
					'title'       => esc_html__( 'Custom Grid Gutter - 1024', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 1024px', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$tutorial_single_sidebar_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_tutorial_single_sidebar_grid_gutter_custom_680',
					'title'       => esc_html__( 'Custom Grid Gutter - 680', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 680px', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);
		}
	}

	add_action( 'teenglow_core_action_after_tutorial_options_single', 'teenglow_core_add_tutorial_single_sidebar_options' );
}
