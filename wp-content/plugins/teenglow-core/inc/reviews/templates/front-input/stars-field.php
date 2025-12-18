<span class="qodef-rating-inner">
	<?php
		$label = ! empty( $label ) ? $label : esc_html__( 'Your rating', 'teenglow-core' );
	?>
	<label><?php echo esc_html( $label ); ?></label>
	<span class="qodef-comment-rating-box">
		<?php for ( $i = 1; $i <= TEENGLOW_CORE_REVIEWS_MAX_RATING; $i ++ ) { ?>
			<span class="qodef-star-rating" data-value="<?php echo esc_attr( $i ); ?>"><?php teenglow_core_render_svg_icon( 'star' ); ?></span>
		<?php } ?>
		<input type="hidden" name="<?php echo esc_attr( $key ); ?>" class="qodef-rating" value="3">
	</span>
</span>
