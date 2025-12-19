<?php

if ( ! function_exists( 'teenglow_core_add_tutorial_title_options' ) ) {
	/**
	 * Function that add title options for tutorial module
	 */
	function teenglow_core_add_tutorial_title_options( $tab ) {

		if ( $tab ) {
			$tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_enable_tutorial_title',
					'title'       => esc_html__( 'Enable Title on Tutorial Single', 'teenglow-core' ),
					'description' => esc_html__( 'Use this option to enable/disable tutorial single title', 'teenglow-core' ),
					'options'     => teenglow_core_get_select_type_options_pool( 'yes_no' ),
				)
			);

			$tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_set_tutorial_title_area_in_grid',
					'title'       => esc_html__( 'Tutorial Title in Grid', 'teenglow-core' ),
					'description' => esc_html__( 'Enabling this option will set tutorial title area to be in grid', 'teenglow-core' ),
					'options'     => teenglow_core_get_select_type_options_pool( 'yes_no' ),
				)
			);
		}
	}

	add_action( 'teenglow_core_action_after_tutorial_options_single', 'teenglow_core_add_tutorial_title_options' );
}
