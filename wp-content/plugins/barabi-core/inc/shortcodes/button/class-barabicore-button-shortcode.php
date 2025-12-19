<?php

if ( ! function_exists( 'barabi_core_add_button_shortcode' ) ) {
	/**
	 * Function that isadding shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes - Array of registered shortcodes
	 *
	 * @return array
	 */
	function barabi_core_add_button_shortcode( $shortcodes ) {
		$shortcodes[] = 'BarabiCore_Button_Shortcode';

		return $shortcodes;
	}

	add_filter( 'barabi_core_filter_register_shortcodes', 'barabi_core_add_button_shortcode', 9 );
}

if ( class_exists( 'BarabiCore_Shortcode' ) ) {
	class BarabiCore_Button_Shortcode extends BarabiCore_Shortcode {

		public function __construct() {
			$this->set_layouts( apply_filters( 'barabi_core_filter_button_layouts', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( BARABI_CORE_SHORTCODES_URL_PATH . '/button' );
			$this->set_base( 'barabi_core_button' );
			$this->set_name( esc_html__( 'Button', 'barabi-core' ) );
			$this->set_description( esc_html__( 'Shortcode that displays button with provided parameters', 'barabi-core' ) );
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'barabi-core' ),
				)
			);

			$options_map = barabi_core_get_variations_options_map( $this->get_layouts() );

			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'button_layout',
					'title'         => esc_html__( 'Layout', 'barabi-core' ),
					'options'       => $this->get_layouts(),
					'default_value' => $options_map['default_value'],
					'visibility'    => array(
						'map_for_page_builder' => $options_map['visibility'],
						'map_for_widget'       => $options_map['visibility'],
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'size',
					'title'      => esc_html__( 'Size', 'barabi-core' ),
					'options'    => array(
						''      => esc_html__( 'Normal', 'barabi-core' ),
						'small' => esc_html__( 'Small', 'barabi-core' ),
						'large' => esc_html__( 'Large', 'barabi-core' ),
						'full'  => esc_html__( 'Normal Full Width', 'barabi-core' ),
					),
					'dependency' => array(
						'hide' => array(
							'button_layout' => array(
								'values'        => array( 'textual', 'rounded' ),
								'default_value' => 'filled',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'text',
					'name'          => 'text',
					'title'         => esc_html__( 'Button Text', 'barabi-core' ),
					'default_value' => esc_html__( 'Button Text', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'link',
					'title'      => esc_html__( 'Button Link', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'target',
					'title'         => esc_html__( 'Target', 'barabi-core' ),
					'options'       => barabi_core_get_select_type_options_pool( 'link_target' ),
					'default_value' => '_self',
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'color',
					'title'      => esc_html__( 'Text Color', 'barabi-core' ),
					'group'      => esc_html__( 'Style', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'name'       => 'hover_color',
					'field_type' => 'color',
					'title'      => esc_html__( 'Text Hover Color', 'barabi-core' ),
					'group'      => esc_html__( 'Style', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'background_color',
					'title'      => esc_html__( 'Background Color', 'barabi-core' ),
					'group'      => esc_html__( 'Style', 'barabi-core' ),
					'dependency' => array(
						'show' => array(
							'button_layout' => array(
								'values'        => array( 'filled', 'rounded' ),
								'default_value' => 'filled',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'hover_background_color',
					'title'      => esc_html__( 'Background Hover Color', 'barabi-core' ),
					'group'      => esc_html__( 'Style', 'barabi-core' ),
					'dependency' => array(
						'show' => array(
							'button_layout' => array(
								'values'        => array( 'filled', 'outlined', 'rounded' ),
								'default_value' => 'filled',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'border_color',
					'title'      => esc_html__( 'Border Color', 'barabi-core' ),
					'group'      => esc_html__( 'Style', 'barabi-core' ),
					'dependency' => array(
						'show' => array(
							'button_layout' => array(
								'values'        => array( 'filled', 'outlined', 'rounded' ),
								'default_value' => 'filled',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'hover_border_color',
					'title'      => esc_html__( 'Border Hover Color', 'barabi-core' ),
					'group'      => esc_html__( 'Style', 'barabi-core' ),
					'dependency' => array(
						'show' => array(
							'button_layout' => array(
								'values'        => array( 'filled', 'outlined', 'rounded' ),
								'default_value' => 'filled',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'margin',
					'title'       => esc_html__( 'Margin', 'barabi-core' ),
					'description' => esc_html__( 'Set margin that will be applied for button in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'barabi-core' ),
					'group'       => esc_html__( 'Style', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'padding',
					'title'       => esc_html__( 'Padding', 'barabi-core' ),
					'description' => esc_html__( 'Set padding that will be applied for button in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'barabi-core' ),
					'group'       => esc_html__( 'Style', 'barabi-core' ),
                    'dependency' => array(
                        'hide' => array(
                            'button_layout' => array(
                                'values'        => array( 'rounded' ),
                                'default_value' => 'filled',
                            ),
                        ),
                    ),
				)
			);
            $this->set_option(
                array(
                    'field_type' => 'text',
                    'name'       => 'circle_size',
                    'title'      => esc_html__( 'Circle Size', 'barabi-core' ),
                    'group'      => esc_html__( 'Style', 'barabi-core' ),
                    'dependency' => array(
                        'show' => array(
                            'button_layout' => array(
                                'values'        => array( 'rounded' ),
                                'default_value' => 'filled',
                            ),
                        ),
                    ),
                )
            );
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'font_size',
					'title'      => esc_html__( 'Font Size', 'barabi-core' ),
					'group'      => esc_html__( 'Typography Style', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'font_weight',
					'title'      => esc_html__( 'Font Weight', 'barabi-core' ),
					'options'    => barabi_core_get_select_type_options_pool( 'font_weight' ),
					'group'      => esc_html__( 'Typography Style', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'text_transform',
					'title'      => esc_html__( 'Text Transform', 'barabi-core' ),
					'options'    => barabi_core_get_select_type_options_pool( 'text_transform' ),
					'group'      => esc_html__( 'Typography Style', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'html_type',
					'title'         => esc_html__( 'HTML Type', 'barabi-core' ),
					'options'       => array(
						'default' => esc_html__( 'Default', 'barabi-core' ),
						'input'   => esc_html__( 'Input', 'barabi-core' ),
						'submit'  => esc_html__( 'Submit', 'barabi-core' ),
					),
					'default_value' => 'default',
					'visibility'    => array(
						'map_for_page_builder' => false,
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'input_name',
					'title'      => esc_html__( 'Input Name', 'barabi-core' ),
					'visibility' => array(
						'map_for_page_builder' => false,
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'array',
					'name'       => 'custom_attrs',
					'title'      => esc_html__( 'Custom Data Attributes', 'barabi-core' ),
					'visibility' => array(
						'map_for_page_builder' => false,
					),
				)
			);
		}

		public static function call_shortcode( $params ) {
			$html = qode_framework_call_shortcode( 'barabi_core_button', $params );
			$html = str_replace( "\n", '', $html );

			return $html;
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['data_attrs']     = $this->get_data_attrs( $atts );
			$atts['styles']         = $this->get_styles( $atts );

			return barabi_core_get_template_part( 'shortcodes/button', 'variations/' . $atts['button_layout'] . '/templates/' . $atts['html_type'], '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-button';
			$holder_classes[] = ! empty( $atts['button_layout'] ) ? 'qodef-layout--' . $atts['button_layout'] : '';
			$holder_classes[] = ! empty( $atts['size'] ) ? 'qodef-size--' . $atts['size'] : '';
			$holder_classes[] = 'default' === $atts['html_type'] ? 'qodef-html--link' : '';

			return implode( ' ', $holder_classes );
		}

		private function get_data_attrs( $atts ) {
			$data = array();

			if ( ! empty( $atts['hover_color'] ) ) {
				$data['data-hover-color'] = $atts['hover_color'];
			}

			if ( ! empty( $atts['hover_background_color'] ) ) {
				$data['data-hover-background-color'] = $atts['hover_background_color'];
			}

			if ( ! empty( $atts['hover_border_color'] ) ) {
				$data['data-hover-border-color'] = $atts['hover_border_color'];
			}

			if ( ! empty( $atts['custom_attrs'] ) && is_array( $atts['custom_attrs'] ) ) {
				$data = array_merge( $data, $atts['custom_attrs'] );
			}

			return $data;
		}

		private function get_styles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['color'] ) ) {
				$styles[] = 'color: ' . $atts['color'];
			}

			if ( ! empty( $atts['background_color'] ) ) {
				$styles[] = 'background-color: ' . $atts['background_color'];
			}

			if ( ! empty( $atts['border_color'] ) ) {
				$styles[] = 'border-color: ' . $atts['border_color'];
			}

			if ( ! empty( $atts['font_size'] ) ) {
				if ( qode_framework_string_ends_with_typography_units( $atts['font_size'] ) ) {
					$styles[] = 'font-size: ' . $atts['font_size'];
				} else {
					$styles[] = 'font-size: ' . intval( $atts['font_size'] ) . 'px';
				}
			}

			if ( ! empty( $atts['font_weight'] ) ) {
				$styles[] = 'font-weight: ' . $atts['font_weight'];
			}

			if ( ! empty( $atts['text_transform'] ) ) {
				$styles[] = 'text-transform: ' . $atts['text_transform'];
			}

			if ( '' !== $atts['margin'] ) {
				$styles[] = 'margin: ' . $atts['margin'];
			}

            if ( 'rounded' !== $atts['button_layout'] ) {

                if ( '' !== $atts['padding'] ) {
                    $styles[] = 'padding: ' . $atts['padding'];
                }
            }

            if ( 'rounded' === $atts['button_layout'] ) {

                if ( '' !== $atts['circle_size'] ) {

                    if ( qode_framework_string_ends_with_typography_units( $atts['circle_size'] ) ) {
                        $styles[] = 'height: ' . $atts['circle_size'];
                        $styles[] = 'width: ' . $atts['circle_size'];
                    } else {
                        $styles[] = 'height: ' . intval( $atts['circle_size'] ) . 'px';
                        $styles[] = 'width: ' . intval( $atts['circle_size'] ) . 'px';
                    }
                }
            }

			return $styles;
		}
	}
}
