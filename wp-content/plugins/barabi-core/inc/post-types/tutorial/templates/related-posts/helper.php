<?php

if ( ! function_exists( 'barabi_core_include_tutorial_single_related_posts_template' ) ) {
	/**
	 * Function which includes additional module on single tutorial page
	 */
	function barabi_core_include_tutorial_single_related_posts_template() {
		barabi_core_template_part( 'post-types/tutorial', 'templates/related-posts/templates/related-posts' );
	}

	add_action( 'barabi_core_action_after_tutorial_single_item', 'barabi_core_include_tutorial_single_related_posts_template', 20 ); // permission 20 is set to define template position
}
