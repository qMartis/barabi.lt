<div <?php qode_framework_class_attribute( $holder_classes ); ?> <?php qode_framework_inline_style( $holder_styles ); ?> <?php qode_framework_inline_attr( $slider_attr, 'data-options' ); ?>>
	<?php if ( ! empty( $static_title ) ) { ?>
		<h2 class="qodef-blog-static-title">
			<?php echo esc_html( $static_title ); ?>
		</h2>
	<?php } ?>
	<div class="swiper-wrapper">
		<?php
		// Include items
		teenglow_core_template_part( 'blog/shortcodes/blog-list', 'templates/loop', '', $params );
		?>
	</div>
	<div class="qodef-blog-slider-navigation-holder">
		<div class="qodef-blog-slider-navigation-holder-inner">
			<?php teenglow_core_template_part( 'content', 'templates/swiper-nav', '', $params ); ?>
		</div>
	</div>
	<?php teenglow_core_template_part( 'content', 'templates/swiper-pag', '', $params ); ?>
</div>
