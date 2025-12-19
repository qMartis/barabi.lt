<?php

if ( ! function_exists( 'barabi_core_fullscreen_menu_options' ) ) {
	/**
	 * Function that add global options for current module
	 */
	function barabi_core_fullscreen_menu_options() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope'       => BARABI_CORE_OPTIONS_NAME,
				'type'        => 'admin',
				'slug'        => 'fullscreen-menu',
				'icon'        => 'fa fa-cog',
				'title'       => esc_html__( 'Fullscreen Menu', 'barabi-core' ),
				'description' => esc_html__( 'Global Fullscreen Menu Options', 'barabi-core' ),
			)
		);

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_fullscreen_menu_in_grid',
					'title'         => esc_html__( 'Fullscreen Menu in Grid', 'barabi-core' ),
					'default_value' => 'yes',
				)
			);

			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_fullscreen_menu_hide_logo',
					'title'         => esc_html__( 'Fullscreen Menu Hide Logo', 'barabi-core' ),
					'default_value' => 'no',
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_fullscreen_menu_background_color',
					'title'      => esc_html__( 'Background Color', 'barabi-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_fullscreen_menu_image',
					'title'       => esc_html__( 'Image', 'barabi-core' ),
                    'description' => esc_html__( 'Upload image to be displayed on the right side of the fullscreen menu', 'barabi-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_fullscreen_menu_icon_source',
					'title'         => esc_html__( 'Icon Source', 'barabi-core' ),
					'options'       => barabi_core_get_select_type_options_pool( 'icon_source', false ),
					'default_value' => 'predefined',
				)
			);

			$page->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_fullscreen_menu_icon_pack',
					'title'         => esc_html__( 'Icon Pack', 'barabi-core' ),
					'options'       => qode_framework_icons()->get_icon_packs( array( 'linea-icons', 'dripicons', 'simple-line-icons' ) ),
					'default_value' => 'font-awesome',
					'dependency'    => array(
						'show' => array(
							'qodef_fullscreen_menu_icon_source' => array(
								'values'        => 'icon_pack',
								'default_value' => 'predefined',
							),
						),
					),
				)
			);

			$section_svg_path = $page->add_section_element(
				array(
					'title'      => esc_html__( 'SVG Path', 'barabi-core' ),
					'name'       => 'qodef_fullscreen_menu_svg_path_section',
					'dependency' => array(
						'show' => array(
							'qodef_fullscreen_menu_icon_source' => array(
								'values'        => 'svg_path',
								'default_value' => 'predefined',
							),
						),
					),
				)
			);

			$section_svg_path->add_field_element(
				array(
					'field_type'  => 'textarea',
					'name'        => 'qodef_fullscreen_menu_icon_svg_path',
					'title'       => esc_html__( 'Fullscreen Menu Open Icon SVG Path', 'barabi-core' ),
					'description' => esc_html__( 'Enter your full screen menu open icon SVG path here. Please remove version and id attributes from your SVG path because of HTML validation', 'barabi-core' ),
				)
			);

			$section_svg_path->add_field_element(
				array(
					'field_type'  => 'textarea',
					'name'        => 'qodef_fullscreen_menu_close_icon_svg_path',
					'title'       => esc_html__( 'Fullscreen Menu Close Icon SVG Path', 'barabi-core' ),
					'description' => esc_html__( 'Enter your full screen menu close icon SVG path here. Please remove version and id attributes from your SVG path because of HTML validation', 'barabi-core' ),
				)
			);

			// Hook to include additional options after module options
			do_action( 'barabi_core_action_after_fullscreen_menu_options_map', $page );
		}
	}

	add_action( 'barabi_core_action_default_options_init', 'barabi_core_fullscreen_menu_options', barabi_core_get_admin_options_map_position( 'fullscreen-menu' ) );
}
