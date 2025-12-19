<div <?php qode_framework_class_attribute( $holder_classes ); ?> <?php qode_framework_inline_style( $holder_styles ); ?>>
	<?php barabi_core_list_sc_template_part( 'post-types/testimonials/shortcodes/testimonials-list', 'post-info/static-title', '', $params ); ?>
	<div class="qodef-grid-inner">
		<?php
		// Include global masonry template from theme
		barabi_core_theme_template_part( 'masonry', 'templates/sizer-gutter', '', $params['behavior'] );

		// Include items
		barabi_core_template_part( 'post-types/testimonials/shortcodes/testimonials-list', 'templates/loop', '', $params );
		?>
	</div>
	<?php if ( 'yes' === $show_average_rating_info ) { ?>
		<div class="qodef-testimonials-bottom-holder">
			<?php barabi_core_list_sc_template_part( 'post-types/testimonials/shortcodes/testimonials-list', 'post-info/average-rating-info', '', $params ); ?>
		</div>
	<?php } ?>
</div>
