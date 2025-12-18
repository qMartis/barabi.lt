<?php

if ( ! function_exists( 'teenglow_core_nav_menu_meta_options' ) ) {
	/**
	 * Function that add general options for this module
	 *
	 * @param object $page
	 */
	function teenglow_core_nav_menu_meta_options( $page ) {

		if ( $page ) {

			$section = $page->add_section_element(
				array(
					'name'  => 'qodef_nav_menu_section',
					'title' => esc_html__( 'Main Menu', 'teenglow-core' ),
				)
			);

			$section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_dropdown_top_position',
					'title'       => esc_html__( 'Dropdown Position', 'teenglow-core' ),
					'description' => esc_html__( 'Enter value in percentage of entire header height', 'teenglow-core' ),
				)
			);
		}
	}

	add_action( 'teenglow_core_action_after_page_header_meta_map', 'teenglow_core_nav_menu_meta_options' );
}
