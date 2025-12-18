<?php

if ( ! function_exists( 'teenglow_core_add_icon_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function teenglow_core_add_icon_widget( $widgets ) {
		$widgets[] = 'TeenglowCore_Icon_Widget';

		return $widgets;
	}

	add_filter( 'teenglow_core_filter_register_widgets', 'teenglow_core_add_icon_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class TeenglowCore_Icon_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'teenglow_core_icon',
				)
			);

			if ( $widget_mapped ) {
				$this->set_base( 'teenglow_core_icon' );
				$this->set_name( esc_html__( 'Teenglow Icon', 'teenglow-core' ) );
				$this->set_description( esc_html__( 'Add a icon element into widget areas', 'teenglow-core' ) );
			}
		}

		public function render( $atts ) {
			echo TeenglowCore_Icon_Shortcode::call_shortcode( $atts ); // XSS OK
		}
	}
}
