<?php

if ( ! function_exists( 'teenglow_core_add_textual_list_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function teenglow_core_add_textual_list_shortcode( $shortcodes ) {
		$shortcodes[] = 'TeenglowCore_Textual_List_Shortcode';

		return $shortcodes;
	}

	add_filter( 'teenglow_core_filter_register_shortcodes', 'teenglow_core_add_textual_list_shortcode' );
}

if ( class_exists( 'TeenglowCore_Shortcode' ) ) {
	class TeenglowCore_Textual_List_Shortcode extends TeenglowCore_Shortcode {

		public function map_shortcode() {
			$this->set_shortcode_path( TEENGLOW_CORE_SHORTCODES_URL_PATH . '/textual-list' );
			$this->set_base( 'teenglow_core_textual_list' );
			$this->set_name( esc_html__( 'Textual List', 'teenglow-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds textual list', 'teenglow-core' ) );
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
					'name'          => 'title_tag',
					'title'         => esc_html__( 'Title Tag', 'teenglow-core' ),
					'default_value' => '',
					'options'       => teenglow_core_get_select_type_options_pool( 'title_tag' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'enable_icon',
					'title'         => esc_html__( 'Enable Icon', 'teenglow-core' ),
					'default_value' => 'yes',
					'options'       => teenglow_core_get_select_type_options_pool( 'yes_no', false ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'space_between_items',
					'title'      => esc_html__( 'Space Between Items', 'teenglow-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'repeater',
					'name'       => 'children',
					'title'      => esc_html__( 'Items', 'teenglow-core' ),
					'items'      => array(
						array(
							'field_type'    => 'text',
							'name'          => 'title',
							'title'         => esc_html__( 'Title', 'teenglow-core' ),
							'default_value' => '',
						),
						array(
							'field_type'    => 'text',
							'name'          => 'text',
							'title'         => esc_html__( 'Text', 'teenglow-core' ),
							'default_value' => '',
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'outro_text',
					'title'      => esc_html__( 'Outro Text', 'teenglow-core' ),
				)
			);
			$this->map_extra_options();
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes();
			$atts['holder_styles']  = $this->get_holder_styles( $atts );
			$atts['items']          = $this->parse_repeater_items( $atts['children'] );

			return teenglow_core_get_template_part( 'shortcodes/textual-list', 'templates/textual-list', '', $atts );
		}

		private function get_holder_classes() {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-textual-list';

			return implode( ' ', $holder_classes );
		}

		private function get_holder_styles( $atts ) {
			$styles = array();

			$gap = $atts['space_between_items'];
			if ( ! empty( $gap ) ) {
				if ( qode_framework_string_ends_with_typography_units( $gap ) ) {
					$styles[] = '--qodef-space-between-items: ' . $gap;
				} else {
					$styles[] = '--qodef-space-between-items: ' . intval( $gap ) . 'px';
				}
			}

			return $styles;
		}
	}
}
