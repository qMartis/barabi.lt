<?php

if ( ! function_exists( 'teenglow_core_add_split_showcase_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function teenglow_core_add_split_showcase_shortcode( $shortcodes ) {
		$shortcodes[] = 'TeenglowCore_SplitShowcase_Shortcode';

		return $shortcodes;
	}

	add_filter( 'teenglow_core_filter_register_shortcodes', 'teenglow_core_add_split_showcase_shortcode' );
}

if ( class_exists( 'TeenglowCore_Shortcode' ) ) {
	class TeenglowCore_SplitShowcase_Shortcode extends TeenglowCore_Shortcode {

		public function map_shortcode() {
			$this->set_shortcode_path( TEENGLOW_CORE_SHORTCODES_URL_PATH . '/split-showcase' );
			$this->set_base( 'teenglow_core_split_showcase' );
			$this->set_name( esc_html__( 'Split Showcase', 'teenglow-core' ) );
			$this->set_description( esc_html__( 'Shortcode that displays split showcase with provided parameters', 'teenglow-core' ) );
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'teenglow-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'skin',
					'title'      => esc_html__( 'Skin', 'teenglow-core' ),
					'options'    => teenglow_core_get_select_type_options_pool( 'shortcode_skin' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'image',
					'name'       => 'left_bg_image',
					'title'      => esc_html__( 'Left Background Image', 'teenglow-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'image',
					'name'       => 'left_main_image',
					'title'      => esc_html__( 'Left Main Image', 'teenglow-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'image',
					'name'       => 'right_bg_image',
					'title'      => esc_html__( 'Right Background Image', 'teenglow-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'title',
					'title'      => esc_html__( 'Right Section Title', 'teenglow-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'button_text',
					'title'      => esc_html__( 'Button Text', 'teenglow-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'button_link',
					'title'      => esc_html__( 'Button Link', 'teenglow-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'button_target',
					'title'         => esc_html__( 'Button Target', 'teenglow-core' ),
					'default_value' => '',
					'options'       => teenglow_core_get_select_type_options_pool( 'link_target' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textarea',
					'name'       => 'text',
					'title'      => esc_html__( 'Right Section Text', 'teenglow-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'repeater',
					'name'       => 'children',
					'title'      => esc_html__( 'Features', 'teenglow-core' ),
					'items'      => array(
						array(
							'field_type' => 'text',
							'name'       => 'item_title',
							'title'      => esc_html__( 'Title', 'teenglow-core' ),
						),
					),
				)
			);
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes']       = $this->get_holder_classes( $atts );
			$atts['left_section_styles']  = $this->get_left_section_styles( $atts );
			$atts['right_section_styles'] = $this->get_right_section_styles( $atts );
			$atts['features']             = $this->parse_repeater_items( $atts['children'] );

			return teenglow_core_get_template_part( 'shortcodes/split-showcase', 'templates/split-showcase', '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-split-showcase';
			$holder_classes[] = ! empty( $atts['skin'] ) ? 'qodef-skin--' . $atts['skin'] : '';

			return implode( ' ', $holder_classes );
		}

		private function get_left_section_styles( $atts ) {
			$styles = array();

			$styles[] = ! empty( $atts['left_bg_image'] ) ? 'background-image: url(' . wp_get_attachment_url( $atts['left_bg_image'] ) . ')' : '';

			return $styles;
		}

		private function get_right_section_styles( $atts ) {
			$styles = array();

			$styles[] = ! empty( $atts['right_bg_image'] ) ? 'background-image: url(' . wp_get_attachment_url( $atts['right_bg_image'] ) . ')' : '';

			return $styles;
		}
	}
}
