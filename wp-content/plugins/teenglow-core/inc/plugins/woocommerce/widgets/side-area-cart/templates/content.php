<?php if ( is_object( WC()->cart ) ) { ?>
	<div class="qodef-widget-side-area-cart-content">
		<?php
		// Hook to include additional content before cart items
		do_action( 'teenglow_core_action_woocommerce_before_side_area_cart_content' );

		if ( ! WC()->cart->is_empty() ) {
			teenglow_core_template_part( 'plugins/woocommerce/widgets/side-area-cart', 'templates/parts/loop' );

			teenglow_core_template_part( 'plugins/woocommerce/widgets/side-area-cart', 'templates/parts/order-details' );

			teenglow_core_template_part( 'plugins/woocommerce/widgets/side-area-cart', 'templates/parts/button' );
		} else {
			// Include posts not found
			teenglow_core_template_part( 'plugins/woocommerce/widgets/side-area-cart', 'templates/parts/posts-not-found' );
		}

		teenglow_core_template_part( 'plugins/woocommerce/widgets/side-area-cart', 'templates/parts/close' );
		?>
	</div>
<?php } ?>
