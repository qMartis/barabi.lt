<li <?php wc_product_class( $item_classes ); ?>>
	<div class="qodef-e-inner">
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="qodef-e-media">
				<?php barabi_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/image', '', $params ); ?>
				<?php barabi_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/link' ); ?>
			</div>
		<?php } ?>
		<div class="qodef-e-content">
			<?php barabi_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/rating', '', $params ); ?>
			<?php barabi_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/title', '', $params ); ?>
            <div class="qodef-e-price-holder">
                <?php barabi_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/price', '', $params ); ?>
                <?php barabi_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/add-to-cart', '', $params ); ?>
            </div>
			<?php
			// Hook to include additional content inside product list item content
			do_action( 'barabi_core_action_product_list_item_additional_content' );
			?>
		</div>
	</div>
</li>
