<?php

if ( ! function_exists( 'teenglow_core_add_subscribe_popup_meta_box' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function teenglow_core_add_subscribe_popup_meta_box( $general_tab ) {

		if ( $general_tab ) {
			$general_tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_enable_subscribe_popup',
					'title'         => esc_html__( 'Enable Subscribe Popup', 'teenglow-core' ),
					'description'   => esc_html__( 'Use this option to enable/disable subscribe popup', 'teenglow-core' ),
					'options'       => teenglow_core_get_select_type_options_pool( 'yes_no' ),
					'default_value' => '',
				)
			);
		}
	}

	add_action( 'teenglow_core_action_after_general_page_meta_box_map', 'teenglow_core_add_subscribe_popup_meta_box', 9 );
}
