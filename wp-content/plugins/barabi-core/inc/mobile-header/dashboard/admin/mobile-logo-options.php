<?php

if ( ! function_exists( 'barabi_core_add_mobile_logo_options' ) ) {
	/**
	 * Function that add general options for this module
	 *
	 * @param object $page
	 * @param object $mobile_header_tab
	 */
	function barabi_core_add_mobile_logo_options( $page, $mobile_header_tab ) {

		if ( $page ) {

			$mobile_header_tab = $page->add_tab_element(
				array(
					'name'        => 'tab-mobile-header',
					'icon'        => 'fa fa-cog',
					'title'       => esc_html__( 'Mobile Header Logo Options', 'barabi-core' ),
					'description' => esc_html__( 'Set options for mobile headers', 'barabi-core' ),
				)
			);

			$mobile_header_tab->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_mobile_logo_height',
					'title'       => esc_html__( 'Mobile Logo Height', 'barabi-core' ),
					'description' => esc_html__( 'Enter mobile logo height', 'barabi-core' ),
					'args'        => array(
						'suffix' => esc_html__( 'px', 'barabi-core' ),
					),
				)
			);

			$mobile_header_tab->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_mobile_logo_padding',
					'title'       => esc_html__( 'Mobile Logo Padding', 'barabi-core' ),
					'description' => esc_html__( 'Enter mobile logo padding value (top right bottom left)', 'barabi-core' ),
				)
			);

			$mobile_header_tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_mobile_logo_source',
					'title'         => esc_html__( 'Mobile Logo Source', 'barabi-core' ),
					'options'       => array(
						'image'    => esc_html__( 'Image', 'barabi-core' ),
						'svg-path' => esc_html__( 'SVG Path', 'barabi-core' ),
						'textual'  => esc_html__( 'Textual', 'barabi-core' ),
					),
					'default_value' => 'image',
				)
			);

			$logo_image_section = $mobile_header_tab->add_section_element(
				array(
					'title'      => esc_html__( 'Image settings', 'barabi-core' ),
					'name'       => 'qodef_mobile_logo_image_section',
					'dependency' => array(
						'show' => array(
							'qodef_mobile_logo_source' => array(
								'values'        => 'image',
								'default_value' => 'image',
							),
						),
					),
				)
			);

			$logo_image_section->add_field_element(
				array(
					'field_type'    => 'image',
					'name'          => 'qodef_mobile_logo_main',
					'title'         => esc_html__( 'Mobile Logo - Main', 'barabi-core' ),
					'description'   => esc_html__( 'Choose main mobile logo image', 'barabi-core' ),
					'default_value' => defined( 'BARABI_ASSETS_ROOT' ) ? BARABI_ASSETS_ROOT . '/img/logo.png' : '',
					'multiple'      => 'no',
				)
			);

			$logo_image_section->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_mobile_logo_dark',
					'title'       => esc_html__( 'Mobile Logo - Dark', 'barabi-core' ),
					'description' => esc_html__( 'Choose dark mobile logo image', 'barabi-core' ),
					'multiple'    => 'no',
				)
			);

			$logo_image_section->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_mobile_logo_light',
					'title'       => esc_html__( 'Mobile Logo - Light', 'barabi-core' ),
					'description' => esc_html__( 'Choose light mobile logo image', 'barabi-core' ),
					'multiple'    => 'no',
				)
			);

			// Hook to include additional options after section part
			do_action( 'barabi_core_action_after_mobile_logo_image_section_options_map', $page, $mobile_header_tab, $logo_image_section );

			$logo_svg_path_section = $mobile_header_tab->add_section_element(
				array(
					'title'      => esc_html__( 'SVG settings', 'barabi-core' ),
					'name'       => 'qodef_mobile_logo_svg_path_section',
					'dependency' => array(
						'show' => array(
							'qodef_mobile_logo_source' => array(
								'values'        => 'svg-path',
								'default_value' => 'image',
							),
						),
					),
				)
			);

			$logo_svg_path_section->add_field_element(
				array(
					'field_type'  => 'textarea',
					'name'        => 'qodef_mobile_logo_svg_path',
					'title'       => esc_html__( 'Logo SVG Path', 'barabi-core' ),
					'description' => esc_html__( 'Enter your logo icon SVG path here. Please remove version and id attributes from your SVG path because of HTML validation', 'barabi-core' ),
				)
			);

			$logo_svg_path_section_row = $logo_svg_path_section->add_row_element(
				array(
					'name'  => 'qodef_mobile_logo_svg_path_section_row',
					'title' => esc_html__( 'SVG Styles', 'barabi-core' ),
				)
			);

			$logo_svg_path_section_row->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_mobile_logo_svg_path_color',
					'title'      => esc_html__( 'Color', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$logo_svg_path_section_row->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_mobile_logo_svg_path_hover_color',
					'title'      => esc_html__( 'Hover Color', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$logo_svg_path_section_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_mobile_logo_svg_path_size',
					'title'      => esc_html__( 'SVG Icon Size', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			// Hook to include additional options after section part
			do_action( 'barabi_core_action_after_mobile_logo_svg_path_section_options_map', $page, $mobile_header_tab, $logo_svg_path_section );

			$logo_textual_section = $mobile_header_tab->add_section_element(
				array(
					'title'      => esc_html__( 'Textual settings', 'barabi-core' ),
					'name'       => 'qodef_mobile_logo_textual_section',
					'dependency' => array(
						'show' => array(
							'qodef_mobile_logo_source' => array(
								'values'        => 'textual',
								'default_value' => 'image',
							),
						),
					),
				)
			);

			$logo_textual_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_mobile_logo_text',
					'title'       => esc_html__( 'Logo Text', 'barabi-core' ),
					'description' => esc_html__( 'Fill your text to be as Logo image', 'barabi-core' ),
				)
			);

			$logo_textual_section_row = $logo_textual_section->add_row_element(
				array(
					'name'  => 'qodef_mobile_logo_textual_section_row',
					'title' => esc_html__( 'Typography Styles', 'barabi-core' ),
				)
			);

			$logo_textual_section_row->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_mobile_logo_text_color',
					'title'      => esc_html__( 'Color', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$logo_textual_section_row->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_mobile_logo_text_hover_color',
					'title'      => esc_html__( 'Hover Color', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$logo_textual_section_row->add_field_element(
				array(
					'field_type' => 'font',
					'name'       => 'qodef_mobile_logo_text_font_family',
					'title'      => esc_html__( 'Font Family', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$logo_textual_section_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_mobile_logo_text_font_size',
					'title'      => esc_html__( 'Font Size', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$logo_textual_section_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_mobile_logo_text_line_height',
					'title'      => esc_html__( 'Line Height', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$logo_textual_section_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_mobile_logo_text_letter_spacing',
					'title'      => esc_html__( 'Letter Spacing', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$logo_textual_section_row->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_mobile_logo_text_font_weight',
					'title'      => esc_html__( 'Font Weight', 'barabi-core' ),
					'options'    => barabi_core_get_select_type_options_pool( 'font_weight' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$logo_textual_section_row->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_mobile_logo_text_text_transform',
					'title'      => esc_html__( 'Text Transform', 'barabi-core' ),
					'options'    => barabi_core_get_select_type_options_pool( 'text_transform' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$logo_textual_section_row->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_mobile_logo_text_font_style',
					'title'      => esc_html__( 'Font Style', 'barabi-core' ),
					'options'    => barabi_core_get_select_type_options_pool( 'font_style' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$logo_textual_section_row->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_mobile_logo_text_text_decoration',
					'title'      => esc_html__( 'Text Decoration', 'barabi-core' ),
					'options'    => barabi_core_get_select_type_options_pool( 'text_decoration' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$logo_textual_section_row->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_mobile_logo_text_hover_text_decoration',
					'title'      => esc_html__( 'Hover Text Decoration', 'barabi-core' ),
					'options'    => barabi_core_get_select_type_options_pool( 'text_decoration' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			// Hook to include additional options after section part
			do_action( 'barabi_core_action_after_mobile_logo_textual_section_options_map', $page, $mobile_header_tab, $logo_textual_section );

			do_action( 'barabi_core_action_after_mobile_logo_options_map', $page );
		}
	}

	add_action( 'barabi_core_action_after_header_logo_options_map', 'barabi_core_add_mobile_logo_options', 10, 2 );
}
