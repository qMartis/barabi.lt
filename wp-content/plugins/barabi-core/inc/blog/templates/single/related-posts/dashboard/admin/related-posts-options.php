<?php

if ( ! function_exists( 'barabi_core_add_blog_single_related_posts_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function barabi_core_add_blog_single_related_posts_options( $page ) {

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_blog_single_enable_related_posts',
					'title'         => esc_html__( 'Enable Related Posts', 'barabi-core' ),
					'description'   => esc_html__( 'Enabling this option will show related posts section below post content on blog single', 'barabi-core' ),
					'default_value' => 'no',
				)
			);
		}
	}

	add_action( 'barabi_core_action_after_blog_single_options_map', 'barabi_core_add_blog_single_related_posts_options' );
}
