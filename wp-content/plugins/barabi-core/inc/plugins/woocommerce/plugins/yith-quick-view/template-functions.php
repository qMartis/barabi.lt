<?php

if ( ! function_exists( 'barabi_core_yith_quick_view_single_title' ) ) {
	/**
	 * Function that override product single item title template
	 */
	function barabi_core_yith_quick_view_single_title() {
		$option    = barabi_get_post_value_through_levels( 'qodef_woo_yith_quick_view_title_tag' );
		$title_tag = ! empty( $option ) ? esc_attr( $option ) : 'h4';

		echo '<' . esc_attr( $title_tag ) . ' class="qodef-woo-product-title product_title entry-title">' . wp_kses_post( get_the_title() ) . '</' . esc_attr( $title_tag ) . '>';
	}
}

if ( ! function_exists( 'barabi_core_add_yith_quick_view_plugin_link_to_single' ) ) {
	/**
	 * Insert the opening anchor tag for products in the loop.
	 */
	function barabi_core_add_yith_quick_view_plugin_link_to_single() {
		if ( class_exists( 'BarabiCore_Button_Shortcode' ) ) {
			$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), barabi_core_woo_get_global_product() );

			$button_params = array(
				'link'          => $link,
				'text'          => esc_html__( 'View Details', 'barabi-core' ),
				'size'          => 'normal',
				'button_layout' => 'filled',
				'custom_class'  => 'qodef-yith-wcqv-link',
			);

			echo BarabiCore_Button_Shortcode::call_shortcode( $button_params );
		}
	}
}

if ( ! function_exists( 'barabi_core_add_yith_quick_view_plugin_add_body_classes' ) ) {
	/**
	 * Function that add additional class name into global class list for body tag
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	function barabi_core_add_yith_quick_view_plugin_add_body_classes( $classes ) {
		if ( qode_framework_is_installed( 'yith-quick-view' ) ) {
			$option = barabi_core_get_post_value_through_levels( 'qodef_enable_woo_yith_quick_view_predefined_style' );

			if ( 'yes' === $option ) {
				$classes[] = 'qodef-yith-wcqv--predefined';
			}
		}
		return $classes;
	}

	add_filter( 'body_class', 'barabi_core_add_yith_quick_view_plugin_add_body_classes' );
}

if ( ! function_exists( 'barabi_core_get_yith_quick_view_plugin_modified_excerpt' ) ) {

    function barabi_core_get_yith_quick_view_plugin_modified_excerpt() {

        $product = barabi_core_woo_get_global_product();
        $excerpt = get_the_excerpt( $product->get_id() );

        $number_of_characters = barabi_core_get_post_value_through_levels( 'qodef_woo_yith_quick_view_excerpt_length' );
        if ( empty( $number_of_characters ) ) {
            $number_of_characters = 70;
        }

        $excerpt = substr( $excerpt, 0, $number_of_characters );
        ?>

        <div class="woocommerce-product-details__short-description">
            <p><?php echo qode_framework_wp_kses_html( 'content', $excerpt); ?></p>
        </div>
        <?php
    }
}
