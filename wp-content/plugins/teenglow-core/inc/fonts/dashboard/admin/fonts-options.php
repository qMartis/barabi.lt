<?php

if ( ! function_exists( 'teenglow_core_add_fonts_options' ) ) {
	/**
	 * Function that add options for this module
	 */
	function teenglow_core_add_fonts_options() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope'       => TEENGLOW_CORE_OPTIONS_NAME,
				'type'        => 'admin',
				'slug'        => 'fonts',
				'title'       => esc_html__( 'Fonts', 'teenglow-core' ),
				'description' => esc_html__( 'Global Fonts Options', 'teenglow-core' ),
				'icon'        => 'fa fa-cog',
			)
		);

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_google_fonts',
					'title'         => esc_html__( 'Enable Google Fonts', 'teenglow-core' ),
					'default_value' => 'yes',
					'args'          => array(
						'custom_class' => 'qodef-enable-google-fonts',
					),
				)
			);

			$google_fonts_section = $page->add_section_element(
				array(
					'name'       => 'qodef_google_fonts_section',
					'title'      => esc_html__( 'Google Fonts Options', 'teenglow-core' ),
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
					'title'       => esc_html__( 'Google Fonts to Include', 'teenglow-core' ),
					'description' => esc_html__( 'Choose Google Fonts which you want to use on your website', 'teenglow-core' ),
					'button_text' => esc_html__( 'Add New Google Font', 'teenglow-core' ),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type'  => 'googlefont',
					'name'        => 'qodef_choose_google_font',
					'title'       => esc_html__( 'Google Font', 'teenglow-core' ),
					'description' => esc_html__( 'Choose Google Font', 'teenglow-core' ),
					'args'        => array(
						'include' => 'google-fonts',
					),
				)
			);

			$google_fonts_section->add_field_element(
				array(
					'field_type'  => 'checkbox',
					'name'        => 'qodef_google_fonts_weight',
					'title'       => esc_html__( 'Google Fonts Weight', 'teenglow-core' ),
					'description' => esc_html__( 'Choose a default Google Fonts weights for your website. Impact on page load time', 'teenglow-core' ),
					'options'     => array(
						'100'  => esc_html__( '100 Thin', 'teenglow-core' ),
						'100i' => esc_html__( '100 Thin Italic', 'teenglow-core' ),
						'200'  => esc_html__( '200 Extra-Light', 'teenglow-core' ),
						'200i' => esc_html__( '200 Extra-Light Italic', 'teenglow-core' ),
						'300'  => esc_html__( '300 Light', 'teenglow-core' ),
						'300i' => esc_html__( '300 Light Italic', 'teenglow-core' ),
						'400'  => esc_html__( '400 Regular', 'teenglow-core' ),
						'400i' => esc_html__( '400 Regular Italic', 'teenglow-core' ),
						'500'  => esc_html__( '500 Medium', 'teenglow-core' ),
						'500i' => esc_html__( '500 Medium Italic', 'teenglow-core' ),
						'600'  => esc_html__( '600 Semi-Bold', 'teenglow-core' ),
						'600i' => esc_html__( '600 Semi-Bold Italic', 'teenglow-core' ),
						'700'  => esc_html__( '700 Bold', 'teenglow-core' ),
						'700i' => esc_html__( '700 Bold Italic', 'teenglow-core' ),
						'800'  => esc_html__( '800 Extra-Bold', 'teenglow-core' ),
						'800i' => esc_html__( '800 Extra-Bold Italic', 'teenglow-core' ),
						'900'  => esc_html__( '900 Ultra-Bold', 'teenglow-core' ),
						'900i' => esc_html__( '900 Ultra-Bold Italic', 'teenglow-core' ),
					),
				)
			);

			$google_fonts_section->add_field_element(
				array(
					'field_type'  => 'checkbox',
					'name'        => 'qodef_google_fonts_subset',
					'title'       => esc_html__( 'Google Fonts Style', 'teenglow-core' ),
					'description' => esc_html__( 'Choose a default Google Fonts style for your website. Impact on page load time', 'teenglow-core' ),
					'options'     => array(
						'latin'        => esc_html__( 'Latin', 'teenglow-core' ),
						'latin-ext'    => esc_html__( 'Latin Extended', 'teenglow-core' ),
						'cyrillic'     => esc_html__( 'Cyrillic', 'teenglow-core' ),
						'cyrillic-ext' => esc_html__( 'Cyrillic Extended', 'teenglow-core' ),
						'greek'        => esc_html__( 'Greek', 'teenglow-core' ),
						'greek-ext'    => esc_html__( 'Greek Extended', 'teenglow-core' ),
						'vietnamese'   => esc_html__( 'Vietnamese', 'teenglow-core' ),
					),
				)
			);

			$page_repeater = $page->add_repeater_element(
				array(
					'name'        => 'qodef_custom_fonts',
					'title'       => esc_html__( 'Custom Fonts', 'teenglow-core' ),
					'description' => esc_html__( 'Add custom fonts', 'teenglow-core' ),
					'button_text' => esc_html__( 'Add New Custom Font', 'teenglow-core' ),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_ttf',
					'title'      => esc_html__( 'Custom Font TTF', 'teenglow-core' ),
					'args'       => array(
						'allowed_type' => 'font/ttf',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_otf',
					'title'      => esc_html__( 'Custom Font OTF', 'teenglow-core' ),
					'args'       => array(
						'allowed_type' => 'font/otf',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_woff',
					'title'      => esc_html__( 'Custom Font WOFF', 'teenglow-core' ),
					'args'       => array(
						'allowed_type' => 'font/woff',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_woff2',
					'title'      => esc_html__( 'Custom Font WOFF2', 'teenglow-core' ),
					'args'       => array(
						'allowed_type' => 'font/woff2',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_custom_font_name',
					'title'      => esc_html__( 'Custom Font Name', 'teenglow-core' ),
				)
			);

			// Hook to include additional options after module options
			do_action( 'teenglow_core_action_after_page_fonts_options_map', $page );
		}
	}

	add_action( 'teenglow_core_action_default_options_init', 'teenglow_core_add_fonts_options', teenglow_core_get_admin_options_map_position( 'fonts' ) );
}
