<?php

if ( ! function_exists( 'barabi_core_add_testimonials_list_shortcode' ) ) {
	/**
	 * Function that is adding shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes - Array of registered shortcodes
	 *
	 * @return array
	 */
	function barabi_core_add_testimonials_list_shortcode( $shortcodes ) {
		$shortcodes[] = 'BarabiCore_Testimonials_List_Shortcode';

		return $shortcodes;
	}

	add_filter( 'barabi_core_filter_register_shortcodes', 'barabi_core_add_testimonials_list_shortcode' );
}

if ( class_exists( 'BarabiCore_List_Shortcode' ) ) {
	class BarabiCore_Testimonials_List_Shortcode extends BarabiCore_List_Shortcode {

		public function __construct() {
			$this->set_post_type( 'testimonials' );
			$this->set_post_type_additional_taxonomies( array( 'testimonials-category' ) );
			$this->set_layouts( apply_filters( 'barabi_core_filter_testimonials_list_layouts', array() ) );
			$this->set_extra_options( apply_filters( 'barabi_core_filter_testimonials_list_extra_options', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( BARABI_CORE_CPT_URL_PATH . '/testimonials/shortcodes/testimonials-list' );
			$this->set_base( 'barabi_core_testimonials_list' );
			$this->set_name( esc_html__( 'Testimonials List', 'barabi-core' ) );
			$this->set_description( esc_html__( 'Shortcode that displays list of testimonials', 'barabi-core' ) );
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'barabi-core' ),
				)
			);
			$this->map_list_options(
				array(
					'exclude_behavior' => array( 'masonry', 'justified-gallery' ),
					'exclude_option'   => array( 'images_proportion' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'skin',
					'title'      => esc_html__( 'Skin', 'barabi-core' ),
					'options'    => barabi_core_get_select_type_options_pool( 'shortcode_skin' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'static_title',
					'title'      => esc_html__( 'Static Title', 'barabi-core' ),
					'group'      => esc_html__( 'Layout', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'static_title_tag',
					'title'         => esc_html__( 'Static Title Tag', 'barabi-core' ),
					'options'       => barabi_core_get_select_type_options_pool( 'title_tag', false ),
					'default_value' => 'h2',
					'group'         => esc_html__( 'Layout', 'barabi-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'slider_centered_slides',
					'title'      => esc_html__( 'Center Slider', 'barabi-core' ),
					'options'    => barabi_core_get_select_type_options_pool( 'yes_no', false ),
					'dependency' => array(
						'show' => array(
							'behavior' => array(
								'values'        => 'slider',
								'default_value' => '',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'partial_columns',
					'title'      => esc_html__( 'Enable Partial Columns', 'barabi-core' ),
					'options'    => barabi_core_get_select_type_options_pool( 'no_yes', false ),
					'dependency' => array(
						'show' => array(
							'behavior' => array(
								'values'        => 'slider',
								'default_value' => '',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'partial_columns_value',
					'title'       => esc_html__( 'Partial Columns Value', 'barabi-core' ),
					'description' => esc_html__( 'Value can be between 0 and 1', 'barabi-core' ),
					'dependency'  => array(
						'show' => array(
							'partial_columns' => array(
								'values'        => 'yes',
								'default_value' => 'no',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'show_average_rating_info',
					'title'         => esc_html__( 'Show Average Rating Information', 'barabi-core' ),
					'options'       => barabi_core_get_select_type_options_pool( 'yes_no', false ),
					'default_value' => 'yes',
					'dependency'    => array(
						'show' => array(
							'layout' => array(
								'values'        => 'info-below',
								'default_value' => '',
							),
						),
					),
				)
			);
			$this->map_query_options( array( 'post_type' => $this->get_post_type() ) );
			$this->map_layout_options( array( 'layouts' => $this->get_layouts() ) );
			$this->map_extra_options();
		}

		public static function call_shortcode( $params ) {
			$html = qode_framework_call_shortcode( 'barabi_core_testimonials_list', $params );
			$html = str_replace( "\n", '', $html );

			return $html;
		}

		public function render( $options, $content = null ) {
			parent::render( $options );

			$atts = $this->get_atts();

			$atts['post_type'] = $this->get_post_type();

			// Additional query args
			$atts['additional_query_args'] = $this->get_additional_query_args( $atts );

			if ( $atts['partial_columns'] === 'yes' && $atts['partial_columns_value'] !== '' ) {
				$atts['columns'] = intval( $atts['columns'] ) + floatval( $atts['partial_columns_value'] );

				if ( $atts['columns_responsive'] === 'custom' ) {

					$atts['columns_1440'] = intval( $atts['columns_1440'] ) + floatval( $atts['partial_columns_value'] );
					$atts['columns_1366'] = intval( $atts['columns_1366'] ) + floatval( $atts['partial_columns_value'] );
					$atts['columns_1024'] = intval( $atts['columns_1024'] ) + floatval( $atts['partial_columns_value'] );
					$atts['columns_768']  = intval( $atts['columns_768'] ) + floatval( $atts['partial_columns_value'] );
					$atts['columns_680']  = intval( $atts['columns_680'] ) + floatval( $atts['partial_columns_value'] );
					$atts['columns_480']  = intval( $atts['columns_480'] ) + floatval( $atts['partial_columns_value'] );
				}
			}

			$atts['unique'] = rand( 0, 1000 );

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['holder_styles']  = $this->get_holder_styles( $atts );
			$atts['item_classes']   = $this->get_item_classes( $atts );
			$atts['slider_attr']    = $this->get_slider_data(
				$atts,
				array(
					'partialColumn'  => $atts['partial_columns_value'],
					'paginationType' => 'fraction',
				)
			);
			$atts['query_result']   = new WP_Query( barabi_core_get_query_params( $atts ) );

			$atts['this_shortcode'] = $this;

			return barabi_core_get_template_part( 'post-types/testimonials/shortcodes/testimonials-list', 'templates/content', $atts['behavior'], $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-testimonials-list';
			$holder_classes[] = isset( $atts['skin'] ) && ! empty( $atts['skin'] ) ? 'qodef-skin--' . $atts['skin'] : '';

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

		private function get_item_classes( $atts ) {
			$item_classes = $this->init_item_classes();

			$list_item_classes = $this->get_list_item_classes( $atts );

			$item_classes = array_merge( $item_classes, $list_item_classes );

			return implode( ' ', $item_classes );
		}

		public function get_title_styles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['text_transform'] ) ) {
				$styles[] = 'text-transform: ' . $atts['text_transform'];
			}

			return $styles;
		}
	}
}
