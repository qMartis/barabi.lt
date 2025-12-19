<?php

if ( ! function_exists( 'barabi_core_woo_set_dropdown_cart_widget_styles' ) ) {
	/**
	 * Function that generates module inline styles
	 *
	 * @param string $style
	 *
	 * @return string
	 */
	function barabi_core_woo_set_dropdown_cart_widget_styles( $style ) {
		$styles = array();

		$dropdown_top_position = barabi_core_get_post_value_through_levels( 'qodef_dropdown_top_position' );

		if ( '' !== $dropdown_top_position ) {
			if ( qode_framework_string_ends_with_space_units( $dropdown_top_position, true ) ) {
				$styles['top'] = $dropdown_top_position;
			} else {
				$styles['top'] = intval( $dropdown_top_position ) . '%';
			}
		}

		if ( ! empty( $styles ) ) {
			$style .= qode_framework_dynamic_style( 'header .widget_barabi_core_woo_dropdown_cart .qodef-widget-dropdown-cart-content', $styles );
		}

		return $style;
	}

	add_filter( 'barabi_filter_add_inline_style', 'barabi_core_woo_set_dropdown_cart_widget_styles' );
}
