<?php

if ( ! function_exists( 'teenglow_core_add_side_area_mobile_header_meta' ) ) {
	/**
	 * Function that add additional header layout meta box options
	 *
	 * @param object $page
	 */
	function teenglow_core_add_side_area_mobile_header_meta( $page ) {

		$section = $page->add_section_element(
			array(
				'name'       => 'qodef_side_area_mobile_header_section',
				'title'      => esc_html__( 'Side Area Mobile Header', 'teenglow-core' ),
				'dependency' => array(
					'show' => array(
						'qodef_mobile_header_layout' => array(
							'values'        => 'side-area',
							'default_value' => '',
						),
					),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_side_area_mobile_header_height',
				'title'       => esc_html__( 'Header Height', 'teenglow-core' ),
				'description' => esc_html__( 'Enter header height', 'teenglow-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'teenglow-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_side_area_mobile_header_side_padding',
				'title'       => esc_html__( 'Header Side Padding', 'teenglow-core' ),
				'description' => esc_html__( 'Enter side padding for header area', 'teenglow-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px or %', 'teenglow-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_side_area_mobile_header_background_color',
				'title'       => esc_html__( 'Header Background Color', 'teenglow-core' ),
				'description' => esc_html__( 'Enter header background color', 'teenglow-core' ),
			)
		);
	}

	add_action( 'teenglow_core_action_after_page_mobile_header_meta_map', 'teenglow_core_add_side_area_mobile_header_meta', 10, 2 );
}
