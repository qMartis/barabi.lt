<?php

$product = barabi_core_woo_get_global_product();

if ( ! empty( $product ) && 'no' !== get_option( 'woocommerce_enable_review_rating' ) ) {
	$rating       = $product->get_average_rating();
    $review_count = $product->get_review_count();

	if ( ! empty( $rating ) ) { ?>
        <div class="qodef-woo-ratings-holder">
            <?php
            echo barabi_core_woo_product_get_rating_html( '', $rating, 0 );

            if ( 1 !== intval( $review_count ) ) {
                echo '<span class="qodef-rating-count">' . esc_html( intval($review_count) ) . esc_html__( ' Reviews', 'barabi-core' ) . '</span>';
            } else {
                echo '<span class="qodef-rating-count">' . esc_html( intval($review_count) ) . esc_html__( ' Review', 'barabi-core' ) . '</span>';
            }
            ?>
        </div>
    <?php
    }
}
