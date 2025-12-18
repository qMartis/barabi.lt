<?php
$rating_info    = apply_filters( 'teenglow_core_filter_testimonials_average_rating', array(0,0) );
$average_rating = $rating_info[0];
$posts_count    = $rating_info[1];
?>
<?php if ( 'yes' === $show_average_rating_info ) { ?>
	<div class="qodef-m-average-rating-holder">
		<p class="qodef-m-average-info"><?php echo sprintf( esc_html__( 'Rated %s based on %s reviews.', 'teenglow-core' ), $average_rating,  $posts_count ); ?></p>
		<p class="qodef-m-average-info"><?php echo sprintf( esc_html__( 'Showing our %s best reviews.', 'teenglow-core' ), $posts_per_page ); ?></p>
	</div>
<?php } ?>
