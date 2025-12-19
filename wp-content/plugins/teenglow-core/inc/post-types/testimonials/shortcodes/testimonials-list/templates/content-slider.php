<div <?php qode_framework_class_attribute( $holder_classes ); ?> <?php qode_framework_inline_style( $holder_styles ); ?> <?php qode_framework_inline_attr( $slider_attr, 'data-options' ); ?>>
	<?php teenglow_core_list_sc_template_part( 'post-types/testimonials/shortcodes/testimonials-list', 'post-info/static-title', '', $params ); ?>
	<div class="swiper-wrapper">
		<?php
		// Include items
		teenglow_core_template_part( 'post-types/testimonials/shortcodes/testimonials-list', 'templates/loop', '', $params );
		?>
	</div>
	<?php if ( 'yes' === $show_average_rating_info || 'no' !== $slider_pagination ) { ?>
		<div class="qodef-testimonials-bottom-holder">
			<?php teenglow_core_list_sc_template_part( 'post-types/testimonials/shortcodes/testimonials-list', 'post-info/average-rating-info', '', $params ); ?>
			<?php teenglow_core_template_part( 'content', 'templates/swiper-pag', '', $params ); ?>
		</div>
	<?php } ?>
</div>
<?php teenglow_core_template_part( 'content', 'templates/swiper-nav', '', $params ); ?>
