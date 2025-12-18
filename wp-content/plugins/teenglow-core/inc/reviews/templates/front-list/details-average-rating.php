<?php if ( is_array( $post_ratings ) && count( $post_ratings ) ) {
	$average_rating_total = teenglow_core_get_total_average_rating( $post_ratings );
	?>
	<div class="qodef-reviews-list-info qodef-reviews-average-rating">
		<span class="qodef-reviews-rating">
			<?php echo esc_html( $average_rating_total ); ?>
			<?php teenglow_core_render_svg_icon( 'star' ); ?>
		</span>
		<span class="qodef-reviews-number">
			(
			<?php echo esc_html( $rating_number ); ?>
			<?php echo esc_html( $rating_label ); ?>
			)
		</span>
	</div>
<?php } ?>
