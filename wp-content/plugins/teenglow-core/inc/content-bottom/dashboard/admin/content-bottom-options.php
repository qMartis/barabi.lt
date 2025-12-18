<?php

if ( ! function_exists( 'teenglow_core_add_content_bottom_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function teenglow_core_add_content_bottom_options() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope'       => TEENGLOW_CORE_OPTIONS_NAME,
				'type'        => 'admin',
				'slug'        => 'content-bottom',
				'icon'        => 'fa fa-cog',
				'title'       => esc_html__( 'Content Bottom', 'teenglow-core' ),
				'description' => esc_html__( 'Content Bottom Settings', 'teenglow-core' ),
			)
		);

		if ( $page ) {

			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_content_bottom',
					'title'         => esc_html__( 'Enable Content Bottom', 'teenglow-core' ),
					'description'   => esc_html__( 'Use this option to enable/disable page content bottom', 'teenglow-core' ),
					'default_value' => 'no',
				)
			);

			$content_bottom_section = $page->add_section_element(
				array(
					'name'       => 'qodef_content_bottom_section',
					'title'      => esc_html__( 'Content Bottom Area', 'teenglow-core' ),
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
				'title'         => esc_html__( 'Content Bottom In Grid', 'teenglow-core' ),
				'description'   => esc_html__( 'Enabling this option will set content bottom area to be in grid', 'teenglow-core' ),
				'default_value' => 'no',
			)
		);

		$content_bottom_section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_content_bottom_background_color',
				'title'       => esc_html__( 'Background Color', 'teenglow-core' ),
				'description' => esc_html__( 'Enter content bottom background color', 'teenglow-core' ),
			)
		);
	}

	add_action( 'teenglow_core_action_default_options_init', 'teenglow_core_add_content_bottom_options', teenglow_core_get_admin_options_map_position( 'content-bottom' ) );
}
