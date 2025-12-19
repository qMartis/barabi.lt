<?php

if ( ! function_exists( 'teenglow_core_add_subscribe_button_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function teenglow_core_add_subscribe_button_shortcode( $shortcodes ) {
		$shortcodes[] = 'TeenglowCore_Subscribe_Button_Shortcode';

		return $shortcodes;
	}

	add_filter( 'teenglow_core_filter_register_shortcodes', 'teenglow_core_add_subscribe_button_shortcode' );
}

if ( class_exists( 'TeenglowCore_Shortcode' ) ) {
	class TeenglowCore_Subscribe_Button_Shortcode extends TeenglowCore_Shortcode {

		public function __construct() {
			$this->set_layouts( apply_filters( 'teenglow_core_filter_subscribe_button_layouts', array() ) );
			$this->set_extra_options( apply_filters( 'teenglow_core_filter_subscribe_button_extra_options', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( TEENGLOW_CORE_INC_URL_PATH . '/subscribe-popup/shortcodes/subscribe-button' );
			$this->set_base( 'teenglow_core_subscribe_button' );
			$this->set_name( esc_html__( 'Subscribe Popup Button', 'teenglow-core' ) );
			$this->set_description( esc_html__( 'Shortcode that displays subscribe button (subscribe popup has to be enabled in options)', 'teenglow-core' ) );
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'teenglow-core' ),
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
					'visibility'    => array(
						'map_for_page_builder' => $options_map['visibility'],
						'map_for_widget'       => $options_map['visibility'],
					),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'prevent_opening',
					'title'         => esc_html__( 'Prevent Opening', 'teenglow-core' ),
					'description'   => esc_html__( 'Prevent opening of subscribe popup on page load', 'teenglow-core' ),
					'options'       => teenglow_core_get_select_type_options_pool( 'no_yes', false ),
					'default_value' => 'no',
				)
			);
			$this->map_extra_options();
		}

		public static function call_shortcode( $params ) {
			$html = qode_framework_call_shortcode( 'teenglow_core_subscribe_button', $params );
			$html = str_replace( "\n", '', $html );

			return $html;
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes( $atts );

			return teenglow_core_get_template_part( 'subscribe-popup/shortcodes/subscribe-button', 'variations/' . $atts['layout'] . '/templates/' . $atts['layout'], '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-subscribe-button';
			$holder_classes[] = 'clear';
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-layout--' . $atts['layout'] : '';
			$holder_classes[] = ! empty( $atts['prevent_opening'] ) ? 'qodef-sp-prevent--' . $atts['prevent_opening'] : '';

			return implode( ' ', $holder_classes );
		}
	}
}
