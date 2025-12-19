<?php

if ( ! function_exists( 'teenglow_core_is_subscribe_popup_enabled' ) ) {
	function teenglow_core_is_subscribe_popup_enabled() {
		return 'yes' === teenglow_core_get_post_value_through_levels( 'qodef_enable_subscribe_popup' );
	}
}

if ( ! function_exists( 'teenglow_core_get_subscribe_popup' ) ) {
	/**
	 * Loads subscribe popup HTML
	 */
	function teenglow_core_get_subscribe_popup() {
		if ( teenglow_core_is_subscribe_popup_enabled() && ! empty( teenglow_core_get_option_value( 'admin', 'qodef_subscribe_popup_contact_form' ) ) ) {
			teenglow_core_load_subscribe_popup_template();
		}
	}

	// Get subscribe popup HTML
	add_action( 'teenglow_action_before_wrapper_close_tag', 'teenglow_core_get_subscribe_popup' );
}

if ( ! function_exists( 'teenglow_core_load_subscribe_popup_template' ) ) {
	/**
	 * Loads HTML template with params
	 */
	function teenglow_core_load_subscribe_popup_template() {
		$params                     = array();
		$params['title']            = teenglow_core_get_option_value( 'admin', 'qodef_subscribe_popup_title' );
		$params['subtitle']         = teenglow_core_get_option_value( 'admin', 'qodef_subscribe_popup_subtitle' );
		$background_image           = teenglow_core_get_option_value( 'admin', 'qodef_subscribe_popup_background_image' );
		$params['content_style']    = ! empty( $background_image ) ? 'background-image: url(' . esc_url( wp_get_attachment_url( $background_image ) ) . ')' : '';
		$params['contact_form']     = teenglow_core_get_option_value( 'admin', 'qodef_subscribe_popup_contact_form' );
		$params['enable_prevent']   = teenglow_core_get_option_value( 'admin', 'qodef_enable_subscribe_popup_prevent' );
		$params['prevent_behavior'] = teenglow_core_get_option_value( 'admin', 'qodef_subscribe_popup_prevent_behavior' );

		$holder_classes           = array();
		$holder_classes[]         = ! empty( $params['prevent_behavior'] ) ? 'qodef-sp-prevent-' . $params['prevent_behavior'] : 'qodef-sp-prevent-session';
		$params['holder_classes'] = implode( ' ', $holder_classes );

		echo teenglow_core_get_template_part( 'subscribe-popup', 'templates/subscribe-popup', '', $params );
	}
}

if ( ! function_exists( 'teenglow_core_include_subscribe_button_shortcodes' ) ) {
	/**
	 * Function that includes shortcodes
	 */
	function teenglow_core_include_subscribe_button_shortcodes() {
		foreach ( glob( TEENGLOW_CORE_INC_PATH . '/subscribe-popup/shortcodes/*/include.php' ) as $shortcode ) {
			include_once $shortcode;
		}
	}

	add_action( 'qode_framework_action_before_shortcodes_register', 'teenglow_core_include_subscribe_button_shortcodes' );
}
