<?php

if ( ! function_exists( 'teenglow_core_add_tutorial_info_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function teenglow_core_add_tutorial_info_shortcode( $shortcodes ) {
		$shortcodes[] = 'TeenglowCore_Tutorial_Info_Shortcode';

		return $shortcodes;
	}

	add_filter( 'teenglow_core_filter_register_shortcodes', 'teenglow_core_add_tutorial_info_shortcode' );
}

if ( class_exists( 'TeenglowCore_Shortcode' ) ) {
	class TeenglowCore_Tutorial_Info_Shortcode extends TeenglowCore_Shortcode {

		public function __construct() {
			$this->set_layouts( apply_filters( 'teenglow_core_filter_tutorial_info_layouts', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( TEENGLOW_CORE_CPT_URL_PATH . '/tutorial/shortcodes/tutorial-info' );
			$this->set_base( 'teenglow_core_tutorial_info' );
			$this->set_name( esc_html__( 'Tutorial Info', 'teenglow-core' ) );
			$this->set_description( esc_html__( 'Shortcode that display tutorial info', 'teenglow-core' ) );
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
					'name'       => 'tutorial_id',
					'title'      => esc_html__( 'Tutorial Item', 'teenglow-core' ),
					'options'    => qode_framework_get_cpt_items( 'tutorial', '', true ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'title_tag',
					'title'         => esc_html__( 'Title Tag', 'teenglow-core' ),
					'options'       => teenglow_core_get_select_type_options_pool( 'title_tag' ),
					'default_value' => '',
				)
			);
		}

		public function render( $options, $content = null ) {
			parent::render( $options );

			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['project_id']     = ! empty( $atts['tutorial_id'] ) ? $atts['tutorial_id'] : get_the_ID();
			$atts['this_shortcode'] = $this;

			return teenglow_core_get_template_part( 'post-types/tutorial/shortcodes/tutorial-info', 'templates/content', '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-tutorial-info';

			return implode( ' ', $holder_classes );
		}
	}
}
