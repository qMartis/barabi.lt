<?php

include_once BARABI_CORE_INC_PATH . '/wishlist/helper.php';

if ( ! function_exists( 'barabi_core_wishlist_include_widgets' ) ) {
	/**
	 * Function that includes widgets
	 */
	function barabi_core_wishlist_include_widgets() {
		foreach ( glob( BARABI_CORE_INC_PATH . '/wishlist/widgets/*/include.php' ) as $widget ) {
			include_once $widget;
		}
	}

	add_action( 'qode_framework_action_before_widgets_register', 'barabi_core_wishlist_include_widgets' );
}

include_once BARABI_CORE_INC_PATH . '/wishlist/profile/wishlist-profile-helper.php';
