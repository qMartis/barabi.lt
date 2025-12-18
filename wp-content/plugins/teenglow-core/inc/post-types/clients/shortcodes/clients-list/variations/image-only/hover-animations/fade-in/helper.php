<?php

if ( ! function_exists( 'teenglow_core_filter_clients_list_image_only_fade_in' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_filter_clients_list_image_only_fade_in( $variations ) {
		$variations['fade-in'] = esc_html__( 'Fade In', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_clients_list_image_only_animation_options', 'teenglow_core_filter_clients_list_image_only_fade_in' );
}
