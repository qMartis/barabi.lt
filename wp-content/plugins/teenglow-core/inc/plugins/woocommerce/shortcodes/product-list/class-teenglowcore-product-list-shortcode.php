<?php

if ( ! function_exists( 'teenglow_core_add_product_list_shortcode' ) ) {
	/**
	 * Function that is adding shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes - Array of registered shortcodes
	 *
	 * @return array
	 */
	function teenglow_core_add_product_list_shortcode( $shortcodes ) {
		$shortcodes[] = 'TeenglowCore_Product_List_Shortcode';

		return $shortcodes;
	}

	add_filter( 'teenglow_core_filter_register_shortcodes', 'teenglow_core_add_product_list_shortcode' );
}

if ( class_exists( 'TeenglowCore_List_Shortcode' ) ) {
	class TeenglowCore_Product_List_Shortcode extends TeenglowCore_List_Shortcode {

		public function __construct() {
			$this->set_post_type( 'product' );
			$this->set_post_type_taxonomy( 'product_cat' );
			$this->set_post_type_additional_taxonomies( array( 'product_tag', 'product_type' ) );
			$this->set_layouts( apply_filters( 'teenglow_core_filter_product_list_layouts', array() ) );
			$this->set_extra_options( apply_filters( 'teenglow_core_filter_product_list_extra_options', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( TEENGLOW_CORE_PLUGINS_URL_PATH . '/woocommerce/shortcodes/product-list' );
			$this->set_base( 'teenglow_core_product_list' );
			$this->set_name( esc_html__( 'Product List', 'teenglow-core' ) );
			$this->set_description( esc_html__( 'Shortcode that displays list of products', 'teenglow-core' ) );
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'teenglow-core' ),
				)
			);
			$this->map_list_options();
			$this->map_query_options( array( 'post_type' => $this->get_post_type() ) );
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'filterby',
					'title'         => esc_html__( 'Filter By', 'teenglow-core' ),
					'options'       => array(
						''             => esc_html__( 'Default', 'teenglow-core' ),
						'on_sale'      => esc_html__( 'On Sale', 'teenglow-core' ),
						'featured'     => esc_html__( 'Featured', 'teenglow-core' ),
						'top_rated'    => esc_html__( 'Top Rated', 'teenglow-core' ),
						'best_selling' => esc_html__( 'Best Selling', 'teenglow-core' ),
					),
					'default_value' => '',
					'group'         => esc_html__( 'Query', 'teenglow-core' ),
				)
			);
			$this->map_layout_options( array( 'layouts' => $this->get_layouts() ) );
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'add_to_cart_button_type',
					'title'         => esc_html__( 'Button Type', 'teenglow-core' ),
					'options'       => array(
						'simple'            => esc_html__( 'Simple', 'teenglow-core' ),
						'simple-with-icon'  => esc_html__( 'Simple - With Icon', 'teenglow-core' ),
						'filled-with-price' => esc_html__( 'Filled - With Price', 'teenglow-core' ),
					),
					'default_value' => 'simple',
					'visibility'    => array(
						'map_for_page_builder' => false,
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'excerpt_length',
					'title'      => esc_html__( 'Excerpt Length', 'teenglow-core' ),
					'group'      => esc_html__( 'Layout', 'teenglow-core' ),
					'dependency' => array(
						'show' => array(
							'layout' => array(
								'values'        => array( 'presentational', 'presentational-centered' ),
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
					'title'      => esc_html__( 'Enable Partial Columns', 'teenglow-core' ),
					'options'    => teenglow_core_get_select_type_options_pool( 'no_yes', false ),
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
					'title'       => esc_html__( 'Partial Columns Value', 'teenglow-core' ),
					'description' => esc_html__( 'Value can be between 0 and 1', 'teenglow-core' ),
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
					'field_type' => 'select',
					'name'       => 'disable_partial_columns_under',
					'title'      => esc_html__( 'Disable Partial Columns Under', 'teenglow-core' ),
					'options'    => array(
						''     => esc_html__( 'Never', 'teenglow-core' ),
						'1024' => esc_html__( '1024', 'teenglow-core' ),
						'768'  => esc_html__( '768', 'teenglow-core' ),
						'680'  => esc_html__( '680', 'teenglow-core' ),
						'480'  => esc_html__( '480', 'teenglow-core' ),
					),
					'dependency' => array(
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
					'field_type' => 'text',
					'name'       => 'static_title',
					'title'      => esc_html__( 'Title', 'teenglow-core' ),
					'dependency' => array(
						'show' => array(
							'behavior' => array(
								'values'        => array( 'columns', 'slider' ),
								'default_value' => '',
							),
						),
					),
					'group'      => esc_html__( 'Static Content', 'teenglow-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'static_title_tag',
					'title'         => esc_html__( 'Title Tag', 'teenglow-core' ),
					'options'       => teenglow_core_get_select_type_options_pool( 'title_tag' ),
					'default_value' => 'h2',
					'dependency'    => array(
						'show' => array(
							'behavior' => array(
								'values'        => array( 'columns', 'slider' ),
								'default_value' => '',
							),
						),
					),
					'group'         => esc_html__( 'Static Content', 'teenglow-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'static_title_color',
					'title'      => esc_html__( 'Title Color', 'teenglow-core' ),
					'dependency' => array(
						'show' => array(
							'behavior' => array(
								'values'        => array( 'columns', 'slider' ),
								'default_value' => '',
							),
						),
					),
					'group'      => esc_html__( 'Static Content', 'teenglow-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'static_title_right_margin',
					'title'      => esc_html__( 'Right Margin', 'teenglow-core' ),
					'dependency' => array(
						'show' => array(
							'behavior' => array(
								'values'        => array( 'slider' ),
								'default_value' => '',
							),
						),
					),
					'group'      => esc_html__( 'Static Content', 'teenglow-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'image',
					'name'       => 'static_image',
					'title'      => esc_html__( 'Image', 'teenglow-core' ),
					'dependency' => array(
						'show' => array(
							'behavior' => array(
								'values'        => array( 'columns' ),
								'default_value' => '',
							),
						),
					),
					'group'      => esc_html__( 'Static Content', 'teenglow-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'static_button_link',
					'title'      => esc_html__( 'Button Link', 'teenglow-core' ),
					'dependency' => array(
						'show' => array(
							'behavior' => array(
								'values'        => array( 'columns' ),
								'default_value' => '',
							),
						),
					),
					'group'      => esc_html__( 'Static Content', 'teenglow-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'static_button_label',
					'title'      => esc_html__( 'Button Label', 'teenglow-core' ),
					'dependency' => array(
						'show' => array(
							'behavior' => array(
								'values'        => array( 'columns' ),
								'default_value' => '',
							),
						),
					),
					'group'      => esc_html__( 'Static Content', 'teenglow-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'static_content_margin',
					'title'      => esc_html__( 'Margin', 'teenglow-core' ),
					'dependency' => array(
						'show' => array(
							'behavior' => array(
								'values'        => array( 'columns' ),
								'default_value' => '',
							),
						),
					),
					'group'      => esc_html__( 'Static Content', 'teenglow-core' ),
				)
			);

			$this->map_additional_options();
			$this->map_extra_options();
		}

		public static function call_shortcode( $params ) {
			$html = qode_framework_call_shortcode( 'teenglow_core_product_list', $params );
			$html = str_replace( "\n", '', $html );

			return $html;
		}

		public function render( $options, $content = null ) {
			parent::render( $options );

			$atts = $this->get_atts();

			$atts['post_type']       = $this->get_post_type();
			$atts['taxonomy_filter'] = $this->get_post_type_filter_taxonomy( $atts );

			// Additional query args
			$atts['additional_query_args'] = $this->get_additional_query_args( $atts );

			$atts['holder_classes']        = $this->get_holder_classes( $atts );
			$atts['holder_styles']         = $this->get_holder_styles( $atts );
			$atts['query_result']          = new WP_Query( teenglow_core_get_query_params( $atts ) );
			$atts['slider_attr']           = $this->get_slider_data( $atts );
			$atts['button_params']         = $this->get_button_params( $atts );
			$atts['static_title_styles']   = $this->get_static_title_styles( $atts );
			$atts['static_content_styles']   = $this->get_static_content_styles( $atts );
			$atts['outer_holder_styles'] = $this->get_outer_holder_styles( $atts );
			$atts['data_attr']             = teenglow_core_get_pagination_data( TEENGLOW_CORE_REL_PATH, 'plugins/woocommerce/shortcodes', 'product-list', 'product', $atts );

			$atts['this_shortcode'] = $this;

			return teenglow_core_get_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/content', $atts['behavior'], $atts );
		}

		public function get_additional_query_args( $atts ) {
			$args = parent::get_additional_query_args( $atts );

			if ( ! empty( $atts['filterby'] ) ) {
				switch ( $atts['filterby'] ) {
					case 'on_sale':
						$sale_products         = wc_get_product_ids_on_sale();
						$args['no_found_rows'] = 1;
						$args['post__in']      = array_merge( array( 0 ), $sale_products );

						if ( ! empty( $atts['additional_params'] ) && 'id' === $atts['additional_params'] && ! empty( $atts['post_ids'] ) ) {
							$post_ids          = array_map( 'intval', explode( ',', $atts['post_ids'] ) );
							$new_sale_products = array();

							foreach ( $post_ids as $post_id ) {
								if ( in_array( $post_id, $sale_products, true ) ) {
									$new_sale_products[] = $post_id;
								}
							}

							if ( ! empty( $new_sale_products ) ) {
								$args['post__in'] = $new_sale_products;
							}
						}

						break;
					case 'featured':
						$featured_tax_query   = WC()->query->get_tax_query();
						$featured_tax_query[] = array(
							'taxonomy'         => 'product_visibility',
							'terms'            => 'featured',
							'field'            => 'name',
							'operator'         => 'IN',
							'include_children' => false,
						);

						if ( isset( $args['tax_query'] ) && ! empty( $args['tax_query'] ) ) {
							$args['tax_query'] = array_merge( $args['tax_query'], $featured_tax_query );
						} else {
							$args['tax_query'] = $featured_tax_query;
						}

						break;
					case 'top_rated':
						$args['meta_key'] = '_wc_average_rating';
						$args['order']    = 'DESC';
						$args['orderby']  = 'meta_value_num';
						break;
					case 'best_selling':
						$args['meta_key'] = 'total_sales';
						$args['order']    = 'DESC';
						$args['orderby']  = 'meta_value_num';
						break;
				}
			}

			return $args;
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-woo-shortcode';
			$holder_classes[] = 'qodef-woo-product-list';
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-item-layout--' . $atts['layout'] : '';

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

		private function get_static_content_styles( $atts ) {
			$styles = array();

			if ( qode_framework_string_ends_with_typography_units( $atts['static_title_right_margin'] ) ) {
				$styles[] = 'margin-right: ' . $atts['static_title_right_margin'];
			} else {
				$styles[] = 'margin-right: ' . intval( $atts['static_title_right_margin'] ) . 'px';
			}

			return $styles;
		}

		public function get_item_classes( $atts ) {
			$item_classes      = $this->init_item_classes();
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

		public function get_button_params( $atts ) {
			$button_params = array();

			if ( ! empty( $atts['add_to_cart_button_type'] ) ) {
				$button_params['button_type'] = $atts['add_to_cart_button_type'];
			}

			return $button_params;
		}

		private function get_static_title_styles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['static_title_color'] ) ) {
				$styles[] = 'color: ' . $atts['static_title_color'];
			}

			return $styles;
		}

		private function get_outer_holder_styles( $atts ) {
			$styles = array();

			if ( qode_framework_string_ends_with_typography_units( $atts['static_content_margin'] ) ) {
				$styles[] = 'gap: ' . $atts['static_content_margin'];
			} else {
				$styles[] = 'gap: ' . intval( $atts['static_content_margin'] ) . 'px';
			}

			return $styles;
		}
	}
}
