<?php $params['button_params']['button_type'] = 'filled-with-price'; ?>
<li <?php wc_product_class( $item_classes ); ?>>
	<div class="qodef-e-inner">
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="qodef-e-media">
				<?php teenglow_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/image', '', $params ); ?>
				<?php teenglow_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/link' ); ?>
			</div>
		<?php } ?>
		<div class="qodef-e-content">
			<?php teenglow_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/rating', '', $params ); ?>
			<?php teenglow_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/title', '', $params ); ?>
			<?php teenglow_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/excerpt', '', $params ); ?>
            <?php teenglow_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/add-to-cart', '', $params ); ?>
			<?php
			// Hook to include additional content inside product list item content
			do_action( 'teenglow_core_action_product_list_item_additional_content' );
			?>
		</div>
	</div>
</li>
