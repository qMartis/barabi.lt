<?php

if ( ! function_exists( 'barabi_core_add_content_bottom_meta_box' ) ) {
	/**
	 * Function that add general meta box options for this module
	 *
	 * @param object $page
	 */
	function barabi_core_add_content_bottom_meta_box( $page ) {

		if ( $page ) {

			$content_bottom_tab = $page->add_tab_element(
				array(
					'name'        => 'tab-content-bottom',
					'icon'        => 'fa fa-cog',
					'title'       => esc_html__( 'Content Bottom Settings', 'barabi-core' ),
					'description' => esc_html__( 'Content bottom layout settings', 'barabi-core' ),
				)
			);

			$content_bottom_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_enable_content_bottom',
					'title'       => esc_html__( 'Enable Content Bottom', 'barabi-core' ),
					'description' => esc_html__( 'Use this option to enable/disable page content bottom', 'barabi-core' ),
					'options'     => barabi_core_get_select_type_options_pool( 'no_yes' ),
				)
			);

			$content_bottom_section = $content_bottom_tab->add_section_element(
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

		$custom_sidebars = barabi_core_get_custom_sidebars();

		if ( ! empty( $custom_sidebars ) && count( $custom_sidebars ) > 1 ) {
			$content_bottom_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_content_bottom_custom_sidebar',
					'title'       => esc_html__( 'Custom Widget Area', 'barabi-core' ),
					'description' => esc_html__( 'Choose a custom widget area to display in content bottom area', 'barabi-core' ),
					'options'     => $custom_sidebars,
				)
			);
		}

		$content_bottom_section->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_content_bottom_in_grid',
				'title'       => esc_html__( 'Content Bottom In Grid', 'barabi-core' ),
				'description' => esc_html__( 'Enabling this option will set content bottom area to be in grid', 'barabi-core' ),
				'options'     => barabi_core_get_select_type_options_pool( 'no_yes' ),
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

	add_action( 'barabi_core_action_after_general_meta_box_map', 'barabi_core_add_content_bottom_meta_box' );
}
