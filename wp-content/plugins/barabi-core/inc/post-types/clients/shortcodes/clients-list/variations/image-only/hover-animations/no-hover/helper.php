<?php

if ( ! function_exists( 'barabi_core_filter_clients_list_image_only_no_hover' ) ) {
    /**
     * Function that add variation layout for this module
     *
     * @param array $variations
     *
     * @return array
     */
    function barabi_core_filter_clients_list_image_only_no_hover( $variations ) {
        $variations['no-hover'] = esc_html__( 'No Hover', 'barabi-core' );

        return $variations;
    }

    add_filter( 'barabi_core_filter_clients_list_image_only_animation_options', 'barabi_core_filter_clients_list_image_only_no_hover' );
}