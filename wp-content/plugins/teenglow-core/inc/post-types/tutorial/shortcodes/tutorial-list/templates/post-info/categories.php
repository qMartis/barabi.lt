<?php
$categories = wp_get_post_terms( get_the_ID(), 'tutorial-category' );

if ( ! empty( $categories ) ) { ?>
	<div class="qodef-e-categories">
		<?php echo get_the_term_list( get_the_ID(), 'tutorial-category', '', '<span class="qodef-info-separator-single"></span>' ); ?>
		<div class="qodef-info-separator-end"></div>
	</div>
<?php } ?>
