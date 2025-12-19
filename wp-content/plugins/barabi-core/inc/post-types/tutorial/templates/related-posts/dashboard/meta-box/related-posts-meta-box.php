<?php

if ( ! function_exists( 'barabi_core_add_tutorial_related_posts_meta_box' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function barabi_core_add_tutorial_related_posts_meta_box( $page, $general_tab ) {

		if ( $page && $general_tab ) {
			
			$general_tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_tutorial_enable_related_posts',
					'title'         => esc_html__( 'Related Posts', 'barabi-core' ),
					'description'   => esc_html__( 'Enabling this option will show related posts section below post content on tutorial single', 'barabi-core' ),
					'default_value' => '',
					'options'       => barabi_core_get_select_type_options_pool( 'yes_no' ),
				)
			);
		}
	}

	add_action( 'barabi_core_action_after_tutorial_meta_box_map', 'barabi_core_add_tutorial_related_posts_meta_box', 10, 3 );
}
