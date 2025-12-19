<?php

if ( ! function_exists( 'barabi_core_add_video_slider_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function barabi_core_add_video_slider_shortcode( $shortcodes ) {
		$shortcodes[] = 'BarabiCore_Video_Slider_Shortcode';

		return $shortcodes;
	}

	add_filter( 'barabi_core_filter_register_shortcodes', 'barabi_core_add_video_slider_shortcode' );
}

if ( class_exists( 'BarabiCore_List_Shortcode' ) ) {
	class BarabiCore_Video_Slider_Shortcode extends BarabiCore_List_Shortcode {

		public function map_shortcode() {
			$this->set_shortcode_path( BARABI_CORE_SHORTCODES_URL_PATH . '/video-slider' );
			$this->set_base( 'barabi_core_video_slider' );
			$this->set_name( esc_html__( 'Video Slider', 'barabi-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds video slider element', 'barabi-core' ) );
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'repeater',
					'name'       => 'children',
					'title'      => esc_html__( 'Image Items', 'barabi-core' ),
					'items'      => array(
						array(
							'field_type'  => 'text',
							'name'        => 'item_video_url',
							'title'       => esc_html__( 'Video URL', 'barabi-core' ),
						),
						array(
							'field_type'  => 'text',
							'name'        => 'item_link',
							'title'       => esc_html__( 'Item Link', 'barabi-core' ),
						),
						array(
							'field_type'  => 'select',
							'name'        => 'item_link_target',
							'title'       => esc_html__( 'Item Link Target', 'barabi-core' ),
							'options'     => barabi_core_get_select_type_options_pool( 'link_target' )
						),
					),
				)
			);
			$this->map_list_options(
				array(
					'exclude_behavior'      => array( 'columns', 'masonry', 'justified-gallery' ),
					'exclude_option'        => array( 'images_proportion' ),
					'group'                 => esc_html__( 'Slider Settings', 'barabi-core' ),
					'include_slider_option' => array(
						'slider_centered_slides',
						'slider_drag_cursor',
					),
				)
			);
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['holder_styles']  = $this->get_holder_styles( $atts );
			$atts['item_classes']   = $this->get_item_classes( $atts );
			$atts['slider_attr']    = $this->get_slider_data( $atts );
			$atts['items']          = $this->parse_repeater_items( $atts['children'] );

			return barabi_core_get_template_part( 'shortcodes/video-slider', 'templates/video-slider', '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-video-slider';

			$list_classes   = $this->get_list_classes( $atts );
			$holder_classes = array_merge( $holder_classes, $list_classes );

			return implode( ' ', $holder_classes );
		}

		private function get_holder_styles( $atts ) {
			$holder_styles = array();

			$list_styles   = $this->get_list_styles( $atts );
			$holder_styles = array_merge( $holder_styles, $list_styles );

			return $holder_styles;
		}

		public function get_item_classes( $atts ) {
			$item_classes   = $this->init_item_classes();
			$item_classes[] = 'qodef-video-wrapper';

			$list_item_classes = $this->get_list_item_classes( $atts );

			$item_classes = array_merge( $item_classes, $list_item_classes );

			return implode( ' ', $item_classes );
		}
	}
}
