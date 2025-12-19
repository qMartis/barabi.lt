<?php

if ( ! function_exists( 'barabi_core_add_banner_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function barabi_core_add_banner_shortcode( $shortcodes ) {
		$shortcodes[] = 'BarabiCore_Banner_Shortcode';

		return $shortcodes;
	}

	add_filter( 'barabi_core_filter_register_shortcodes', 'barabi_core_add_banner_shortcode' );
}

if ( class_exists( 'BarabiCore_Shortcode' ) ) {
	class BarabiCore_Banner_Shortcode extends BarabiCore_Shortcode {

		public function __construct() {
			$this->set_layouts( apply_filters( 'barabi_core_filter_banner_layouts', array() ) );
			$this->set_extra_options( apply_filters( 'barabi_core_filter_banner_extra_options', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( BARABI_CORE_SHORTCODES_URL_PATH . '/banner' );
			$this->set_base( 'barabi_core_banner' );
			$this->set_name( esc_html__( 'Banner', 'barabi-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds banner element', 'barabi-core' ) );
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
					'name'          => 'layout',
					'title'         => esc_html__( 'Layout', 'barabi-core' ),
					'options'       => $this->get_layouts(),
					'default_value' => $options_map['default_value'],
					'visibility'    => array( 'map_for_page_builder' => $options_map['visibility'] ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'image',
					'name'       => 'image',
					'title'      => esc_html__( 'Image', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'link_url',
					'title'      => esc_html__( 'Link', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'link_target',
					'title'         => esc_html__( 'Link Target', 'barabi-core' ),
					'options'       => barabi_core_get_select_type_options_pool( 'link_target' ),
					'default_value' => '_self',
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'text',
					'name'          => 'title',
					'title'         => esc_html__( 'Title', 'barabi-core' ),
					'default_value' => esc_html__( 'Title Text', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'title_tag',
					'title'         => esc_html__( 'Title Tag', 'barabi-core' ),
					'options'       => barabi_core_get_select_type_options_pool( 'title_tag' ),
					'default_value' => 'h3',
					'group'         => esc_html__( 'Title Style', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'title_color',
					'title'      => esc_html__( 'Title Color', 'barabi-core' ),
					'group'      => esc_html__( 'Title Style', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'title_margin_top',
					'title'      => esc_html__( 'Title Margin Top', 'barabi-core' ),
					'group'      => esc_html__( 'Title Style', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textarea',
					'name'       => 'text_field',
					'title'      => esc_html__( 'Text', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'text_tag',
					'title'         => esc_html__( 'Text Tag', 'barabi-core' ),
					'options'       => barabi_core_get_select_type_options_pool( 'title_tag' ),
					'default_value' => 'p',
					'group'         => esc_html__( 'Text Style', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'text_color',
					'title'      => esc_html__( 'Text Color', 'barabi-core' ),
					'group'      => esc_html__( 'Text Style', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'text_margin_top',
					'title'      => esc_html__( 'Text Margin Top', 'barabi-core' ),
					'group'      => esc_html__( 'Text Style', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'content_alignment',
					'title'      => esc_html__( 'Content Alignment', 'barabi-core' ),
					'options'    => array(
						''       => esc_html__( 'Default', 'barabi-core' ),
						'left'   => esc_html__( 'Left', 'barabi-core' ),
						'center' => esc_html__( 'Center', 'barabi-core' ),
						'right'  => esc_html__( 'Right', 'barabi-core' ),
					),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'content_padding',
					'title'       => esc_html__( 'Content Padding', 'barabi-core' ),
					'description' => esc_html__( 'Set padding that will be applied for button in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'content_padding_1440',
					'title'       => esc_html__( 'Content Padding 1440', 'barabi-core' ),
					'description' => esc_html__( 'Set padding in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'barabi-core' ),
					'group'       => esc_html__( 'Responsive Style', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'content_padding_1366',
					'title'       => esc_html__( 'Content Padding 1366', 'barabi-core' ),
					'description' => esc_html__( 'Set padding in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'barabi-core' ),
					'group'       => esc_html__( 'Responsive Style', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'content_padding_1024',
					'title'       => esc_html__( 'Content Padding 1024', 'barabi-core' ),
					'description' => esc_html__( 'Set padding in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'barabi-core' ),
					'group'       => esc_html__( 'Responsive Style', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'content_padding_768',
					'title'       => esc_html__( 'Content Padding 768', 'barabi-core' ),
					'description' => esc_html__( 'Set padding in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'barabi-core' ),
					'group'       => esc_html__( 'Responsive Style', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'content_padding_680',
					'title'       => esc_html__( 'Content Padding 680', 'barabi-core' ),
					'description' => esc_html__( 'Set padding in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'barabi-core' ),
					'group'       => esc_html__( 'Responsive Style', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textarea',
					'name'       => 'svg_path',
					'title'      => esc_html__( 'SVG Path', 'barabi-core' ),
					'dependency' => array(
						'show' => array(
							'layout' => array(
								'values'        => 'link-button',
								'default_value' => '',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'svg_fixed_width',
					'title'         => esc_html__( 'Fixed SVG Width', 'barabi-core' ),
					'default_value' => '',
					'options'       => barabi_core_get_select_type_options_pool( 'yes_no' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'svg_offset_top',
					'title'      => esc_html__( 'SVG Offset Top', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'svg_offset_left',
					'title'      => esc_html__( 'SVG Offset Left', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'svg_offset_top_1440',
					'title'      => esc_html__( 'SVG Offset Top 1440', 'barabi-core' ),
					'group'      => esc_html__( 'Responsive Style', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'svg_offset_left_1440',
					'title'      => esc_html__( 'SVG Offset Left 1440', 'barabi-core' ),
					'group'      => esc_html__( 'Responsive Style', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'svg_offset_top_1024',
					'title'      => esc_html__( 'SVG Offset Top 1024', 'barabi-core' ),
					'group'      => esc_html__( 'Responsive Style', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'svg_offset_left_1024',
					'title'      => esc_html__( 'SVG Offset Left 1024', 'barabi-core' ),
					'group'      => esc_html__( 'Responsive Style', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'svg_offset_top_680',
					'title'      => esc_html__( 'SVG Offset Top 680', 'barabi-core' ),
					'group'      => esc_html__( 'Responsive Style', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'svg_offset_left_680',
					'title'      => esc_html__( 'SVG Offset Left 680', 'barabi-core' ),
					'group'      => esc_html__( 'Responsive Style', 'barabi-core' ),
				)
			);
			$this->import_shortcode_options(
				array(
					'shortcode_base'    => 'barabi_core_button',
					'exclude'           => array( 'custom_class', 'link', 'target' ),
					'additional_params' => array(
						'nested_group' => esc_html__( 'Button', 'barabi-core' ),
						'dependency'   => array(
							'show' => array(
								'layout' => array(
									'values'        => 'link-button',
									'default_value' => '',
								),
							),
						),
					),
				)
			);

			$this->map_extra_options();
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['unique_class'] = 'qodef-banner-' . rand( 0, 1000 );

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['content_styles'] = $this->get_content_holder_styles( $atts );
			$atts['title_styles']   = $this->get_title_styles( $atts );
			$atts['text_styles']    = $this->get_text_styles( $atts );
			$atts['svg_styles']     = $this->get_svg_styles( $atts );
			$atts['button_params']  = $this->generate_button_params( $atts );
			$this->set_responsive_content_holder_styles( $atts );
			$this->set_svg_responsive_styles( $atts );

			return barabi_core_get_template_part( 'shortcodes/banner', 'variations/' . $atts['layout'] . '/templates/' . $atts['layout'], '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-banner';
			$holder_classes[] = $atts['unique_class'];
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-layout--' . $atts['layout'] : '';
			$holder_classes[] = ! empty( $atts['content_alignment'] ) ? 'qodef-alignment--' . $atts['content_alignment'] : 'qodef-alignment--left';
			$holder_classes[] = ! empty( $atts['svg_fixed_width'] ) && 'yes' === $atts['svg_fixed_width'] ? 'qodef-svg--fixed-width' : '';

			return implode( ' ', $holder_classes );
		}

		private function get_content_holder_styles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['content_padding'] ) ) {
				$styles[] = 'padding: ' . $atts['content_padding'];
			}

			return $styles;
		}

		private function set_responsive_content_holder_styles( $atts ) {
			$unique_class = '.' . $atts['unique_class'] . '.qodef-banner .qodef-m-content-inner';
			$screen_sizes = array( '1440', '1366', '1024', '768', '680' );
			$option_keys  = array( 'content_padding' );

			foreach ( $screen_sizes as $screen_size ) {
				$styles = array();

				foreach ( $option_keys as $option_key ) {
					$option_value = $atts[ $option_key . '_' . $screen_size ];
					$option_key   = str_replace( 'content_', '', $option_key );
					$style_key    = str_replace( '_', '-', $option_key );

					if ( '' !== $option_value ) {
						$styles[ $style_key ] = $option_value . '!important';
					}
				}

				if ( ! empty( $styles ) ) {
					add_filter(
						'barabi_core_filter_add_responsive_' . $screen_size . '_inline_style_in_footer',
						function ( $style ) use ( $unique_class, $styles ) {
							$style .= qode_framework_dynamic_style( $unique_class, $styles );

							return $style;
						}
					);
				}
			}
		}

		private function get_title_styles( $atts ) {
			$styles = array();

			if ( '' !== $atts['title_margin_top'] ) {
				if ( qode_framework_string_ends_with_space_units( $atts['title_margin_top'] ) ) {
					$styles[] = 'margin-top: ' . $atts['title_margin_top'];
				} else {
					$styles[] = 'margin-top: ' . intval( $atts['title_margin_top'] ) . 'px';
				}
			}

			if ( ! empty( $atts['title_color'] ) ) {
				$styles[] = 'color: ' . $atts['title_color'];
			}

			return $styles;
		}

		private function get_text_styles( $atts ) {
			$styles = array();

			if ( '' !== $atts['text_margin_top'] ) {
				if ( qode_framework_string_ends_with_space_units( $atts['text_margin_top'] ) ) {
					$styles[] = 'margin-top: ' . $atts['text_margin_top'];
				} else {
					$styles[] = 'margin-top: ' . intval( $atts['text_margin_top'] ) . 'px';
				}
			}

			if ( ! empty( $atts['text_color'] ) ) {
				$styles[] = 'color: ' . $atts['text_color'];
			}

			return $styles;
		}

		private function get_svg_styles( $atts ) {
			$styles = array();

			if ( '' !== $atts['svg_offset_top'] ) {
				if ( qode_framework_string_ends_with_space_units( $atts['svg_offset_top'] ) ) {
					$styles[] = 'top: ' . $atts['svg_offset_top'];
				} else {
					$styles[] = 'top: ' . intval( $atts['svg_offset_top'] ) . 'px';
				}
			}

			if ( '' !== $atts['svg_offset_left'] ) {
				if ( qode_framework_string_ends_with_space_units( $atts['svg_offset_left'] ) ) {
					$styles[] = 'left: ' . $atts['svg_offset_left'];
				} else {
					$styles[] = 'left: ' . intval( $atts['svg_offset_left'] ) . 'px';
				}
			}

			return $styles;
		}

		private function set_svg_responsive_styles( $atts ) {
			$unique_class = '.' . $atts['unique_class'] . '.qodef-banner .qodef-m-content-inner .qodef-svg-holder';
			$screen_sizes = array( '1440', '1024', '680' );

			foreach ( $screen_sizes as $screen_size ) {
				$styles = array();

				if ( '' !== $atts[ 'svg_offset_top_' . $screen_size ] ) {
					if ( qode_framework_string_ends_with_space_units( $atts[ 'svg_offset_top_' . $screen_size ] ) ) {
						$styles['top'] = $atts[ 'svg_offset_top_' . $screen_size ] . '!important';
					} else {
						$styles['top'] = intval( $atts[ 'svg_offset_top_' . $screen_size ] ) . 'px' . '!important';
					}
				}

				if ( '' !== $atts[ 'svg_offset_left_' . $screen_size ] ) {
					if ( qode_framework_string_ends_with_space_units( $atts[ 'svg_offset_left_' . $screen_size ] ) ) {
						$styles['left'] = $atts[ 'svg_offset_left_' . $screen_size ] . '!important';
					} else {
						$styles['left'] = intval( $atts[ 'svg_offset_left_' . $screen_size ] ) . 'px' . '!important';
					}
				}

				if ( ! empty( $styles ) ) {
					add_filter(
						'barabi_core_filter_add_responsive_' . $screen_size . '_inline_style_in_footer',
						function ( $style ) use ( $unique_class, $styles ) {
							$style .= qode_framework_dynamic_style( $unique_class, $styles );

							return $style;
						}
					);
				}
			}
		}

		private function generate_button_params( $atts ) {
			$params = $this->populate_imported_shortcode_atts(
				array(
					'shortcode_base' => 'barabi_core_button',
					'exclude'        => array( 'custom_class', 'link', 'target' ),
					'atts'           => $atts,
				)
			);

			$params['link']   = ! empty( $atts['link_url'] ) ? $atts['link_url'] : '';
			$params['target'] = ! empty( $atts['link_target'] ) ? $atts['link_target'] : '';

			return $params;
		}
	}
}
