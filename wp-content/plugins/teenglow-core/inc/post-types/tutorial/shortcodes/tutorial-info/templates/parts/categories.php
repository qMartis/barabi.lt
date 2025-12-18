<?php
$categories = wp_get_post_terms( $project_id, 'tutorial-category' );

if ( ! empty( $categories ) ) { ?>
	<div class="qodef-e-categories">
		<?php echo get_the_term_list( $project_id, 'tutorial-category', '', '<span class="qodef-info-separator-single"></span>' ); ?>
	</div>
<?php } ?>
