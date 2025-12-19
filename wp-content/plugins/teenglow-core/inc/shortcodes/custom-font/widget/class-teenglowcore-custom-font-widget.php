<?php

if ( ! function_exists( 'teenglow_core_add_custom_font_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function teenglow_core_add_custom_font_widget( $widgets ) {
		$widgets[] = 'TeenglowCore_Custom_Font_Widget';

		return $widgets;
	}

	add_filter( 'teenglow_core_filter_register_widgets', 'teenglow_core_add_custom_font_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class TeenglowCore_Custom_Font_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'teenglow_core_custom_font',
				)
			);
			if ( $widget_mapped ) {
				$this->set_base( 'teenglow_core_custom_font' );
				$this->set_name( esc_html__( 'Teenglow Custom Font', 'teenglow-core' ) );
				$this->set_description( esc_html__( 'Add a custom font element into widget areas', 'teenglow-core' ) );
			}
		}

		public function render( $atts ) {
			echo TeenglowCore_Custom_Font_Shortcode::call_shortcode( $atts ); // XSS OK
		}
	}
}
