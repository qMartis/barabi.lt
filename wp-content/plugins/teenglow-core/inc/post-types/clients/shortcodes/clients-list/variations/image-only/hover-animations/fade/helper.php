<?php

if ( ! function_exists( 'teenglow_core_filter_clients_list_image_only_fade' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function teenglow_core_filter_clients_list_image_only_fade( $variations ) {
		$variations['fade'] = esc_html__( 'Fade', 'teenglow-core' );

		return $variations;
	}

	add_filter( 'teenglow_core_filter_clients_list_image_only_animation_options', 'teenglow_core_filter_clients_list_image_only_fade' );
}
