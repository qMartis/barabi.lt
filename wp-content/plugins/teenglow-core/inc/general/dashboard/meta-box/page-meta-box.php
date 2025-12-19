<?php

if ( ! function_exists( 'teenglow_core_add_general_page_meta_box' ) ) {
	/**
	 * Function that add general meta box options for this module
	 *
	 * @param object $page
	 */
	function teenglow_core_add_general_page_meta_box( $page ) {

		$general_tab = $page->add_tab_element(
			array(
				'name'        => 'tab-page',
				'icon'        => 'fa fa-cog',
				'title'       => esc_html__( 'Page Settings', 'teenglow-core' ),
				'description' => esc_html__( 'General page layout settings', 'teenglow-core' ),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_page_background_color',
				'title'       => esc_html__( 'Page Background Color', 'teenglow-core' ),
				'description' => esc_html__( 'Set background color', 'teenglow-core' ),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'  => 'image',
				'name'        => 'qodef_page_background_image',
				'title'       => esc_html__( 'Page Background Image', 'teenglow-core' ),
				'description' => esc_html__( 'Set background image', 'teenglow-core' ),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_page_background_repeat',
				'title'       => esc_html__( 'Page Background Image Repeat', 'teenglow-core' ),
				'description' => esc_html__( 'Set background image repeat', 'teenglow-core' ),
				'options'     => array(
					''          => esc_html__( 'Default', 'teenglow-core' ),
					'no-repeat' => esc_html__( 'No Repeat', 'teenglow-core' ),
					'repeat'    => esc_html__( 'Repeat', 'teenglow-core' ),
					'repeat-x'  => esc_html__( 'Repeat-x', 'teenglow-core' ),
					'repeat-y'  => esc_html__( 'Repeat-y', 'teenglow-core' ),
				),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_page_background_size',
				'title'       => esc_html__( 'Page Background Image Size', 'teenglow-core' ),
				'description' => esc_html__( 'Set background image size', 'teenglow-core' ),
				'options'     => array(
					''        => esc_html__( 'Default', 'teenglow-core' ),
					'contain' => esc_html__( 'Contain', 'teenglow-core' ),
					'cover'   => esc_html__( 'Cover', 'teenglow-core' ),
				),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_page_background_attachment',
				'title'       => esc_html__( 'Page Background Image Attachment', 'teenglow-core' ),
				'description' => esc_html__( 'Set background image attachment', 'teenglow-core' ),
				'options'     => array(
					''       => esc_html__( 'Default', 'teenglow-core' ),
					'fixed'  => esc_html__( 'Fixed', 'teenglow-core' ),
					'scroll' => esc_html__( 'Scroll', 'teenglow-core' ),
				),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_page_content_padding',
				'title'       => esc_html__( 'Page Content Padding', 'teenglow-core' ),
				'description' => esc_html__( 'Set padding that will be applied for page content in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'teenglow-core' ),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_page_content_margin',
				'title'       => esc_html__( 'Page Content Margin', 'teenglow-core' ),
				'description' => esc_html__( 'Set margin that will be applied for page content in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'teenglow-core' ),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_page_content_padding_mobile',
				'title'       => esc_html__( 'Page Content Padding Mobile', 'teenglow-core' ),
				'description' => esc_html__( 'Set padding that will be applied for page content on mobile screens (1024px and below) in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'teenglow-core' ),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_page_content_margin_mobile',
				'title'       => esc_html__( 'Page Content Margin Mobile', 'teenglow-core' ),
				'description' => esc_html__( 'Set margin that will be applied for page content on mobile screens (1024px and below) in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'teenglow-core' ),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'    => 'select',
				'name'          => 'qodef_boxed',
				'title'         => esc_html__( 'Boxed Layout', 'teenglow-core' ),
				'description'   => esc_html__( 'Set boxed layout', 'teenglow-core' ),
				'default_value' => '',
				'options'       => teenglow_core_get_select_type_options_pool( 'yes_no' ),
			)
		);

		$boxed_section = $general_tab->add_section_element(
			array(
				'name'       => 'qodef_boxed_section',
				'title'      => esc_html__( 'Boxed Layout Section', 'teenglow-core' ),
				'dependency' => array(
					'hide' => array(
						'qodef_boxed' => array(
							'values'        => 'no',
							'default_value' => '',
						),
					),
				),
			)
		);

		$boxed_section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_boxed_background_color',
				'title'       => esc_html__( 'Boxed Background Color', 'teenglow-core' ),
				'description' => esc_html__( 'Set boxed background color', 'teenglow-core' ),
			)
		);

		$boxed_section->add_field_element(
			array(
				'field_type'  => 'image',
				'name'        => 'qodef_boxed_background_pattern',
				'title'       => esc_html__( 'Boxed Background Pattern', 'teenglow-core' ),
				'description' => esc_html__( 'Set boxed background pattern', 'teenglow-core' ),
			)
		);

		$boxed_section->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_boxed_background_pattern_behavior',
				'title'       => esc_html__( 'Boxed Background Pattern Behavior', 'teenglow-core' ),
				'description' => esc_html__( 'Set boxed background pattern behavior', 'teenglow-core' ),
				'options'     => array(
					''       => esc_html__( 'Default', 'teenglow-core' ),
					'fixed'  => esc_html__( 'Fixed', 'teenglow-core' ),
					'scroll' => esc_html__( 'Scroll', 'teenglow-core' ),
				),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'    => 'select',
				'name'          => 'qodef_passepartout',
				'title'         => esc_html__( 'Passepartout', 'teenglow-core' ),
				'description'   => esc_html__( 'Enabling this option will display a passepartout around website content', 'teenglow-core' ),
				'default_value' => '',
				'options'       => teenglow_core_get_select_type_options_pool( 'yes_no' ),
			)
		);

		$passepartout_section = $general_tab->add_section_element(
			array(
				'name'       => 'qodef_passepartout_section',
				'dependency' => array(
					'hide' => array(
						'qodef_passepartout' => array(
							'values'        => 'no',
							'default_value' => '',
						),
					),
				),
			)
		);

		$passepartout_section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_passepartout_color',
				'title'       => esc_html__( 'Passepartout Color', 'teenglow-core' ),
				'description' => esc_html__( 'Choose background color for passepartout', 'teenglow-core' ),
			)
		);

		$passepartout_section->add_field_element(
			array(
				'field_type'  => 'image',
				'name'        => 'qodef_passepartout_image',
				'title'       => esc_html__( 'Passepartout Background Image', 'teenglow-core' ),
				'description' => esc_html__( 'Set background image for passepartout', 'teenglow-core' ),
			)
		);

		$passepartout_section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_passepartout_size',
				'title'       => esc_html__( 'Passepartout Size', 'teenglow-core' ),
				'description' => esc_html__( 'Enter size amount for passepartout', 'teenglow-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px or %', 'teenglow-core' ),
				),
			)
		);

		$passepartout_section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_passepartout_size_responsive',
				'title'       => esc_html__( 'Passepartout Responsive Size', 'teenglow-core' ),
				'description' => esc_html__( 'Enter size amount for passepartout for smaller screens (1024px and below)', 'teenglow-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px or %', 'teenglow-core' ),
				),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_content_width',
				'title'       => esc_html__( 'Initial Width of Content', 'teenglow-core' ),
				'description' => esc_html__( 'Choose the initial width of content which is in grid (applies to pages set to "Default Template" and rows set to "In Grid")', 'teenglow-core' ),
				'options'     => teenglow_core_get_select_type_options_pool( 'content_width' ),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'    => 'yesno',
				'default_value' => 'no',
				'name'          => 'qodef_content_behind_header',
				'title'         => esc_html__( 'Always put content behind header', 'teenglow-core' ),
				'description'   => esc_html__( 'Enabling this option will put page content behind page header', 'teenglow-core' ),
			)
		);

		// Hook to include additional options after module options
		do_action( 'teenglow_core_action_after_general_page_meta_box_map', $general_tab );
	}

	add_action( 'teenglow_core_action_after_general_meta_box_map', 'teenglow_core_add_general_page_meta_box', 9 );
}

if ( ! function_exists( 'teenglow_core_add_general_page_meta_box_callback' ) ) {
	/**
	 * Function that set current meta box callback as general callback functions
	 *
	 * @param array $callbacks
	 *
	 * @return array
	 */
	function teenglow_core_add_general_page_meta_box_callback( $callbacks ) {
		$callbacks['page'] = 'teenglow_core_add_general_page_meta_box';

		return $callbacks;
	}

	add_filter( 'teenglow_core_filter_general_meta_box_callbacks', 'teenglow_core_add_general_page_meta_box_callback' );
}
