<?php

if ( ! function_exists( 'barabi_core_add_simple_slider_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function barabi_core_add_simple_slider_shortcode( $shortcodes ) {
		$shortcodes[] = 'BarabiCore_Simple_Slider_Shortcode';

		return $shortcodes;
	}

	add_filter( 'barabi_core_filter_register_shortcodes', 'barabi_core_add_simple_slider_shortcode' );
}

if ( class_exists( 'BarabiCore_List_Shortcode' ) ) {
	class BarabiCore_Simple_Slider_Shortcode extends BarabiCore_Shortcode {

		public function map_shortcode() {
			$this->set_shortcode_path( BARABI_CORE_SHORTCODES_URL_PATH . '/simple-slider' );
			$this->set_base( 'barabi_core_simple_slider' );
			$this->set_name( esc_html__( 'Simple Slider', 'barabi-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds simple slider element', 'barabi-core' ) );
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'barabi-core' ),
				)
			);

			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'static_title',
					'title'      => esc_html__( 'Static Title', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'static_title_tag',
					'title'         => esc_html__( 'Static Title Tag', 'barabi-core' ),
					'options'       => barabi_core_get_select_type_options_pool( 'title_tag', false ),
					'default_value' => 'h2',
				)
			);

			$this->set_option(
				array(
					'field_type' => 'repeater',
					'name'       => 'children',
					'title'      => esc_html__( 'Child elements', 'barabi-core' ),
					'items'      => array(
						array(
							'field_type' => 'image',
							'name'       => 'item_image',
							'title'      => esc_html__( 'Image', 'barabi-core' ),
						),
						array(
							'field_type' => 'text',
							'name'       => 'item_title',
							'title'      => esc_html__( 'Title', 'barabi-core' ),
						),
						array(
							'field_type' => 'text',
							'name'       => 'item_link',
							'title'      => esc_html__( 'Link', 'barabi-core' ),
						),
						array(
							'field_type'    => 'select',
							'name'          => 'item_target',
							'title'         => esc_html__( 'Target', 'barabi-core' ),
							'options'       => barabi_core_get_select_type_options_pool( 'link_target', false ),
							'default_value' => '_blank'
						),
					),
				)
			);

			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'columns',
					'title'         => esc_html__( 'Number of Columns', 'barabi-core' ),
					'options'       => barabi_core_get_select_type_options_pool( 'columns_number' ),
					'default_value' => '4',
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'columns_mobile',
					'title'         => esc_html__( 'Number of Columns on Mobile', 'barabi-core' ),
					'options'       => barabi_core_get_select_type_options_pool( 'columns_number' ),
					'default_value' => '',
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'space_between_items',
					'title'         => esc_html__( 'Space Between Items', 'barabi-core' ),
					'options'       => barabi_core_get_select_type_options_pool( 'items_space' ),
					'default_value' => 'normal',
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'space_between_items_mobile',
					'title'         => esc_html__( 'Space Between Items on Mobile', 'barabi-core' ),
					'options'       => barabi_core_get_select_type_options_pool( 'items_space' ),
					'default_value' => '',
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'partial_columns',
					'title'      => esc_html__( 'Enable Partial Columns', 'barabi-core' ),
					'options'    => barabi_core_get_select_type_options_pool( 'no_yes', false ),
				)
			);

			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'partial_columns_value',
					'title'       => esc_html__( 'Partial Columns Value', 'barabi-core' ),
					'description' => esc_html__( 'Value can be between 0 and 1', 'barabi-core' ),
					'dependency'  => array(
						'show' => array(
							'partial_columns' => array(
								'values'        => 'yes',
								'default_value' => 'no',
							),
						),
					),
				)
			);

			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'centered_slides',
					'title'      => esc_html__( 'Centered Slides', 'barabi-core' ),
					'options'    => barabi_core_get_select_type_options_pool( 'no_yes', false ),
				)
			);

			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'slider_loop',
					'title'      => esc_html__( 'Enable Slider Loop', 'barabi-core' ),
					'options'    => barabi_core_get_select_type_options_pool( 'yes_no' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'slider_autoplay',
					'title'      => esc_html__( 'Enable Slider Autoplay', 'barabi-core' ),
					'options'    => barabi_core_get_select_type_options_pool( 'yes_no' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'slider_speed',
					'title'       => esc_html__( 'Slide Duration', 'barabi-core' ),
					'description' => esc_html__( 'Default value is 5000 (ms)', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'slider_speed_animation',
					'title'       => esc_html__( 'Slide Animation Duration', 'barabi-core' ),
					'description' => esc_html__( 'Speed of slide animation in milliseconds. Default value is 800.', 'barabi-core' ),
				)
			);
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['slider_pagination'] = 'no';
			$atts['slider_navigation'] = 'yes';

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['item_classes']   = $this->get_item_classes( $atts );
			$atts['slider_attr']    = $this->get_slider_data( $atts );
			$atts['items']          = $this->parse_repeater_items( $atts['children'] );

			return barabi_core_get_template_part( 'shortcodes/simple-slider', 'templates/simple-slider', '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-simple-slider';
			$holder_classes[] = 'qodef-swiper-container';

			return implode( ' ', $holder_classes );
		}

		public function get_item_classes( $atts ) {
			$item_classes = $this->init_item_classes();

			$item_classes[] = 'qodef-e';
			$item_classes[] = 'swiper-slide';

			return implode( ' ', $item_classes );
		}

		public function get_slider_data( $atts ) {
			$data = array();

			$data['slidesPerView']    = $atts['columns'];
			$data['slidesPerView680'] = ! empty( $atts['columns_mobile'] ) ? $atts['columns_mobile'] : $atts['columns'];
			if ( $atts['partial_columns'] === 'yes' && $atts['partial_columns_value'] !== '' ) {
				$data['partialValue'] = floatval( $atts['partial_columns_value'] );
			}

			$data['spaceBetween']    = isset( $atts['space_between_items'] ) ? ( barabi_core_get_space_value( $atts['space_between_items'] ) * 2 ) : 0; // double half space for slider
			$data['spaceBetween680'] = ! empty( $atts['space_between_items_mobile'] ) ? ( barabi_core_get_space_value( $atts['space_between_items_mobile'] ) * 2 ) : $data['spaceBetween']; // double half space for slider
			$data['loop']            = isset( $atts['slider_loop'] ) ? 'no' !== $atts['slider_loop'] : true;
			$data['centeredSlides']  = isset( $atts['centered_slides'] ) ? 'no' !== $atts['centered_slides'] : true;
			$data['autoplay']        = isset( $atts['slider_autoplay'] ) ? 'no' !== $atts['slider_autoplay'] : true;
			$data['speed']           = isset( $atts['slider_speed'] ) ? $atts['slider_speed'] : '';
			$data['speedAnimation']  = isset( $atts['slider_speed_animation'] ) ? $atts['slider_speed_animation'] : '';

			return json_encode( $data );
		}
	}
}
