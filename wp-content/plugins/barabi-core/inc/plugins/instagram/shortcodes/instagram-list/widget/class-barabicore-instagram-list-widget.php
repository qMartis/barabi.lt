<?php

if ( ! function_exists( 'barabi_core_add_instagram_list_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function barabi_core_add_instagram_list_widget( $widgets ) {
		if ( qode_framework_is_installed( 'instagram' ) ) {
			$widgets[] = 'BarabiCore_Instagram_List_Widget';
		}

		return $widgets;
	}

	add_filter( 'barabi_core_filter_register_widgets', 'barabi_core_add_instagram_list_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class BarabiCore_Instagram_List_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$this->set_widget_option(
				array(
					'field_type' => 'text',
					'name'       => 'widget_title',
					'title'      => esc_html__( 'Title', 'barabi-core' ),
				)
			);
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'barabi_core_instagram_list',
				)
			);

			if ( $widget_mapped ) {
				$this->set_base( 'barabi_core_instagram_list' );
				$this->set_name( esc_html__( 'Barabi Instagram List', 'barabi-core' ) );
				$this->set_description( esc_html__( 'Add a instagram list element into widget areas', 'barabi-core' ) );
			}
		}

		public function render( $atts ) {
			echo BarabiCore_Instagram_List_Shortcode::call_shortcode( $atts ); // XSS OK
		}
	}
}
