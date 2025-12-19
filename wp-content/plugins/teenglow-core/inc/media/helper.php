<?php

if ( ! function_exists( 'teenglow_core_include_image_sizes' ) ) {
	/**
	 * Function that includes icons
	 */
	function teenglow_core_include_image_sizes() {
		foreach ( glob( TEENGLOW_CORE_INC_PATH . '/media/*/include.php' ) as $image_size ) {
			include_once $image_size;
		}
	}

	add_action( 'qode_framework_action_before_images_register', 'teenglow_core_include_image_sizes' );
}
