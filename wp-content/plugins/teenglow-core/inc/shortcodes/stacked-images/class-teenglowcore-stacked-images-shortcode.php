<?php

if ( ! function_exists( 'teenglow_core_add_stacked_images_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function teenglow_core_add_stacked_images_shortcode( $shortcodes ) {
		$shortcodes[] = 'TeenglowCore_Stacked_Images_Shortcode';

		return $shortcodes;
	}

	add_filter( 'teenglow_core_filter_register_shortcodes', 'teenglow_core_add_stacked_images_shortcode' );
}

if ( class_exists( 'TeenglowCore_Shortcode' ) ) {
	class TeenglowCore_Stacked_Images_Shortcode extends TeenglowCore_Shortcode {

		public function __construct() {
			$this->set_layouts( apply_filters( 'teenglow_core_filter_stacked_images_layouts', array() ) );
			$this->set_extra_options( apply_filters( 'teenglow_core_filter_stacked_images_extra_options', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( TEENGLOW_CORE_SHORTCODES_URL_PATH . '/stacked-images' );
			$this->set_base( 'teenglow_core_stacked_images' );
			$this->set_name( esc_html__( 'Stacked Images', 'teenglow-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds image with text element', 'teenglow-core' ) );
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'teenglow-core' ),
				)
			);

			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'parallax_item',
					'title'         => esc_html__( 'Enable Parallax Item', 'teenglow-core' ),
					'options'       => teenglow_core_get_select_type_options_pool( 'yes_no' ),
					'default_value' => '',
				)
			);

			$options_map = teenglow_core_get_variations_options_map( $this->get_layouts() );

			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'layout',
					'title'         => esc_html__( 'Layout', 'teenglow-core' ),
					'options'       => $this->get_layouts(),
					'default_value' => $options_map['default_value'],
					'visibility'    => array( 'map_for_page_builder' => $options_map['visibility'] ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'image',
					'name'       => 'main_image',
					'title'      => esc_html__( 'Main Image', 'teenglow-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'images_proportion',
					'default_value' => 'full',
					'title'         => esc_html__( 'Image Proportions', 'teenglow-core' ),
					'options'       => teenglow_core_get_select_type_options_pool( 'list_image_dimension', false ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'custom_image_width',
					'title'       => esc_html__( 'Custom Image Width', 'teenglow-core' ),
					'description' => esc_html__( 'Enter image width in px', 'teenglow-core' ),
					'dependency'  => array(
						'show' => array(
							'images_proportion' => array(
								'values'        => 'custom',
								'default_value' => 'full',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'custom_image_height',
					'title'       => esc_html__( 'Custom Image Height', 'teenglow-core' ),
					'description' => esc_html__( 'Enter image height in px', 'teenglow-core' ),
					'dependency'  => array(
						'show' => array(
							'images_proportion' => array(
								'values'        => 'custom',
								'default_value' => 'full',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'repeater',
					'name'       => 'children',
					'title'      => esc_html__( 'Image Items', 'teenglow-core' ),
					'items'      => array(
						array(
							'field_type' => 'image',
							'name'       => 'item_image',
							'title'      => esc_html__( 'Item Image', 'teenglow-core' ),
						),
						array(
							'field_type'    => 'select',
							'name'          => 'images_proportion',
							'default_value' => 'full',
							'title'         => esc_html__( 'Image Proportions', 'teenglow-core' ),
							'options'       => teenglow_core_get_select_type_options_pool( 'list_image_dimension', false ),
						),
						array(
							'field_type'  => 'text',
							'name'        => 'custom_image_width',
							'title'       => esc_html__( 'Custom Image Width', 'teenglow-core' ),
							'description' => esc_html__( 'Enter image width in px', 'teenglow-core' ),
							'dependency'  => array(
								'show' => array(
									'images_proportion' => array(
										'values'        => 'custom',
										'default_value' => 'full',
									),
								),
							),
						),
						array(
							'field_type'  => 'text',
							'name'        => 'custom_image_height',
							'title'       => esc_html__( 'Custom Image Height', 'teenglow-core' ),
							'description' => esc_html__( 'Enter image height in px', 'teenglow-core' ),
							'dependency'  => array(
								'show' => array(
									'images_proportion' => array(
										'values'        => 'custom',
										'default_value' => 'full',
									),
								),
							),
						),
						array(
							'field_type'    => 'select',
							'name'          => 'item_vertical_anchor',
							'title'         => esc_html__( 'Image Vertical Anchor', 'teenglow-core' ),
							'options'       => array(
								'top'    => esc_html__( 'Top', 'teenglow-core' ),
								'bottom' => esc_html__( 'Bottom', 'teenglow-core' ),
							),
							'default_value' => 'top',
						),
						array(
							'field_type'    => 'text',
							'name'          => 'item_vertical_position',
							'title'         => esc_html__( 'Image Vertical Position', 'teenglow-core' ),
							'default_value' => '25%',
						),
						array(
							'field_type'    => 'select',
							'name'          => 'item_horizontal_anchor',
							'title'         => esc_html__( 'Image Horizontal Anchor', 'teenglow-core' ),
							'options'       => array(
								'left'  => esc_html__( 'Left', 'teenglow-core' ),
								'right' => esc_html__( 'Right', 'teenglow-core' ),
							),
							'default_value' => 'left',
						),
						array(
							'field_type'    => 'text',
							'name'          => 'item_horizontal_position',
							'title'         => esc_html__( 'Image Horizontal Position', 'teenglow-core' ),
							'default_value' => '25%',
						),
						array(
							'field_type'    => 'text',
							'name'          => 'item_vertical_position_1440',
							'title'         => esc_html__( 'Image Vertical Position for LapTop (1440px)', 'teenglow-core' ),
							'default_value' => '',
						),
						array(
							'field_type'    => 'text',
							'name'          => 'item_vertical_position_1024',
							'title'         => esc_html__( 'Image Vertical Position for Touch Pad (1024px)', 'teenglow-core' ),
							'default_value' => '',
						),
						array(
							'field_type'    => 'text',
							'name'          => 'item_vertical_position_680',
							'title'         => esc_html__( 'Image Vertical Position for Phone (680px)', 'teenglow-core' ),
							'default_value' => '',
						),
						array(
							'field_type'    => 'text',
							'name'          => 'item_horizontal_position_1440',
							'title'         => esc_html__( 'Image Horizontal Position for LapTop (1440px)', 'teenglow-core' ),
							'default_value' => '',
						),
						array(
							'field_type'    => 'text',
							'name'          => 'item_horizontal_position_1024',
							'title'         => esc_html__( 'Image Horizontal Position for Touch Pad (1024px)', 'teenglow-core' ),
							'default_value' => '',
						),
						array(
							'field_type'    => 'text',
							'name'          => 'item_horizontal_position_680',
							'title'         => esc_html__( 'Image Horizontal Position for Phone (680px)', 'teenglow-core' ),
							'default_value' => '',
						),
					),
				)
			);
			$this->map_extra_options();
		}

		public static function call_shortcode( $params ) {
			$html = qode_framework_call_shortcode( 'teenglow_core_stacked_images', $params );
			$html = str_replace( "\n", '', $html );

			return $html;
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['item_classes']   = $this->get_item_classes( $atts );
			$atts['items']          = $this->parse_repeater_items( $atts['children'] );
			$this->set_responsive_styles( $atts );

			return teenglow_core_get_template_part( 'shortcodes/stacked-images', 'variations/' . $atts['layout'] . '/templates/' . $atts['layout'], '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-stacked-images';
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-layout--' . $atts['layout'] : '';

			return implode( ' ', $holder_classes );
		}

		public function get_item_classes( $atts ) {
			$item_classes = array();

			$item_classes[] = 'qodef-m-image';
			$item_classes[] = ! empty( $atts['parallax_item'] ) && ( 'yes' === $atts['parallax_item'] ) ? 'qodef-parallax-item' : '';

			return $item_classes;
		}

		private function set_responsive_styles( $atts ) {

			$items        = $atts['items'];
			$screen_sizes = array( '1440', '1024', '680' );

			if ( ! empty( $items ) ) {
				foreach ( $items as $item ) {
					$unique_class      = '.qodef-stacked-image-item--' . $item['_id'];
					$vertical_anchor   = $item['item_vertical_anchor'];
					$horizontal_anchor = $item['item_horizontal_anchor'];
					$styles            = array();

					foreach ( $screen_sizes as $screen_size ) {

						if ( qode_framework_string_ends_with_space_units( $item[ 'item_vertical_position_' . $screen_size ] ) ) {
							$styles[ $vertical_anchor ] = $item[ 'item_vertical_position_' . $screen_size ] . '!important';
						} else {
							$styles[ $vertical_anchor ] = intval( $item[ 'item_vertical_position_' . $screen_size ] ) . 'px !important';
						}

						if ( qode_framework_string_ends_with_space_units( $item[ 'item_horizontal_position_' . $screen_size ] ) ) {
							$styles[ $horizontal_anchor ] = $item[ 'item_horizontal_position_' . $screen_size ] . '!important';
						} else {
							$styles[ $horizontal_anchor ] = intval( $item[ 'item_horizontal_position_' . $screen_size ] ) . 'px !important';
						}

						if ( ! empty( $styles ) ) {
							add_filter(
								'teenglow_core_filter_add_responsive_' . $screen_size . '_inline_style_in_footer',
								function ( $style ) use ( $unique_class, $styles ) {
									$style .= qode_framework_dynamic_style( $unique_class, $styles );

									return $style;
								}
							);
						}
					}
				}
			}
		}
	}
}
