<?php

if ( ! function_exists( 'barabi_core_add_tutorial_single_meta_box' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function barabi_core_add_tutorial_single_meta_box() {
		$qode_framework = qode_framework_get_framework_root();
		$has_single     = barabi_core_tutorial_has_single();

		$page = $qode_framework->add_options_page(
			array(
				'scope'  => array( 'tutorial' ),
				'type'   => 'meta',
				'slug'   => 'tutorial',
				'title'  => esc_html__( 'Tutorial Settings', 'barabi-core' ),
				'layout' => 'tabbed',
			)
		);

		if ( $page ) {
			$general_tab = $page->add_tab_element(
				array(
					'name'        => 'tab-general',
					'icon'        => 'fa fa-cog',
					'title'       => esc_html__( 'General Settings', 'barabi-core' ),
					'description' => esc_html__( 'General tutorial settings', 'barabi-core' ),
				)
			);

			if ( $has_single ) {
				$general_tab->add_field_element(
					array(
						'field_type'  => 'select',
						'name'        => 'qodef_tutorial_single_layout',
						'title'       => esc_html__( 'Single Layout', 'barabi-core' ),
						'description' => esc_html__( 'Choose default layout for tutorial single', 'barabi-core' ),
						'options'     => array(
							''       => esc_html__( 'Standard', 'barabi-core' ),
							'custom' => esc_html__( 'Custom', 'barabi-core' ),
						),
					)
				);

				$general_tab->add_field_element(
					array(
						'field_type'  => 'text',
						'name'        => 'qodef_tutorial_video_url',
						'title'       => esc_html__( 'Video URL', 'barabi-core' ),
						'description' => esc_html__( 'Set tutorial\'s video url', 'barabi-core' ),
						'dependency'  => array(
							'hide' => array(
								'qodef_tutorial_single_layout' => array(
									'values'        => 'custom',
									'default_value' => '',
								),
							),
						),
					)
				);
			}

			// Hook to include additional options after module options
			do_action( 'barabi_core_action_after_tutorial_meta_box_map', $page, $general_tab, $has_single );
		}
	}

	add_action( 'barabi_core_action_default_meta_boxes_init', 'barabi_core_add_tutorial_single_meta_box' );
}
if ( ! function_exists( 'barabi_core_include_general_meta_boxes_for_portfolio_single' ) ) {
	/**
	 * Function that add general meta box options for this module
	 */
	function barabi_core_include_general_meta_boxes_for_portfolio_single() {
		$callbacks = barabi_core_general_meta_box_callbacks();

		if ( ! empty( $callbacks ) ) {
			foreach ( $callbacks as $module => $callback ) {

				if ( 'page-sidebar' !== $module ) {
					add_action( 'barabi_core_action_after_tutorial_meta_box_map', $callback );
				}
			}
		}
	}

	add_action( 'barabi_core_action_default_meta_boxes_init', 'barabi_core_include_general_meta_boxes_for_portfolio_single', 8 ); // Permission 8 is set in order to load it before default meta box function
}
