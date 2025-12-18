<?php if ( is_array( $post_ratings ) && count( $post_ratings ) ) {
	$average_rating_total = teenglow_core_get_total_average_rating( $post_ratings );
	?>
	<div class="qodef-reviews-list-info qodef-reviews-average-rating-simple">
		<span class="qodef-reviews-rating">
			<?php echo esc_html( $average_rating_total ); ?>
			<?php teenglow_core_render_svg_icon( 'star' ); ?>
		</span>
	</div>
<?php } ?>
