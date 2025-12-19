<?php

if ( ! function_exists( 'teenglow_core_add_instagram_list_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function teenglow_core_add_instagram_list_widget( $widgets ) {
		if ( qode_framework_is_installed( 'instagram' ) ) {
			$widgets[] = 'TeenglowCore_Instagram_List_Widget';
		}

		return $widgets;
	}

	add_filter( 'teenglow_core_filter_register_widgets', 'teenglow_core_add_instagram_list_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class TeenglowCore_Instagram_List_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$this->set_widget_option(
				array(
					'field_type' => 'text',
					'name'       => 'widget_title',
					'title'      => esc_html__( 'Title', 'teenglow-core' ),
				)
			);
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'teenglow_core_instagram_list',
				)
			);

			if ( $widget_mapped ) {
				$this->set_base( 'teenglow_core_instagram_list' );
				$this->set_name( esc_html__( 'Teenglow Instagram List', 'teenglow-core' ) );
				$this->set_description( esc_html__( 'Add a instagram list element into widget areas', 'teenglow-core' ) );
			}
		}

		public function render( $atts ) {
			echo TeenglowCore_Instagram_List_Shortcode::call_shortcode( $atts ); // XSS OK
		}
	}
}
