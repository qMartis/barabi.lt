<?php

if ( ! function_exists( 'barabi_core_dependency_for_top_area_options' ) ) {
	/**
	 * Function which return dependency values for global module options
	 *
	 * @return array
	 */
	function barabi_core_dependency_for_top_area_options() {
		return apply_filters( 'barabi_core_filter_top_area_hide_option', array() );
	}
}

if ( ! function_exists( 'barabi_core_register_top_area_header_areas' ) ) {
	/**
	 * Function which register widget areas for current module
	 */
	function barabi_core_register_top_area_header_areas() {
		register_sidebar(
			array(
				'id'            => 'qodef-top-area-left',
				'name'          => esc_html__( 'Header Top Area - Left', 'barabi-core' ),
				'description'   => esc_html__( 'Widgets added here will appear on the left side in top header area', 'barabi-core' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s qodef-top-bar-widget">',
				'after_widget'  => '</div>',
			)
		);

		register_sidebar(
			array(
				'id'            => 'qodef-top-area-center',
				'name'          => esc_html__( 'Header Top Area - Center', 'barabi-core' ),
				'description'   => esc_html__( 'Widgets added here will appear in the center of top header area', 'barabi-core' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s qodef-top-bar-widget">',
				'after_widget'  => '</div>',
			)
		);

		register_sidebar(
			array(
				'id'            => 'qodef-top-area-right',
				'name'          => esc_html__( 'Header Top Area - Right', 'barabi-core' ),
				'description'   => esc_html__( 'Widgets added here will appear on the right side in top header area', 'barabi-core' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s qodef-top-bar-widget">',
				'after_widget'  => '</div>',
			)
		);
	}

	add_action( 'barabi_core_action_additional_header_widgets_area', 'barabi_core_register_top_area_header_areas' );
}

if ( ! function_exists( 'barabi_core_set_top_area_header_inner_classes' ) ) {
	/**
	 * Function that return classes for top header area
	 * @param array $classes
	 *
	 * @return array
	 */
	function barabi_core_set_top_area_header_inner_classes( $classes ) {
		$alignment = barabi_core_get_post_value_through_levels( 'qodef_set_top_area_header_content_alignment' );
		$text_skin = barabi_core_get_post_value_through_levels( 'qodef_top_area_header_text_skin' );

		if ( ! empty( $alignment ) ) {
			$classes[] = 'qodef-alignment--' . esc_attr( $alignment );
		}

		if ( ! empty( $text_skin ) && 'light' === $text_skin ) {
			$classes[] = 'qodef-skin--light';
		}

		return $classes;
	}

	add_filter( 'barabi_core_filter_top_area_inner_class', 'barabi_core_set_top_area_header_inner_classes' );
}
