<div <?php qode_framework_class_attribute( $holder_classes ); ?> <?php qode_framework_inline_attr( $slider_attr, 'data-options' ); ?>>
	<div class="qodef-m-content-wrapper">
		<div class="qodef-m-content">
			<?php barabi_core_template_part( 'shortcodes/simple-slider', 'templates/parts/static-title', '', $params ); ?>
		</div>
		<div class="qodef-m-navigation">
			<?php barabi_core_template_part( 'content', 'templates/swiper-nav', '', $params ); ?>
		</div>
	</div>
	<div class="swiper-wrapper">
		<?php
		// Include items
		if ( ! empty( $items ) ) {
			foreach ( $items as $item ) {
				barabi_core_template_part( 'shortcodes/simple-slider', 'templates/parts/item', '', array_merge( $params, $item ) );
			}
		}
		?>
	</div>
</div>
