<?php

if ( ! function_exists( 'barabi_core_add_clients_list_variation_image_only' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function barabi_core_add_clients_list_variation_image_only( $variations ) {
		$variations['image-only'] = esc_html__( 'Image Only', 'barabi-core' );

		return $variations;
	}

	add_filter( 'barabi_core_filter_clients_list_layouts', 'barabi_core_add_clients_list_variation_image_only' );
}
