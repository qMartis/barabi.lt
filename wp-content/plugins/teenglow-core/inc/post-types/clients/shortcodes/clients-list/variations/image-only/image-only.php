<?php

if ( ! function_exists( 'teenglow_core_add_clients_list_variation_image_only' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_add_clients_list_variation_image_only( $variations ) {
		$variations['image-only'] = esc_html__( 'Image Only', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_clients_list_layouts', 'teenglow_core_add_clients_list_variation_image_only' );
}
