<div <?php qode_framework_class_attribute( $holder_classes ); ?> <?php qode_framework_inline_style( $holder_styles ); ?> <?php qode_framework_inline_attr( $slider_attr, 'data-options' ); ?>>
    <div class="qodef-m-content-wrapper" <?php qode_framework_inline_style( $static_content_styles ); ?>>
        <div class="qodef-m-content">
            <?php barabi_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/parts/static-title', '', $params ); ?>
        </div>
        <div class="qodef-m-navigation">
            <?php barabi_core_template_part( 'content', 'templates/swiper-nav', '', $params ); ?>
        </div>
    </div>
    <ul class="swiper-wrapper">
		<?php
		// Include items
		barabi_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/loop', '', $params );
		?>
	</ul>
	<?php barabi_core_template_part( 'content', 'templates/swiper-pag', '', $params ); ?>
</div>
