<?php

if ( ! function_exists( 'teenglow_core_add_blog_single_post_navigation_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function teenglow_core_add_blog_single_post_navigation_options( $page ) {

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_blog_single_enable_single_post_navigation',
					'title'         => esc_html__( 'Enable Single Post Navigation', 'teenglow-core' ),
					'description'   => esc_html__( 'Enabling this option will show single post navigation section below post content on blog single', 'teenglow-core' ),
					'default_value' => 'yes',
				)
			);

			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_blog_single_post_navigation_through_same_category',
					'title'         => esc_html__( 'Set Navigation Through Current Category', 'teenglow-core' ),
					'description'   => esc_html__( 'Enabling this option will set your post navigation only through current category', 'teenglow-core' ),
					'default_value' => 'yes',
					'dependency'    => array(
						'show' => array(
							'qodef_blog_single_enable_single_post_navigation' => array(
								'values'        => 'yes',
								'default_value' => '',
							),
						),
					),
				)
			);
		}
	}

	add_action( 'teenglow_core_action_after_blog_single_options_map', 'teenglow_core_add_blog_single_post_navigation_options' );
}
