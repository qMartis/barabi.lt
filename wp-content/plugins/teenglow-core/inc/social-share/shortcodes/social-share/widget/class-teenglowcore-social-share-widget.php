<?php

if ( ! function_exists( 'teenglow_core_add_social_share_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function teenglow_core_add_social_share_widget( $widgets ) {
		$widgets[] = 'TeenglowCore_Social_Share_Widget';

		return $widgets;
	}

	add_filter( 'teenglow_core_filter_register_widgets', 'teenglow_core_add_social_share_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class TeenglowCore_Social_Share_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'teenglow_core_social_share',
				)
			);

			if ( $widget_mapped ) {
				$this->set_base( 'teenglow_core_social_share' );
				$this->set_name( esc_html__( 'Teenglow Social Share', 'teenglow-core' ) );
				$this->set_description( esc_html__( 'Add a social share element into widget areas', 'teenglow-core' ) );
			}
		}

		public function render( $atts ) {
			echo TeenglowCore_Social_Share_Shortcode::call_shortcode( $atts ); // XSS OK
		}
	}
}
