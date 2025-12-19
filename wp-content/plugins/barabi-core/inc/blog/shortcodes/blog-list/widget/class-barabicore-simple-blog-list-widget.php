<?php

if ( ! function_exists( 'barabi_core_add_simple_blog_list_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function barabi_core_add_simple_blog_list_widget( $widgets ) {
		$widgets[] = 'BarabiCore_Simple_Blog_List_Widget';

		return $widgets;
	}

	add_filter( 'barabi_core_filter_register_widgets', 'barabi_core_add_simple_blog_list_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class BarabiCore_Simple_Blog_List_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$this->set_widget_option(
				array(
					'field_type' => 'text',
					'name'       => 'widget_title',
					'title'      => esc_html__( 'Title', 'barabi-core' ),
				)
			);

			$this->set_widget_option(
				array(
					'field_type' => 'select',
					'name'       => 'layout',
					'title'      => esc_html__( 'Item Layout', 'barabi-core' ),
					'options'    => apply_filters( 'barabi_core_filter_simple_blog_list_widget_layouts', array() ),
				)
			);

			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'barabi_core_blog_list',
					'exclude'        => array(
						'custom_class',
						'behavior',
						'space',
						'vertical_space',
						'masonry_images_proportion',
						'images_proportion',
						'custom_image_width',
						'custom_image_height',
						'columns',
						'columns_responsive',
						'columns_1440',
						'columns_1366',
						'columns_1024',
						'columns_768',
						'columns_680',
						'columns_480',
						'slider_loop',
						'slider_autoplay',
						'slider_speed',
						'slider_speed_animation',
						'slider_navigation',
						'slider_pagination',
						'layout',
						'excerpt_length',
						'enable_filter',
						'pagination_type',
						'pagination_top_margin',
					),
				)
			);

			if ( $widget_mapped ) {
				$this->set_base( 'barabi_core_simple_blog_list' );
				$this->set_name( esc_html__( 'Barabi Simple Blog List', 'barabi-core' ) );
				$this->set_description( esc_html__( 'Display a list of blog posts', 'barabi-core' ) );
			}
		}

		public function render( $atts ) {
			$atts['is_widget_element'] = 'yes';

			// force atts
			$atts['behavior']           = 'columns';
			$atts['space']              = 'no'; // spacing inherited from widgets map
			$atts['vertical_space']     = 'no'; // spacing inherited from widgets map
			$atts['images_proportion']  = 'full';
			$atts['columns']            = 1;
			$atts['columns_responsive'] = 'predefined';

			echo BarabiCore_Blog_List_Shortcode::call_shortcode( $atts ); // XSS OK
		}
	}
}
