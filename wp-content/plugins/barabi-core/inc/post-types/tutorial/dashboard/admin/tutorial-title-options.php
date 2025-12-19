<?php

if ( ! function_exists( 'barabi_core_add_tutorial_title_options' ) ) {
	/**
	 * Function that add title options for tutorial module
	 */
	function barabi_core_add_tutorial_title_options( $tab ) {

		if ( $tab ) {
			$tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_enable_tutorial_title',
					'title'       => esc_html__( 'Enable Title on Tutorial Single', 'barabi-core' ),
					'description' => esc_html__( 'Use this option to enable/disable tutorial single title', 'barabi-core' ),
					'options'     => barabi_core_get_select_type_options_pool( 'yes_no' ),
				)
			);

			$tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_set_tutorial_title_area_in_grid',
					'title'       => esc_html__( 'Tutorial Title in Grid', 'barabi-core' ),
					'description' => esc_html__( 'Enabling this option will set tutorial title area to be in grid', 'barabi-core' ),
					'options'     => barabi_core_get_select_type_options_pool( 'yes_no' ),
				)
			);
		}
	}

	add_action( 'barabi_core_action_after_tutorial_options_single', 'barabi_core_add_tutorial_title_options' );
}
