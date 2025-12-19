<?php

if ( have_posts() ) {
	while ( have_posts() ) :
		the_post();

		// Hook to include additional content before post item
		do_action( 'barabi_core_action_before_tutorial_item' );

		$item_layout = apply_filters( 'barabi_core_filter_tutorial_single_layout', '' );

		// Include post item
		barabi_core_template_part( 'post-types/tutorial', 'templates/layouts/' . $item_layout );

		// Hook to include additional content after post item
		do_action( 'barabi_core_action_after_tutorial_item' );

	endwhile; // End of the loop.
} else {
	// Include global posts not found
	barabi_core_theme_template_part( 'content', 'templates/parts/posts-not-found' );
}

wp_reset_postdata();
