<?php

if ( ! function_exists( 'barabi_core_add_icon_list_item_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function barabi_core_add_icon_list_item_widget( $widgets ) {
		$widgets[] = 'BarabiCore_Icon_List_Item_Widget';

		return $widgets;
	}

	add_filter( 'barabi_core_filter_register_widgets', 'barabi_core_add_icon_list_item_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class BarabiCore_Icon_List_Item_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'barabi_core_icon_list_item',
					'exclude'        => array( 'icon_type', 'custom_icon' ),
				)
			);
			if ( $widget_mapped ) {
				$this->set_base( 'barabi_core_icon_list_item' );
				$this->set_name( esc_html__( 'Barabi Icon List Item', 'barabi-core' ) );
				$this->set_description( esc_html__( 'Add a icon list item element into widget areas', 'barabi-core' ) );
			}
		}

		public function render( $atts ) {
			echo BarabiCore_Icon_List_Item_Shortcode::call_shortcode( $atts ); // XSS OK
		}
	}
}
