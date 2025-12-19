<div class="qodef-reviews-list-info qodef-reviews-per-mark">
	<?php
	if ( isset( $with_title ) && $with_title ) { ?>
			<h3 class="qodef-reviews-title"><?php esc_html_e( 'Reviews', 'teenglow-core' ); ?></h3>
		<?php
	}
	?>
	<?php foreach ( $post_ratings as $rating ) { ?>
		<?php
		$average_rating     = teenglow_core_post_average_rating( $rating );
		$rating_count       = $rating['count'];
		$rating_count_label = 1 === $rating_count ? esc_html__( 'Rating', 'teenglow-core' ) : esc_html__( 'Ratings', 'teenglow-core' );
		$rating_marks       = $rating['marks'];
		?>
		<div class="qodef-reviews-number-holder">
			<div class="qodef-reviews-number-wrapper">
				<span class="qodef-reviews-number"><?php echo esc_html( $average_rating ); ?></span>
				<span class="qodef-stars-wrapper">
						<span class="qodef-review-rating">
							<?php echo teenglow_core_reviews_get_rating_html( '', $average_rating, 0 ); ?>
						</span>
						<span class="qodef-reviews-count">
							<?php echo esc_html__( 'Rated', 'teenglow-core' ) . ' ' . $average_rating . ' ' . esc_html__( 'out of', 'teenglow-core' ) . ' ' . $rating_count . ' ' . $rating_count_label; ?>
						</span>
					</span>
			</div>
			<div class="qodef-rating-percentage-wrapper">
				<?php
				foreach ( $rating_marks as $item => $value ) {
					$percentage = 0 === $rating_count ? 0 : round( ( $value / $rating_count ) * 100 );
					$pb_params  = array(
						'layout'              => 'line',
						'title'               => esc_attr( $item ) . esc_attr__( ' stars', 'teenglow-core' ),
						'number'              => esc_attr( $percentage ),
						'active_line_color'   => '#0000B4',
						'inactive_line_color' => '#F5F4F4',
						'active_line_width'   => 6,
						'inactive_line_width' => 6,
						'title_tag'           => 'h6',
					);

					echo TeenglowCore_Progress_Bar_Shortcode::call_shortcode( $pb_params );
				}
				?>
			</div>
		</div>
	<?php } ?>
</div>
