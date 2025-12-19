<?php

if ( ! function_exists( 'barabi_core_add_tutorial_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function barabi_core_add_tutorial_options() {
		$qode_framework = qode_framework_get_framework_root();
		$has_single     = barabi_core_tutorial_has_single();

		if ( $has_single ) {

			$page = $qode_framework->add_options_page(
				array(
					'scope'       => BARABI_CORE_OPTIONS_NAME,
					'type'        => 'admin',
					'slug'        => 'tutorial',
					'layout'      => 'tabbed',
					'icon'        => 'fa fa-cog',
					'title'       => esc_html__( 'Tutorial', 'barabi-core' ),
					'description' => esc_html__( 'Global Tutorial Options', 'barabi-core' ),
				)
			);

			if ( $page ) {
				$archive_tab = $page->add_tab_element(
					array(
						'name'        => 'tab-archive',
						'icon'        => 'fa fa-cog',
						'title'       => esc_html__( 'Archive Settings', 'barabi-core' ),
						'description' => esc_html__( 'Settings related to tutorial archive pages', 'barabi-core' ),
					)
				);

				do_action( 'barabi_core_action_after_tutorial_options_archive', $archive_tab );

				$single_tab = $page->add_tab_element(
					array(
						'name'        => 'tab-single',
						'icon'        => 'fa fa-cog',
						'title'       => esc_html__( 'Single Settings', 'barabi-core' ),
						'description' => esc_html__( 'Settings related to tutorial single pages', 'barabi-core' ),
					)
				);

				$single_tab->add_field_element(
					array(
						'field_type'  => 'select',
						'name'        => 'qodef_tutorial_single_layout',
						'title'       => esc_html__( 'Single Layout', 'barabi-core' ),
						'description' => esc_html__( 'Choose default layout for tutorial single', 'barabi-core' ),
						'options'     => array(
							''       => esc_html__( 'Default', 'barabi-core' ),
							'custom' => esc_html__( 'Custom', 'barabi-core' ),
						),
					)
				);

				do_action( 'barabi_core_action_after_tutorial_options_single', $single_tab );

				// Hook to include additional options after module options
				do_action( 'barabi_core_action_after_tutorial_options_map', $page );
			}
		}
	}

	add_action( 'barabi_core_action_default_options_init', 'barabi_core_add_tutorial_options', barabi_core_get_admin_options_map_position( 'tutorial' ) );
}
