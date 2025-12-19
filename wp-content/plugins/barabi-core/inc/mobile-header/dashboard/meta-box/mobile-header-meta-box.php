<?php

if ( ! function_exists( 'barabi_core_add_page_mobile_header_meta_box' ) ) {
	/**
	 * Function that add general meta box options for this module
	 *
	 * @param object $page
	 */
	function barabi_core_add_page_mobile_header_meta_box( $page ) {

		if ( $page ) {
			$mobile_header_tab = $page->add_tab_element(
				array(
					'name'        => 'tab-mobile-header',
					'icon'        => 'fa fa-cog',
					'title'       => esc_html__( 'Mobile Header Settings', 'barabi-core' ),
					'description' => esc_html__( 'Mobile header layout settings', 'barabi-core' ),
				)
			);

			$mobile_header_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_mobile_header_layout',
					'title'       => esc_html__( 'Mobile Header Layout', 'barabi-core' ),
					'description' => esc_html__( 'Choose a mobile header layout to set for your website', 'barabi-core' ),
					'args'        => array( 'images' => true ),
					'options'     => barabi_core_header_radio_to_select_options( apply_filters( 'barabi_core_filter_mobile_header_layout_option', array() ) ),
				)
			);

			$mobile_header_tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_mobile_header_in_grid',
					'title'         => esc_html__( 'Content in Grid', 'barabi-core' ),
					'description'   => esc_html__( 'Set content to be in grid', 'barabi-core' ),
					'default_value' => '',
					'options'       => barabi_core_get_select_type_options_pool( 'no_yes' ),
				)
			);

			$mobile_header_tab->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_show_mobile_header_widget_areas',
					'title'         => esc_html__( 'Show Mobile Header Widget Areas', 'barabi-core' ),
					'description'   => esc_html__( 'Choose if you want to show or hide mobile header widget areas', 'barabi-core' ),
					'default_value' => 'yes',
				)
			);

			$opener_section = $mobile_header_tab->add_section_element(
				array(
					'name'  => 'qodef_mobile_header_opener_section',
					'title' => esc_html__( 'Mobile Header Opener Styles', 'barabi-core' ),
				)
			);

			$opener_section_row = $opener_section->add_row_element(
				array(
					'name' => 'qodef_mobile_header_opener_row',
				)
			);

			$opener_section_row->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_mobile_header_opener_color',
					'title'      => esc_html__( 'Color', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$opener_section_row->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_mobile_header_opener_hover_color',
					'title'      => esc_html__( 'Hover/Active Color', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$opener_section_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_mobile_header_opener_size',
					'title'      => esc_html__( 'Icon Size', 'barabi-core' ),
					'args'       => array(
						'col_width' => 3,
						'suffix'    => 'px',
					),
				)
			);

			// Hook to include additional options after module options
			do_action( 'barabi_core_action_after_page_mobile_header_meta_map', $mobile_header_tab );
		}
	}

	add_action( 'barabi_core_action_after_general_meta_box_map', 'barabi_core_add_page_mobile_header_meta_box' );
}

if ( ! function_exists( 'barabi_core_add_general_mobile_header_meta_box_callback' ) ) {
	/**
	 * Function that set current meta box callback as general callback functions
	 *
	 * @param array $callbacks
	 *
	 * @return array
	 */
	function barabi_core_add_general_mobile_header_meta_box_callback( $callbacks ) {
		$callbacks['mobile-header'] = 'barabi_core_add_page_mobile_header_meta_box';

		return $callbacks;
	}

	add_filter( 'barabi_core_filter_general_meta_box_callbacks', 'barabi_core_add_general_mobile_header_meta_box_callback' );
}
