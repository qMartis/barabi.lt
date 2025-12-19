<?php

if ( ! function_exists( 'barabi_core_add_twitter_list_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function barabi_core_add_twitter_list_widget( $widgets ) {
		if ( qode_framework_is_installed( 'twitter' ) ) {
			$widgets[] = 'BarabiCore_Twitter_List_Widget';
		}

		return $widgets;
	}

	add_filter( 'barabi_core_filter_register_widgets', 'barabi_core_add_twitter_list_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class BarabiCore_Twitter_List_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$this->set_widget_option(
				array(
					'name'       => 'widget_title',
					'field_type' => 'text',
					'title'      => esc_html__( 'Title', 'barabi-core' ),
				)
			);
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'barabi_core_twitter_list',
				)
			);
			if ( $widget_mapped ) {
				$this->set_base( 'barabi_core_twitter_list' );
				$this->set_name( esc_html__( 'Barabi Twitter List', 'barabi-core' ) );
				$this->set_description( esc_html__( 'Add a twitter list element into widget areas', 'barabi-core' ) );
			}
		}

		public function render( $atts ) {
			echo BarabiCore_Twitter_List_Shortcode::call_shortcode( $atts ); // XSS OK
		}
	}
}
