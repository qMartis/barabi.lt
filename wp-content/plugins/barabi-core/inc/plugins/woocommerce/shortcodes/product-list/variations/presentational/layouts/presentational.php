<?php $params['button_params']['button_type'] = 'filled-with-price'; ?>
<li <?php wc_product_class( $item_classes ); ?>>
    <div class="qodef-e-inner">
        <?php if ( has_post_thumbnail() ) { ?>
            <div class="qodef-e-media">
                <?php barabi_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/image', '', $params ); ?>
                <div class="qodef-e-media-inner">
                    <?php barabi_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/add-to-cart', '', $params ); ?>
                </div>
                <?php barabi_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/link' ); ?>
            </div>
        <?php } ?>
        <div class="qodef-e-content">
            <?php barabi_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/title', '', $params ); ?>
            <?php barabi_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/rating-advanced', '', $params ); ?>
            <?php barabi_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/excerpt', '', $params ); ?>
            <div class="qodef-e-product-buttons-holder">
                <?php
                // Hook to include additional content
                do_action( 'barabi_core_action_product_list_item_additional_hover_content' );
                ?>
            </div>
            <?php
            // Hook to include additional content inside product list item content
            do_action( 'barabi_core_action_product_list_item_additional_content' );
            ?>
        </div>
    </div>
</li>
