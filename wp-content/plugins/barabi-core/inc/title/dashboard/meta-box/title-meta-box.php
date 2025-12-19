<?php

if ( ! function_exists( 'barabi_core_add_page_title_meta_box' ) ) {
	/**
	 * Function that add general meta box options for this module
	 *
	 * @param object $page
	 */
	function barabi_core_add_page_title_meta_box( $page ) {

		if ( $page ) {

			$title_tab = $page->add_tab_element(
				array(
					'name'        => 'tab-title',
					'icon'        => 'fa fa-cog',
					'title'       => esc_html__( 'Title Settings', 'barabi-core' ),
					'description' => esc_html__( 'Title layout settings', 'barabi-core' ),
				)
			);

			$title_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_enable_page_title',
					'title'       => esc_html__( 'Enable Page Title', 'barabi-core' ),
					'description' => esc_html__( 'Use this option to enable/disable page title', 'barabi-core' ),
					'options'     => barabi_core_get_select_type_options_pool( 'no_yes' ),
				)
			);

			$page_title_section = $title_tab->add_section_element(
				array(
					'name'       => 'qodef_page_title_section',
					'title'      => esc_html__( 'Title Area', 'barabi-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_enable_page_title' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_title_layout',
					'title'       => esc_html__( 'Title Layout', 'barabi-core' ),
					'description' => esc_html__( 'Choose a title layout', 'barabi-core' ),
					'options'     => apply_filters( 'barabi_core_filter_title_layout_options', array( '' => esc_html__( 'Default', 'barabi-core' ) ) ),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_page_title_predefined_layout',
					'title'         => esc_html__( 'Page Title Predefined Layout', 'barabi-core' ),
					'options'       => barabi_core_get_select_type_options_pool( 'yes_no' ),
					'default_value' => '',
					'dependency'    => array(
						'show' => array(
							'qodef_title_layout' => array(
								'values' => 'standard',
								'default_value' => ''
							)
						)
					)
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_set_page_title_area_in_grid',
					'title'       => esc_html__( 'Page Title In Grid', 'barabi-core' ),
					'description' => esc_html__( 'Enabling this option will set page title area to be in grid', 'barabi-core' ),
					'options'     => barabi_core_get_select_type_options_pool( 'no_yes' ),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'    => 'text',
					'name'          => 'qodef_page_title_side_padding',
					'title'         => esc_html__( 'Page Title Side Padding', 'barabi-core' ),
					'args'        => array(
						'suffix' => esc_html__( 'px or %', 'barabi-core' ),
					),
					'dependency'    => array(
						'show' => array (
							'qodef_set_page_title_area_in_grid' => array(
								'values' => 'no',
								'default_value' => ''
							)
						)
					)
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_title_height',
					'title'       => esc_html__( 'Height', 'barabi-core' ),
					'description' => esc_html__( 'Enter title height', 'barabi-core' ),
					'args'        => array(
						'suffix' => esc_html__( 'px', 'barabi-core' ),
					),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_title_height_on_smaller_screens',
					'title'       => esc_html__( 'Height on Smaller Screens', 'barabi-core' ),
					'description' => esc_html__( 'Enter title height to be displayed on smaller screens with active mobile header', 'barabi-core' ),
					'args'        => array(
						'suffix' => esc_html__( 'px', 'barabi-core' ),
					),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_title_additional_bottom_offset',
					'title'       => esc_html__( 'Page Title Additional Bottom Offset', 'barabi-core' ),
					'description' => esc_html__( 'Enter additional offset for title, that will be applied from bottom', 'barabi-core' ),
					'args'        => array(
						'suffix' => esc_html__( 'px', 'barabi-core' ),
					),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_page_title_background_color',
					'title'       => esc_html__( 'Background Color', 'barabi-core' ),
					'description' => esc_html__( 'Enter page title area background color', 'barabi-core' ),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_page_title_background_image',
					'title'       => esc_html__( 'Background Image', 'barabi-core' ),
					'description' => esc_html__( 'Enter page title area background image', 'barabi-core' ),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_page_title_background_image_behavior',
					'title'      => esc_html__( 'Background Image Behavior', 'barabi-core' ),
					'options'    => array(
						''           => esc_html__( 'Default', 'barabi-core' ),
						'responsive' => esc_html__( 'Set Responsive Image', 'barabi-core' ),
						'parallax'   => esc_html__( 'Set Parallax Image', 'barabi-core' ),
					),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_page_title_color',
					'title'      => esc_html__( 'Title Color', 'barabi-core' ),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_page_title_tag',
					'title'         => esc_html__( 'Title Tag', 'barabi-core' ),
					'description'   => esc_html__( 'Enabling this option will set title tag', 'barabi-core' ),
					'options'       => barabi_core_get_select_type_options_pool( 'title_tag' ),
					'default_value' => '',
					'dependency'    => array(
						'show' => array(
							'qodef_title_layout' => array(
								'values'        => array( 'standard-with-breadcrumbs', 'standard' ),
								'default_value' => '',
							),
						),
					),
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_page_title_text_alignment',
					'title'         => esc_html__( 'Text Alignment', 'barabi-core' ),
					'options'       => array(
						''       => esc_html__( 'Default', 'barabi-core' ),
						'left'   => esc_html__( 'Left', 'barabi-core' ),
						'center' => esc_html__( 'Center', 'barabi-core' ),
						'right'  => esc_html__( 'Right', 'barabi-core' ),
					),
					'default_value' => '',
				)
			);

			$page_title_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_page_title_vertical_text_alignment',
					'title'         => esc_html__( 'Vertical Text Alignment', 'barabi-core' ),
					'options'       => array(
						''              => esc_html__( 'Default', 'barabi-core' ),
						'header-bottom' => esc_html__( 'From Bottom of Header', 'barabi-core' ),
						'window-top'    => esc_html__( 'From Window Top', 'barabi-core' ),
					),
					'default_value' => '',
				)
			);

			// Hook to include additional options after module options
			do_action( 'barabi_core_action_after_page_title_meta_box_map', $page_title_section );
		}
	}

	add_action( 'barabi_core_action_after_general_meta_box_map', 'barabi_core_add_page_title_meta_box' );
}

if ( ! function_exists( 'barabi_core_add_general_page_title_meta_box_callback' ) ) {
	/**
	 * Function that set current meta box callback as general callback functions
	 *
	 * @param array $callbacks
	 *
	 * @return array
	 */
	function barabi_core_add_general_page_title_meta_box_callback( $callbacks ) {
		$callbacks['page-title'] = 'barabi_core_add_page_title_meta_box';

		return $callbacks;
	}

	add_filter( 'barabi_core_filter_general_meta_box_callbacks', 'barabi_core_add_general_page_title_meta_box_callback' );
}
