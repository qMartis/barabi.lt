<?php

if ( ! function_exists( 'barabi_core_add_page_sidebar_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function barabi_core_add_page_sidebar_options() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope'       => BARABI_CORE_OPTIONS_NAME,
				'type'        => 'admin',
				'slug'        => 'sidebar',
				'icon'        => 'fa fa-book',
				'title'       => esc_html__( 'Sidebar', 'barabi-core' ),
				'description' => esc_html__( 'Global Sidebar Options', 'barabi-core' ),
			)
		);

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_page_sidebar_layout',
					'title'         => esc_html__( 'Sidebar Layout', 'barabi-core' ),
					'description'   => esc_html__( 'Choose a default sidebar layout for pages', 'barabi-core' ),
					'options'       => barabi_core_get_select_type_options_pool( 'sidebar_layouts', false ),
					'default_value' => 'no-sidebar',
				)
			);

			$custom_sidebars = barabi_core_get_custom_sidebars();
			if ( ! empty( $custom_sidebars ) && count( $custom_sidebars ) > 1 ) {
				$page->add_field_element(
					array(
						'field_type'  => 'select',
						'name'        => 'qodef_page_custom_sidebar',
						'title'       => esc_html__( 'Custom Sidebar', 'barabi-core' ),
						'description' => esc_html__( 'Choose a custom sidebar to display on pages', 'barabi-core' ),
						'options'     => $custom_sidebars,
					)
				);
			}

			$page->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_page_sidebar_grid_gutter',
					'title'       => esc_html__( 'Set Grid Gutter', 'barabi-core' ),
					'description' => esc_html__( 'Choose grid gutter size to set space between content and sidebar', 'barabi-core' ),
					'options'     => barabi_core_get_select_type_options_pool( 'items_space' ),
				)
			);

			$page_sidebar_grid_gutter_row = $page->add_row_element(
				array(
					'name'       => 'qodef_page_sidebar_grid_gutter_row',
					'dependency' => array(
						'show' => array(
							'qodef_page_sidebar_grid_gutter' => array(
								'values'        => 'custom',
								'default_value' => '',
							),
						),
					),
				)
			);

			$page_sidebar_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_sidebar_grid_gutter_custom',
					'title'       => esc_html__( 'Custom Grid Gutter', 'barabi-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels', 'barabi-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$page_sidebar_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_sidebar_grid_gutter_custom_1440',
					'title'       => esc_html__( 'Custom Grid Gutter - 1440', 'barabi-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 1440px', 'barabi-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$page_sidebar_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_sidebar_grid_gutter_custom_1024',
					'title'       => esc_html__( 'Custom Grid Gutter - 1024', 'barabi-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 1024px', 'barabi-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$page_sidebar_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_sidebar_grid_gutter_custom_680',
					'title'       => esc_html__( 'Custom Grid Gutter - 680', 'barabi-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 680px', 'barabi-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_sidebar_widgets_margin_bottom',
					'title'       => esc_html__( 'Widgets Margin Bottom', 'barabi-core' ),
					'description' => esc_html__( 'Set space value between widgets', 'barabi-core' ),
				)
			);

			// Hook to include additional options after module options
			do_action( 'barabi_core_action_after_page_sidebar_options_map', $page );
		}
	}

	add_action( 'barabi_core_action_default_options_init', 'barabi_core_add_page_sidebar_options', barabi_core_get_admin_options_map_position( 'sidebar' ) );
}
