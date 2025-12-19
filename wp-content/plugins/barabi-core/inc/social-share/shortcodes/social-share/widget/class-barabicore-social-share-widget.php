<?php

if ( ! function_exists( 'barabi_core_add_social_share_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function barabi_core_add_social_share_widget( $widgets ) {
		$widgets[] = 'BarabiCore_Social_Share_Widget';

		return $widgets;
	}

	add_filter( 'barabi_core_filter_register_widgets', 'barabi_core_add_social_share_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class BarabiCore_Social_Share_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'barabi_core_social_share',
				)
			);

			if ( $widget_mapped ) {
				$this->set_base( 'barabi_core_social_share' );
				$this->set_name( esc_html__( 'Barabi Social Share', 'barabi-core' ) );
				$this->set_description( esc_html__( 'Add a social share element into widget areas', 'barabi-core' ) );
			}
		}

		public function render( $atts ) {
			echo BarabiCore_Social_Share_Shortcode::call_shortcode( $atts ); // XSS OK
		}
	}
}
