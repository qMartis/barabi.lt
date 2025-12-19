<?php

if ( ! function_exists( 'teenglow_core_woo_single_product_gallery_full_width_set_full_width_class' ) ) {

	function teenglow_core_woo_single_product_gallery_full_width_set_full_width_class( $classes ) {

        $woo_single_layout = teenglow_core_generate_woo_product_single_layout();

        if ( 'gallery' === $woo_single_layout ) {
            $classes = 'qodef-content-full-width';
        }

		return $classes;
	}

    add_action( 'teenglow_filter_page_inner_classes', 'teenglow_core_woo_single_product_gallery_full_width_set_full_width_class' );
}
