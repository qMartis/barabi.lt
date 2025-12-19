<?php

if ( ! function_exists( 'barabi_core_add_svg_icon_widget' ) ) {
	/**
	 * function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function barabi_core_add_svg_icon_widget( $widgets ) {
		$widgets[] = 'BarabiCore_Svg_Icon_Widget';

		return $widgets;
	}

	add_filter( 'barabi_core_filter_register_widgets', 'barabi_core_add_svg_icon_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class BarabiCore_Svg_Icon_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$this->set_base( 'barabi_core_svg_icon' );
			$this->set_name( esc_html__( 'Barabi Icon Svg', 'barabi-core' ) );
			$this->set_description( esc_html__( 'Add a icon svg element into widget areas', 'barabi-core' ) );
			$this->set_widget_option(
				array(
					'field_type' => 'textarea',
					'name'       => 'icon',
					'title'      => esc_html__( 'Icon Svg Code', 'barabi-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type' => 'text',
					'name'       => 'text',
					'title'      => esc_html__( 'Text', 'barabi-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type' => 'text',
					'name'       => 'icon_link',
					'title'      => esc_html__( 'Link', 'barabi-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type'    => 'select',
					'name'          => 'icon_link_target',
					'title'         => esc_html__( 'Link Target', 'barabi-core' ),
					'options'       => barabi_core_get_select_type_options_pool( 'link_target' ),
					'default_value' => '_self',
				)
			);
			$this->set_widget_option(
				array(
					'field_type'  => 'text',
					'name'        => 'icon_margin',
					'title'       => esc_html__( 'Icon Margin', 'barabi-core' ),
					'description' => esc_html__( 'Insert margin in format: top right bottom left', 'barabi-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type' => 'text',
					'name'       => 'icon_holder_width',
					'title'      => esc_html__( 'Icon Holder Width (px)', 'barabi-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type' => 'text',
					'name'       => 'icon_holder_height',
					'title'      => esc_html__( 'Icon Holder Height (px)', 'barabi-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type' => 'color',
					'name'       => 'icon_stroke_color',
					'title'      => esc_html__( 'Icon Stroke Color', 'barabi-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type' => 'color',
					'name'       => 'icon_stroke_hover_color',
					'title'      => esc_html__( 'Icon Stroke Hover Color', 'barabi-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type' => 'color',
					'name'       => 'icon_fill_color',
					'title'      => esc_html__( 'Icon Fill Color', 'barabi-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type' => 'color',
					'name'       => 'icon_fill_hover_color',
					'title'      => esc_html__( 'Icon Fill Hover Color', 'barabi-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type' => 'color',
					'name'       => 'icon_background_color',
					'title'      => esc_html__( 'Icon Background Color', 'barabi-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type' => 'color',
					'name'       => 'icon_background_hover_color',
					'title'      => esc_html__( 'Icon Background Hover Color', 'barabi-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type'  => 'text',
					'name'        => 'icon_border_radius',
					'title'       => esc_html__( 'Icon Border Radius', 'barabi-core' ),
					'description' => esc_html__( 'Insert border radius in format: top right bottom left', 'barabi-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type' => 'color',
					'name'       => 'text_color',
					'title'      => esc_html__( 'Text Color', 'barabi-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type' => 'color',
					'name'       => 'text_hover_color',
					'title'      => esc_html__( 'Text Hover Color', 'barabi-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type' => 'text',
					'name'       => 'space_between_icon_text',
					'title'      => esc_html__( 'Space Between Icon and Text (px)', 'barabi-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type' => 'select',
					'name'       => 'icon_vertical_alignment',
					'title'      => esc_html__( 'Icon Vertical Alignment', 'barabi-core' ),
					'options'    => array(
						'center'     => esc_html__( 'Center', 'barabi-core' ),
						'flex-start' => esc_html__( 'Top', 'barabi-core' ),
						'flex-end'   => esc_html__( 'Bottom', 'barabi-core' ),
						'baseline'   => esc_html__( 'Baseline', 'barabi-core' ),
					),
				)
			);
		}

		public function render( $atts ) {
			$text_styles  = array();
			$icon_styles  = array();
			$holder_style = array();

			if ( '' !== $atts['icon_margin'] ) {
				$icon_styles[] = 'margin: ' . esc_attr( $atts['icon_margin'] );
			}
			if ( '' !== $atts['icon_stroke_color'] ) {
				$icon_styles[] = '--stroke-color: ' . esc_attr( $atts['icon_stroke_color'] );
			}
			if ( '' !== $atts['icon_stroke_hover_color'] ) {
				$icon_styles[] = '--stroke-hover-color: ' . esc_attr( $atts['icon_stroke_hover_color'] );
			}
			if ( '' !== $atts['icon_fill_color'] ) {
				$icon_styles[] = '--fill-color: ' . esc_attr( $atts['icon_fill_color'] );
			}
			if ( '' !== $atts['icon_fill_hover_color'] ) {
				$icon_styles[] = '--fill-hover-color: ' . esc_attr( $atts['icon_fill_hover_color'] );
			}
			if ( '' !== $atts['icon_background_color'] ) {
				$icon_styles[] = '--background-color: ' . esc_attr( $atts['icon_background_color'] );
			}
			if ( '' !== $atts['icon_background_hover_color'] ) {
				$icon_styles[] = '--background-hover-color: ' . esc_attr( $atts['icon_background_hover_color'] );
			}
			if ( '' !== $atts['icon_holder_width'] ) {
				$icon_styles[] = 'width: ' . intval( esc_attr( $atts['icon_holder_width'] ) ) . 'px';
			}
			if ( '' !== $atts['icon_holder_height'] ) {
				$icon_styles[] = 'height: ' . intval( esc_attr( $atts['icon_holder_height'] ) ) . 'px';
			}
			if ( '' !== $atts['icon_border_radius'] ) {
				$icon_styles[] = 'border-radius: ' . esc_attr( $atts['icon_border_radius'] );
			}

			if ( '' !== $atts['text_color'] ) {
				$text_styles[] = '--text-color: ' . esc_attr( $atts['text_color'] );
			}
			if ( '' !== $atts['text_hover_color'] ) {
				$text_styles[] = '--text-hover-color: ' . esc_attr( $atts['text_hover_color'] );
			}
			if ( '' !== $atts['space_between_icon_text'] ) {
				$text_styles[] = 'margin-left: ' . esc_attr( $atts['space_between_icon_text'] ) . 'px';
			}

			if ( '' !== $atts['icon_vertical_alignment'] ) {
				$holder_style[] = 'align-items:' . esc_attr( $atts['icon_vertical_alignment'] );
			}

			if ( ! empty( $atts['icon'] ) ) { ?>
				<div class="qodef-svg-icon-widget">
					<?php if ( ! empty( $atts['icon_link'] ) ) { ?>
						<a href="<?php echo esc_url( $atts['icon_link'] ); ?>" target="<?php echo esc_attr( $atts['icon_link_target'] ); ?>">
					<?php } ?>
					<div class="qodef-m-holder" <?php qode_framework_inline_style( $holder_style ); ?>>
						<div class="qodef-m-icon" <?php qode_framework_inline_style( $icon_styles ); ?>>
							<?php echo qode_framework_wp_kses_html( 'svg', $atts['icon'] ); ?>
						</div>
						<?php if ( isset( $atts['text'] ) && ! empty( $atts['text'] ) ) { ?>
							<span class="qodef-m-text" <?php qode_framework_inline_style( $text_styles ); ?>><?php echo esc_html( $atts['text'] ); ?></span>
						<?php } ?>
					</div>
					<?php if ( ! empty( $atts['icon_link'] ) ) { ?>
						</a>
					<?php } ?>
				</div>
				<?php
			}
		}
	}
}
