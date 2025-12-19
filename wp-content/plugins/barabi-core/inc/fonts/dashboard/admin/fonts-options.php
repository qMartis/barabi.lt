<?php

if ( ! function_exists( 'barabi_core_add_fonts_options' ) ) {
	/**
	 * Function that add options for this module
	 */
	function barabi_core_add_fonts_options() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope'       => BARABI_CORE_OPTIONS_NAME,
				'type'        => 'admin',
				'slug'        => 'fonts',
				'title'       => esc_html__( 'Fonts', 'barabi-core' ),
				'description' => esc_html__( 'Global Fonts Options', 'barabi-core' ),
				'icon'        => 'fa fa-cog',
			)
		);

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_google_fonts',
					'title'         => esc_html__( 'Enable Google Fonts', 'barabi-core' ),
					'default_value' => 'yes',
					'args'          => array(
						'custom_class' => 'qodef-enable-google-fonts',
					),
				)
			);

			$google_fonts_section = $page->add_section_element(
				array(
					'name'       => 'qodef_google_fonts_section',
					'title'      => esc_html__( 'Google Fonts Options', 'barabi-core' ),
					'dependency' => array(
						'show' => array(
							'qodef_enable_google_fonts' => array(
								'values'        => 'yes',
								'default_value' => '',
							),
						),
					),
				)
			);

			$page_repeater = $google_fonts_section->add_repeater_element(
				array(
					'name'        => 'qodef_choose_google_fonts',
					'title'       => esc_html__( 'Google Fonts to Include', 'barabi-core' ),
					'description' => esc_html__( 'Choose Google Fonts which you want to use on your website', 'barabi-core' ),
					'button_text' => esc_html__( 'Add New Google Font', 'barabi-core' ),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type'  => 'googlefont',
					'name'        => 'qodef_choose_google_font',
					'title'       => esc_html__( 'Google Font', 'barabi-core' ),
					'description' => esc_html__( 'Choose Google Font', 'barabi-core' ),
					'args'        => array(
						'include' => 'google-fonts',
					),
				)
			);

			$google_fonts_section->add_field_element(
				array(
					'field_type'  => 'checkbox',
					'name'        => 'qodef_google_fonts_weight',
					'title'       => esc_html__( 'Google Fonts Weight', 'barabi-core' ),
					'description' => esc_html__( 'Choose a default Google Fonts weights for your website. Impact on page load time', 'barabi-core' ),
					'options'     => array(
						'100'  => esc_html__( '100 Thin', 'barabi-core' ),
						'100i' => esc_html__( '100 Thin Italic', 'barabi-core' ),
						'200'  => esc_html__( '200 Extra-Light', 'barabi-core' ),
						'200i' => esc_html__( '200 Extra-Light Italic', 'barabi-core' ),
						'300'  => esc_html__( '300 Light', 'barabi-core' ),
						'300i' => esc_html__( '300 Light Italic', 'barabi-core' ),
						'400'  => esc_html__( '400 Regular', 'barabi-core' ),
						'400i' => esc_html__( '400 Regular Italic', 'barabi-core' ),
						'500'  => esc_html__( '500 Medium', 'barabi-core' ),
						'500i' => esc_html__( '500 Medium Italic', 'barabi-core' ),
						'600'  => esc_html__( '600 Semi-Bold', 'barabi-core' ),
						'600i' => esc_html__( '600 Semi-Bold Italic', 'barabi-core' ),
						'700'  => esc_html__( '700 Bold', 'barabi-core' ),
						'700i' => esc_html__( '700 Bold Italic', 'barabi-core' ),
						'800'  => esc_html__( '800 Extra-Bold', 'barabi-core' ),
						'800i' => esc_html__( '800 Extra-Bold Italic', 'barabi-core' ),
						'900'  => esc_html__( '900 Ultra-Bold', 'barabi-core' ),
						'900i' => esc_html__( '900 Ultra-Bold Italic', 'barabi-core' ),
					),
				)
			);

			$google_fonts_section->add_field_element(
				array(
					'field_type'  => 'checkbox',
					'name'        => 'qodef_google_fonts_subset',
					'title'       => esc_html__( 'Google Fonts Style', 'barabi-core' ),
					'description' => esc_html__( 'Choose a default Google Fonts style for your website. Impact on page load time', 'barabi-core' ),
					'options'     => array(
						'latin'        => esc_html__( 'Latin', 'barabi-core' ),
						'latin-ext'    => esc_html__( 'Latin Extended', 'barabi-core' ),
						'cyrillic'     => esc_html__( 'Cyrillic', 'barabi-core' ),
						'cyrillic-ext' => esc_html__( 'Cyrillic Extended', 'barabi-core' ),
						'greek'        => esc_html__( 'Greek', 'barabi-core' ),
						'greek-ext'    => esc_html__( 'Greek Extended', 'barabi-core' ),
						'vietnamese'   => esc_html__( 'Vietnamese', 'barabi-core' ),
					),
				)
			);

			$page_repeater = $page->add_repeater_element(
				array(
					'name'        => 'qodef_custom_fonts',
					'title'       => esc_html__( 'Custom Fonts', 'barabi-core' ),
					'description' => esc_html__( 'Add custom fonts', 'barabi-core' ),
					'button_text' => esc_html__( 'Add New Custom Font', 'barabi-core' ),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_ttf',
					'title'      => esc_html__( 'Custom Font TTF', 'barabi-core' ),
					'args'       => array(
						'allowed_type' => 'font/ttf',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_otf',
					'title'      => esc_html__( 'Custom Font OTF', 'barabi-core' ),
					'args'       => array(
						'allowed_type' => 'font/otf',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_woff',
					'title'      => esc_html__( 'Custom Font WOFF', 'barabi-core' ),
					'args'       => array(
						'allowed_type' => 'font/woff',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_woff2',
					'title'      => esc_html__( 'Custom Font WOFF2', 'barabi-core' ),
					'args'       => array(
						'allowed_type' => 'font/woff2',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_custom_font_name',
					'title'      => esc_html__( 'Custom Font Name', 'barabi-core' ),
				)
			);

			// Hook to include additional options after module options
			do_action( 'barabi_core_action_after_page_fonts_options_map', $page );
		}
	}

	add_action( 'barabi_core_action_default_options_init', 'barabi_core_add_fonts_options', barabi_core_get_admin_options_map_position( 'fonts' ) );
}
