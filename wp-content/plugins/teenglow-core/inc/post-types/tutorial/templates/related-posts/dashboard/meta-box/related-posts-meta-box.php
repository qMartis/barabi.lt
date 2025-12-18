<?php

if ( ! function_exists( 'teenglow_core_add_tutorial_related_posts_meta_box' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function teenglow_core_add_tutorial_related_posts_meta_box( $page, $general_tab ) {

		if ( $page && $general_tab ) {
			
			$general_tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_tutorial_enable_related_posts',
					'title'         => esc_html__( 'Related Posts', 'teenglow-core' ),
					'description'   => esc_html__( 'Enabling this option will show related posts section below post content on tutorial single', 'teenglow-core' ),
					'default_value' => '',
					'options'       => teenglow_core_get_select_type_options_pool( 'yes_no' ),
				)
			);
		}
	}

	add_action( 'teenglow_core_action_after_tutorial_meta_box_map', 'teenglow_core_add_tutorial_related_posts_meta_box', 10, 3 );
}
