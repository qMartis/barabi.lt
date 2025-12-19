<?php

if ( ! function_exists( 'barabi_core_add_textual_list_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function barabi_core_add_textual_list_shortcode( $shortcodes ) {
		$shortcodes[] = 'BarabiCore_Textual_List_Shortcode';

		return $shortcodes;
	}

	add_filter( 'barabi_core_filter_register_shortcodes', 'barabi_core_add_textual_list_shortcode' );
}

if ( class_exists( 'BarabiCore_Shortcode' ) ) {
	class BarabiCore_Textual_List_Shortcode extends BarabiCore_Shortcode {

		public function map_shortcode() {
			$this->set_shortcode_path( BARABI_CORE_SHORTCODES_URL_PATH . '/textual-list' );
			$this->set_base( 'barabi_core_textual_list' );
			$this->set_name( esc_html__( 'Textual List', 'barabi-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds textual list', 'barabi-core' ) );
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'title_tag',
					'title'         => esc_html__( 'Title Tag', 'barabi-core' ),
					'default_value' => '',
					'options'       => barabi_core_get_select_type_options_pool( 'title_tag' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'enable_icon',
					'title'         => esc_html__( 'Enable Icon', 'barabi-core' ),
					'default_value' => 'yes',
					'options'       => barabi_core_get_select_type_options_pool( 'yes_no', false ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'space_between_items',
					'title'      => esc_html__( 'Space Between Items', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'repeater',
					'name'       => 'children',
					'title'      => esc_html__( 'Items', 'barabi-core' ),
					'items'      => array(
						array(
							'field_type'    => 'text',
							'name'          => 'title',
							'title'         => esc_html__( 'Title', 'barabi-core' ),
							'default_value' => '',
						),
						array(
							'field_type'    => 'text',
							'name'          => 'text',
							'title'         => esc_html__( 'Text', 'barabi-core' ),
							'default_value' => '',
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'outro_text',
					'title'      => esc_html__( 'Outro Text', 'barabi-core' ),
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

			return barabi_core_get_template_part( 'shortcodes/textual-list', 'templates/textual-list', '', $atts );
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
