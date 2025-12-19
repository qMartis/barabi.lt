<?php

if ( ! function_exists( 'barabi_core_add_animated_icon_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function barabi_core_add_animated_icon_shortcode( $shortcodes ) {
		$shortcodes[] = 'BarabiCore_Animated_Icon_Shortcode';

		return $shortcodes;
	}

	add_filter( 'barabi_core_filter_register_shortcodes', 'barabi_core_add_animated_icon_shortcode' );
}

if ( class_exists( 'BarabiCore_Shortcode' ) ) {
	class BarabiCore_Animated_Icon_Shortcode extends BarabiCore_Shortcode {
		public function map_shortcode() {
			$this->set_shortcode_path( BARABI_CORE_SHORTCODES_URL_PATH . '/animated-icon' );
			$this->set_base( 'barabi_core_animated_icon' );
			$this->set_name( esc_html__( 'Animated Icon', 'barabi-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds animated icon', 'barabi-core' ) );
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'text',
					'name'          => 'link',
					'title'         => esc_html__( 'Link', 'barabi-core' ),
					'default_value' => '',
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'target',
					'title'         => esc_html__( 'Link Target', 'barabi-core' ),
					'options'       => barabi_core_get_select_type_options_pool( 'link_target' ),
					'default_value' => '_self',
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'icon_type',
					'title'         => esc_html__( 'Icon Type', 'barabi-core' ),
					'options'       => array(
						'custom-icon' => esc_html__( 'Custom Icon', 'barabi-core' ),
						'svg-icon'    => esc_html__( 'SVG Icon', 'barabi-core' ),
					),
					'default_value' => 'custom-icon',
					'group'         => esc_html__( 'Icon', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'image',
					'name'       => 'custom_icon',
					'title'      => esc_html__( 'Custom Icon', 'barabi-core' ),
					'group'      => esc_html__( 'Icon', 'barabi-core' ),
					'dependency' => array(
						'show' => array(
							'icon_type' => array(
								'values'        => 'custom-icon',
								'default_value' => 'custom-icon',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textarea',
					'name'       => 'svg_icon',
					'title'      => esc_html__( 'SVG Path', 'barabi-core' ),
					'group'      => esc_html__( 'Icon', 'barabi-core' ),
					'dependency' => array(
						'show' => array(
							'icon_type' => array(
								'values'        => 'svg-icon',
								'default_value' => 'icon-pack',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'text',
					'name'          => 'duration',
					'title'         => esc_html__( 'Animation Duration', 'barabi-core' ),
					'description'   => esc_html__( 'Insert animation duration in seconds, default is 2s', 'barabi-core' ),
					'default_value' => '',
				)
			);
			$this->map_extra_options();
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['holder_styles']  = $this->get_holder_styles( $atts );

			return barabi_core_get_template_part( 'shortcodes/animated-icon', 'templates/animated-icon', '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-animated-icon';
			$holder_classes[] = ! empty( $atts['icon_type'] ) ? 'qodef--' . $atts['icon_type'] : '';

			return implode( ' ', $holder_classes );
		}

		private function get_holder_styles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['duration'] ) ) {
				$styles[] = '--qode-animation-duration: ' . intval( $atts['duration'] ) . 's';
			}

			return $styles;
		}
	}
}
