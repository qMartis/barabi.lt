<a itemprop="url" class="qodef-m-opener" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
	<span class="qodef-m-opener-icon"><?php echo teenglow_core_get_svg_icon( 'cart' ); ?></span>
	<span class="qodef-m-opener-count-holder">
        <span class="qodef-m-opener-count">
            <?php echo teenglow_core_get_svg_icon( 'cart-count-holder' ); ?>
            <span class="qodef-m-count"><?php echo WC()->cart->cart_contents_count; ?></span>
        </span>
    </span>
</a>
