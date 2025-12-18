<?php

if ( ! function_exists( 'teenglow_core_add_single_image_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function teenglow_core_add_single_image_widget( $widgets ) {
		$widgets[] = 'TeenglowCore_Single_Image_Widget';

		return $widgets;
	}

	add_filter( 'teenglow_core_filter_register_widgets', 'teenglow_core_add_single_image_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class TeenglowCore_Single_Image_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'teenglow_core_single_image',
					'exclude'        => array( 'custom_class', 'parallax_item' ),
				)
			);
			if ( $widget_mapped ) {
				$this->set_base( 'teenglow_core_single_image' );
				$this->set_name( esc_html__( 'Teenglow Single Image', 'teenglow-core' ) );
				$this->set_description( esc_html__( 'Add a single image element into widget areas', 'teenglow-core' ) );
			}
		}

		public function render( $atts ) {
			echo TeenglowCore_Single_Image_Shortcode::call_shortcode( $atts ); // XSS OK
		}
	}
}
