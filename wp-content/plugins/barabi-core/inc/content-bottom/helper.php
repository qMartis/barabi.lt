<?php

if ( ! function_exists( 'barabi_core_is_content_bottom_enabled' ) ) {
	/**
	 * Function that check is module enabled
	 *
	 * @return bool
	 */
	function barabi_core_is_content_bottom_enabled() {
		$is_enabled = false;
		$option     = 'no' !== barabi_core_get_post_value_through_levels( 'qodef_enable_content_bottom' );

		if ( $option ) {
			$is_enabled = true;
		}

		if ( ! $option ) {
			$is_enabled = false;
		}

		return apply_filters( 'barabi_core_enable_content_bottom', $is_enabled );
	}
}

if ( ! function_exists( 'barabi_core_load_content_bottom' ) ) {
	/**
	 * Loads content bottom HTML
	 */
	function barabi_core_load_content_bottom() {
		if ( barabi_core_is_content_bottom_enabled() ) {
			$params         = array();
			$custom_sidebar = barabi_core_get_post_value_through_levels( 'qodef_content_bottom_custom_sidebar' );

			$params['sidebar'] = ! empty( $custom_sidebar ) ? $custom_sidebar : 'qodef-content-bottom';

			barabi_core_template_part( 'content-bottom', 'templates/content-bottom', '', $params );
		}
	}

	add_action( 'barabi_action_page_footer_template', 'barabi_core_load_content_bottom', 9 );
}

if ( ! function_exists( 'barabi_core_get_content_bottom_config' ) ) {
	/**
	 * Function that return config variables for side area
	 *
	 * @return array
	 */
	function barabi_core_get_content_bottom_config() {
		// Config variables
		$config = apply_filters(
			'barabi_core_filter_content_bottom_config',
			array(
				'title_tag'   => 'h5',
				'title_class' => 'qodef-widget-title',
			)
		);

		return $config;
	}
}

if ( ! function_exists( 'barabi_core_register_content_bottom_sidebar' ) ) {
	/**
	 * Register content bottom sidebar
	 */
	function barabi_core_register_content_bottom_sidebar() {
		// Sidebar config variables
		$config = barabi_core_get_content_bottom_config();

		register_sidebar(
			array(
				'id'            => 'qodef-content-bottom',
				'name'          => esc_html__( 'Content Bottom', 'barabi-core' ),
				'description'   => esc_html__( 'Widgets added here will appear in content bottom', 'barabi-core' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s" data-area="side-area">',
				'after_widget'  => '</div>',
				'before_title'  => '<' . esc_attr( $config['title_tag'] ) . ' class="' . esc_attr( $config['title_class'] ) . '">',
				'after_title'   => '</' . esc_attr( $config['title_tag'] ) . '>',
			)
		);
	}

	add_action( 'widgets_init', 'barabi_core_register_content_bottom_sidebar' );
}

if ( ! function_exists( 'barabi_core_set_content_bottom_classes' ) ) {
    /**
     * Function that return classes for content bottom area
     *
     * @param string $classes
     *
     * @return string
     */
    function barabi_core_set_content_bottom_classes( $classes ) {
        $is_grid_enabled = 'no' !== barabi_core_get_post_value_through_levels( 'qodef_content_bottom_in_grid' );

        if ( ! $is_grid_enabled ) {
            $classes = 'qodef-content-full-width';
        }

        return $classes;
    }

    add_filter( 'barabi_core_filter_content_bottom_classes', 'barabi_core_set_content_bottom_classes' );
}

if ( ! function_exists( 'barabi_core_get_content_bottom_classes' ) ) {
    /**
     * Function that return classes for page footer top area
     *
     * @return string
     */
    function barabi_core_get_content_bottom_classes() {

        $classes = '';
        $classes .= 'qodef-content-grid';

        return apply_filters( 'barabi_core_filter_content_bottom_classes', $classes );
    }
}
