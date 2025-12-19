<?php

if ( ! function_exists( 'barabi_core_add_tutorial_related_posts_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function barabi_core_add_tutorial_related_posts_options( $page ) {

		if ( $page ) {

			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_tutorial_enable_related_posts',
					'title'         => esc_html__( 'Related Posts', 'barabi-core' ),
					'description'   => esc_html__( 'Enabling this option will show related posts section below post content on tutorial single', 'barabi-core' ),
					'default_value' => 'no',
				)
			);
		}
	}

	add_action( 'barabi_core_action_after_tutorial_options_single', 'barabi_core_add_tutorial_related_posts_options' );
}
