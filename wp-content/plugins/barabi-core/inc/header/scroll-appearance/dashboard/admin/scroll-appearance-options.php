<?php

if ( ! function_exists( 'barabi_core_add_scroll_appearance_header_options' ) ) {
	/**
	 * Function that add general options for this module
	 *
	 * @param object $page
	 */
	function barabi_core_add_scroll_appearance_header_options( $page ) {

		if ( $page ) {
			$scroll_appearance_tab = $page->add_tab_element(
				array(
					'name'  => 'tab-header-scroll-appearance',
					'icon'  => 'fa fa-cog',
					'title' => esc_html__( 'Scroll Appearance Settings', 'barabi-core' ),
				)
			);

			$section = $scroll_appearance_tab->add_section_element(
				array(
					'name'       => 'qodef_header_scroll_appearance_section',
					'title'      => esc_html__( 'Scroll Appearance Section', 'barabi-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_header_layout' => array(
								'values'        => barabi_core_dependency_for_scroll_appearance_options(),
								'default_value' => apply_filters( 'barabi_core_filter_header_layout_default_option_value', '' ),
							),
						),
					),
				)
			);

			$section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_header_scroll_appearance',
					'title'         => esc_html__( 'Header Scroll Appearance', 'barabi-core' ),
					'description'   => esc_html__( 'Choose how header will act on scroll', 'barabi-core' ),
					'options'       => apply_filters( 'barabi_core_filter_header_scroll_appearance_option', array( 'none' => esc_html__( 'None', 'barabi-core' ) ) ),
					'default_value' => 'none',
				)
			);

			// Hook to include additional options after module options
			do_action( 'barabi_core_action_after_header_scroll_appearance_options_map', $page, $section );
		}
	}

	add_action( 'barabi_core_action_after_header_options_map', 'barabi_core_add_scroll_appearance_header_options', 15 );
}
