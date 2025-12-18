<?php

if ( ! function_exists( 'teenglow_core_dependency_for_top_area_options' ) ) {
	/**
	 * Function which return dependency values for global module options
	 *
	 * @return array
	 */
	function teenglow_core_dependency_for_top_area_options() {
		return apply_filters( 'teenglow_core_filter_top_area_hide_option', array() );
	}
}

if ( ! function_exists( 'teenglow_core_register_top_area_header_areas' ) ) {
	/**
	 * Function which register widget areas for current module
	 */
	function teenglow_core_register_top_area_header_areas() {
		register_sidebar(
			array(
				'id'            => 'qodef-top-area-left',
				'name'          => esc_html__( 'Header Top Area - Left', 'teenglow-core' ),
				'description'   => esc_html__( 'Widgets added here will appear on the left side in top header area', 'teenglow-core' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s qodef-top-bar-widget">',
				'after_widget'  => '</div>',
			)
		);

		register_sidebar(
			array(
				'id'            => 'qodef-top-area-center',
				'name'          => esc_html__( 'Header Top Area - Center', 'teenglow-core' ),
				'description'   => esc_html__( 'Widgets added here will appear in the center of top header area', 'teenglow-core' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s qodef-top-bar-widget">',
				'after_widget'  => '</div>',
			)
		);

		register_sidebar(
			array(
				'id'            => 'qodef-top-area-right',
				'name'          => esc_html__( 'Header Top Area - Right', 'teenglow-core' ),
				'description'   => esc_html__( 'Widgets added here will appear on the right side in top header area', 'teenglow-core' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s qodef-top-bar-widget">',
				'after_widget'  => '</div>',
			)
		);
	}

	add_action( 'teenglow_core_action_additional_header_widgets_area', 'teenglow_core_register_top_area_header_areas' );
}

if ( ! function_exists( 'teenglow_core_set_top_area_header_inner_classes' ) ) {
	/**
	 * Function that return classes for top header area
	 * @param array $classes
	 *
	 * @return array
	 */
	function teenglow_core_set_top_area_header_inner_classes( $classes ) {
		$alignment = teenglow_core_get_post_value_through_levels( 'qodef_set_top_area_header_content_alignment' );
		$text_skin = teenglow_core_get_post_value_through_levels( 'qodef_top_area_header_text_skin' );

		if ( ! empty( $alignment ) ) {
			$classes[] = 'qodef-alignment--' . esc_attr( $alignment );
		}

		if ( ! empty( $text_skin ) && 'light' === $text_skin ) {
			$classes[] = 'qodef-skin--light';
		}

		return $classes;
	}

	add_filter( 'teenglow_core_filter_top_area_inner_class', 'teenglow_core_set_top_area_header_inner_classes' );
}
