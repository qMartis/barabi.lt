<?php

if ( ! function_exists( 'barabi_core_add_single_image_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function barabi_core_add_single_image_widget( $widgets ) {
		$widgets[] = 'BarabiCore_Single_Image_Widget';

		return $widgets;
	}

	add_filter( 'barabi_core_filter_register_widgets', 'barabi_core_add_single_image_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class BarabiCore_Single_Image_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'barabi_core_single_image',
					'exclude'        => array( 'custom_class', 'parallax_item' ),
				)
			);
			if ( $widget_mapped ) {
				$this->set_base( 'barabi_core_single_image' );
				$this->set_name( esc_html__( 'Barabi Single Image', 'barabi-core' ) );
				$this->set_description( esc_html__( 'Add a single image element into widget areas', 'barabi-core' ) );
			}
		}

		public function render( $atts ) {
			echo BarabiCore_Single_Image_Shortcode::call_shortcode( $atts ); // XSS OK
		}
	}
}
