<?php

if ( ! function_exists( 'teenglow_core_add_page_spinner_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function teenglow_core_add_page_spinner_options( $page ) {

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_page_spinner',
					'title'         => esc_html__( 'Enable Page Spinner', 'teenglow-core' ),
					'description'   => esc_html__( 'Enable Page Spinner Effect', 'teenglow-core' ),
					'default_value' => 'no',
				)
			);

			$spinner_section = $page->add_section_element(
				array(
					'name'       => 'qodef_page_spinner_section',
					'title'      => esc_html__( 'Page Spinner Section', 'teenglow-core' ),
					'dependency' => array(
						'show' => array(
							'qodef_enable_page_spinner' => array(
								'values'        => 'yes',
								'default_value' => 'no',
							),
						),
					),
				)
			);

			$spinner_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_page_spinner_type',
					'title'         => esc_html__( 'Select Page Spinner Type', 'teenglow-core' ),
					'description'   => esc_html__( 'Choose a page spinner animation style', 'teenglow-core' ),
					'options'       => apply_filters( 'teenglow_core_filter_page_spinner_layout_options', array() ),
					'default_value' => apply_filters( 'teenglow_core_filter_page_spinner_default_layout_option', '' ),
				)
			);

			$spinner_section->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_page_spinner_background_color',
					'title'       => esc_html__( 'Spinner Background Color', 'teenglow-core' ),
					'description' => esc_html__( 'Choose the spinner background color', 'teenglow-core' ),
				)
			);

			$spinner_section->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_page_spinner_color',
					'title'       => esc_html__( 'Spinner Color', 'teenglow-core' ),
					'description' => esc_html__( 'Choose the spinner color', 'teenglow-core' ),
				)
			);

			$spinner_section->add_field_element(
				array(
					'field_type'    => 'text',
					'name'          => 'qodef_page_spinner_text',
					'title'         => esc_html__( 'Spinner Text', 'teenglow-core' ),
					'description'   => esc_html__( 'Enter the spinner text', 'teenglow-core' ),
					'default_value' => 'teenglow',
					'dependency'    => array(
						'show' => array(
							'qodef_page_spinner_type' => array(
								'values'        => 'textual',
								'default_value' => ''
							)
						)
					)
				)
			);

			$spinner_section->add_field_element(
				array(
					'field_type' => 'image',
					'name'       => 'qodef_spinner_image',
					'title'      => esc_html__( 'Upload Spinner Image', 'teenglow-core' ),
					'dependency' => array(
						'show' => array(
							'qodef_page_spinner_type' => array(
								'values'        => array(
									'predefined',
								),
								'default_value' => '',
							),
						),
					),
				)
			);

			$spinner_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_page_spinner_fade_out_animation',
					'title'         => esc_html__( 'Enable Fade Out Animation', 'teenglow-core' ),
					'description'   => esc_html__( 'Enabling this option will turn on fade out animation when leaving page', 'teenglow-core' ),
					'default_value' => 'no',
				)
			);
		}
	}

	add_action( 'teenglow_core_action_after_general_options_map', 'teenglow_core_add_page_spinner_options' );
}
