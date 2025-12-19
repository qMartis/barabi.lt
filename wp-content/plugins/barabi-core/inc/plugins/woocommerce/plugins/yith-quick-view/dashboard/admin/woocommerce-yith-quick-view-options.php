<?php

if ( ! function_exists( 'barabi_core_add_yith_quick_view_options' ) ) {
	/**
	 * Function that add general options for this module
	 *
	 * @param object $page
	 */
	function barabi_core_add_yith_quick_view_options( $page ) {

		if ( $page ) {

			if ( qode_framework_is_installed( 'yith-quick-view' ) ) {

				$yith_quick_view_tab = $page->add_tab_element(
					array(
						'name'        => 'tab-yith-quick-view',
						'icon'        => 'fa fa-cog',
						'title'       => esc_html__( 'YITH Quick View', 'barabi-core' ),
						'description' => esc_html__( 'Settings related to YITH Quick View', 'barabi-core' ),
					)
				);

				$yith_quick_view_tab->add_field_element(
					array(
						'field_type'  => 'select',
						'name'        => 'qodef_woo_yith_quick_view_title_tag',
						'title'       => esc_html__( 'Title Tag', 'barabi-core' ),
						'description' => esc_html__( 'Choose title tag for YITH Quick View item', 'barabi-core' ),
						'options'     => barabi_core_get_select_type_options_pool( 'title_tag' ),
					)
				);

                $yith_quick_view_tab->add_field_element(
                    array(
                        'field_type'  => 'text',
                        'name'        => 'qodef_woo_yith_quick_view_excerpt_length',
                        'title'       => esc_html__( 'Excerpt Length', 'barabi-core' ),
                        'description' => esc_html__( 'Fill a number of characters in excerpt for product summary in YITH Quick View', 'barabi-core' ),
                    )
                );

				$yith_quick_view_tab->add_field_element(
					array(
						'field_type'    => 'yesno',
						'name'          => 'qodef_enable_woo_yith_quick_view_predefined_style',
						'title'         => esc_html__( 'Enable Predefined Style', 'barabi-core' ),
						'description'   => esc_html__( 'Enabling this option will set predefined style for YITH Quick View plugin', 'barabi-core' ),
						'options'       => barabi_core_get_select_type_options_pool( 'no_yes', false ),
						'default_value' => 'yes',
					)
				);
			}
		}
	}

	add_action( 'barabi_core_action_after_woo_options_map', 'barabi_core_add_yith_quick_view_options' );
}
