<?php

if ( ! function_exists( 'teenglow_core_include_tutorial_single_related_posts_template' ) ) {
	/**
	 * Function which includes additional module on single tutorial page
	 */
	function teenglow_core_include_tutorial_single_related_posts_template() {
		teenglow_core_template_part( 'post-types/tutorial', 'templates/related-posts/templates/related-posts' );
	}

	add_action( 'teenglow_core_action_after_tutorial_single_item', 'teenglow_core_include_tutorial_single_related_posts_template', 20 ); // permission 20 is set to define template position
}
