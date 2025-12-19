<?php

if ( ! function_exists( 'barabi_core_filter_clients_list_image_only_fade_in' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function barabi_core_filter_clients_list_image_only_fade_in( $variations ) {
		$variations['fade-in'] = esc_html__( 'Fade In', 'barabi-core' );

		return $variations;
	}

	add_filter( 'barabi_core_filter_clients_list_image_only_animation_options', 'barabi_core_filter_clients_list_image_only_fade_in' );
}
