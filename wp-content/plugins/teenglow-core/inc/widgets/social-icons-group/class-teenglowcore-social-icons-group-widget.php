<?php

if ( ! function_exists( 'teenglow_core_add_social_icons_group_widget' ) ) {
	/**
	 * function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function teenglow_core_add_social_icons_group_widget( $widgets ) {
		$widgets[] = 'TeenglowCore_Social_Icons_Group_Widget';

		return $widgets;
	}

	add_filter( 'teenglow_core_filter_register_widgets', 'teenglow_core_add_social_icons_group_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class TeenglowCore_Social_Icons_Group_Widget extends QodeFrameworkWidget {
		public $no_of_icons = 5;

		public function map_widget() {
			$this->set_base( 'teenglow_core_social_icons_group' );
			$this->set_name( esc_html__( 'Teenglow Social Icons Group', 'teenglow-core' ) );
			$this->set_description( sprintf( esc_html__( 'Use this widget to add a group of up to %s social icons to a widget area.', 'teenglow-core' ), $this->no_of_icons ) );
			$this->set_widget_option(
				array(
					'field_type' => 'text',
					'name'       => 'widget_title',
					'title'      => esc_html__( 'Title', 'teenglow-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type'    => 'select',
					'name'          => 'icon_layout',
					'title'         => esc_html__( 'Layout', 'teenglow-core' ),
					'options'       => array(
						'normal'  => esc_html__( 'Normal', 'teenglow-core' ),
						'circle'  => esc_html__( 'Circle', 'teenglow-core' ),
						'square'  => esc_html__( 'Square', 'teenglow-core' ),
						'textual' => esc_html__( 'Textual', 'teenglow-core' ),
					),
					'default_value' => 'normal',
				)
			);
			for ( $i = 1; $i <= $this->no_of_icons; $i ++ ) {
				$this->set_widget_option(
					array(
						'field_type' => 'iconpack',
						'name'       => 'main_icon_' . $i,
						'title'      => sprintf( esc_html__( 'Icon %s', 'teenglow-core' ), $i ),
						'dependency' => array(
							'hide' => array(
								'icon_layout' => array(
									'values'        => 'textual',
									'default_value' => 'normal',
								),
							),
						),
					)
				);
				$this->set_widget_option(
					array(
						'field_type' => 'text',
						'name'       => 'text_icon_' . $i,
						'title'      => sprintf( esc_html__( 'Text Icon %s', 'teenglow-core' ), $i ),
						'dependency' => array(
							'show' => array(
								'icon_layout' => array(
									'values'        => 'textual',
									'default_value' => 'normal',
								),
							),
						),
					)
				);
				$this->set_widget_option(
					array(
						'field_type' => 'text',
						'name'       => 'link_' . $i,
						'title'      => sprintf( esc_html__( 'Link %s', 'teenglow-core' ), $i ),
					)
				);
				$this->set_widget_option(
					array(
						'field_type'    => 'select',
						'name'          => 'target_' . $i,
						'title'         => sprintf( esc_html__( 'Link %s Target', 'teenglow-core' ), $i ),
						'options'       => teenglow_core_get_select_type_options_pool( 'link_target', false ),
						'default_value' => '_blank',
					)
				);
				$this->set_widget_option(
					array(
						'field_type' => 'text',
						'name'       => 'custom_size_' . $i,
						'title'      => sprintf( esc_html__( 'Icon %s Size', 'teenglow-core' ), $i ),
						'dependency' => array(
							'hide' => array(
								'icon_layout' => array(
									'values'        => 'textual',
									'default_value' => 'normal',
								),
							),
						),
					)
				);
				$this->set_widget_option(
					array(
						'field_type' => 'text',
						'name'       => 'margin_' . $i,
						'title'      => sprintf( esc_html__( 'Icon %s Margin', 'teenglow-core' ), $i ),
					)
				);
				$this->set_widget_option(
					array(
						'field_type' => 'color',
						'name'       => 'icon_color_' . $i,
						'title'      => sprintf( esc_html__( 'Icon %s Color', 'teenglow-core' ), $i ),
					)
				);
				$this->set_widget_option(
					array(
						'field_type' => 'color',
						'name'       => 'icon_background_color_' . $i,
						'title'      => sprintf( esc_html__( 'Icon %s Background Color', 'teenglow-core' ), $i ),
						'dependency' => array(
							'hide' => array(
								'icon_layout' => array(
									'values'        => 'textual',
									'default_value' => 'normal',
								),
							),
						),
					)
				);
				$this->set_widget_option(
					array(
						'field_type' => 'color',
						'name'       => 'icon_hover_color_' . $i,
						'title'      => sprintf( esc_html__( 'Icon %s Hover Color', 'teenglow-core' ), $i ),
					)
				);
				$this->set_widget_option(
					array(
						'field_type' => 'color',
						'name'       => 'icon_hover_background_color_' . $i,
						'title'      => sprintf( esc_html__( 'Icon %s Hover Background Color', 'teenglow-core' ), $i ),
						'dependency' => array(
							'hide' => array(
								'icon_layout' => array(
									'values'        => 'textual',
									'default_value' => 'normal',
								),
							),
						),
					)
				);
			}
		}

		public function render( $atts ) { ?>
			<div class="qodef-social-icons-group">
				<?php
				for ( $i = 1; $i <= $this->no_of_icons; $i ++ ) {
					$selected_icon_pack = str_replace( '-', '_', $atts[ 'main_icon_' . $i ] );
					$is_textual_icon    = isset( $atts[ 'text_icon_' . $i ] ) && ! empty( $atts[ 'text_icon_' . $i ] );

					if ( $is_textual_icon ) {
						$textual_styles = array();

						if ( ! empty( $atts[ 'icon_color_' . $i ] ) ) {
							$textual_styles[] = 'color: ' . $atts[ 'icon_color_' . $i ];
						}

						if ( ! empty( $atts[ 'margin_' . $i ] ) ) {
							$textual_styles[] = 'margin: ' . $atts[ 'margin_' . $i ];
						}

						$textual_hover_styles = array();
						if ( ! empty( $atts[ 'icon_hover_color_' . $i ] ) ) {
							$textual_hover_styles[] = $atts[ 'icon_hover_color_' . $i ];
						}
						?>
						<span class="qodef-icon-holder qodef--textual" <?php qode_framework_inline_style( $textual_styles ); ?> <?php qode_framework_inline_attr( $textual_hover_styles, 'data-hover-color' ); ?>>
							<?php
							echo sprintf(
								'%s%s%s',
								! empty( $atts[ 'link_' . $i ] ) ? '<a itemprop="url" href="' . esc_url( $atts[ 'link_' . $i ] ) . '" target="' . esc_url( $atts[ 'target_' . $i ] ) . '">' : '',
								esc_html( $atts[ 'text_icon_' . $i ] ),
								! empty( $atts[ 'link_' . $i ] ) ? '</a>' : ''
							);
							?>
						</span>
						<?php
					} elseif ( ! empty( $atts[ 'main_icon_' . $i . '_' . $selected_icon_pack ] ) ) {
						$params = array(
							'main_icon'                        => $atts[ 'main_icon_' . $i ],
							'main_icon_' . $selected_icon_pack => $atts[ 'main_icon_' . $i . '_' . $selected_icon_pack ],
							'link'                             => $atts[ 'link_' . $i ],
							'target'                           => $atts[ 'target_' . $i ],
							'custom_size'                      => $atts[ 'custom_size_' . $i ],
							'margin'                           => $atts[ 'margin_' . $i ],
							'background_color'                 => $atts[ 'icon_background_color_' . $i ],
							'color'                            => $atts[ 'icon_color_' . $i ],
							'hover_background_color'           => $atts[ 'icon_hover_background_color_' . $i ],
							'hover_color'                      => $atts[ 'icon_hover_color_' . $i ],
							'icon_layout'                      => $atts['icon_layout'],
						);

						echo TeenglowCore_Icon_Shortcode::call_shortcode( $params ); // XSS OK
					}
				}
				?>
			</div>
			<?php
		}
	}
}
