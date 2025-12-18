<?php
$rating = get_post_meta( get_the_ID(), 'qodef_testimonials_rating', true );
?>
<div class="qodef-e-rating-holder">
	<div class="qodef-e-stars">
		<? for ( $i = 0; $i < $rating; $i++) { ?>
			<div class="qodef-e-rating-star">
				<?php teenglow_core_render_svg_icon( 'star-testimonials' ); ?>
			</div>
		<? } ?>
	</div>
	<?php teenglow_core_render_svg_icon( 'check-mark' ); ?>
	<div class="qodef-e-stars-label"><? echo esc_html__( 'Verified', 'teenglow-core' ); ?></div>
</div>