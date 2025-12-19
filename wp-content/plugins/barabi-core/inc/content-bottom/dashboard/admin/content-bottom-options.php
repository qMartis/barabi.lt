<?php

if ( ! function_exists( 'barabi_core_add_content_bottom_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function barabi_core_add_content_bottom_options() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope'       => BARABI_CORE_OPTIONS_NAME,
				'type'        => 'admin',
				'slug'        => 'content-bottom',
				'icon'        => 'fa fa-cog',
				'title'       => esc_html__( 'Content Bottom', 'barabi-core' ),
				'description' => esc_html__( 'Content Bottom Settings', 'barabi-core' ),
			)
		);

		if ( $page ) {

			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_content_bottom',
					'title'         => esc_html__( 'Enable Content Bottom', 'barabi-core' ),
					'description'   => esc_html__( 'Use this option to enable/disable page content bottom', 'barabi-core' ),
					'default_value' => 'no',
				)
			);

			$content_bottom_section = $page->add_section_element(
				array(
					'name'       => 'qodef_content_bottom_section',
					'title'      => esc_html__( 'Content Bottom Area', 'barabi-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_enable_content_bottom' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

		}

		$content_bottom_section->add_field_element(
			array(
				'field_type'    => 'yesno',
				'name'          => 'qodef_content_bottom_in_grid',
				'title'         => esc_html__( 'Content Bottom In Grid', 'barabi-core' ),
				'description'   => esc_html__( 'Enabling this option will set content bottom area to be in grid', 'barabi-core' ),
				'default_value' => 'no',
			)
		);

		$content_bottom_section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_content_bottom_background_color',
				'title'       => esc_html__( 'Background Color', 'barabi-core' ),
				'description' => esc_html__( 'Enter content bottom background color', 'barabi-core' ),
			)
		);
	}

	add_action( 'barabi_core_action_default_options_init', 'barabi_core_add_content_bottom_options', barabi_core_get_admin_options_map_position( 'content-bottom' ) );
}
