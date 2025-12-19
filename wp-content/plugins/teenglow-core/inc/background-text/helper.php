<?php

// row

if ( ! function_exists( 'teenglow_core_vc_row_background_text' ) ) {
	/**
	 * Map VC Row shortcode
	 * Hooks on vc_after_init action
	 */
	function teenglow_core_vc_row_background_text() {

		/******* VC Row shortcode - begin *******/

		//Background text options

		vc_add_param(
			'vc_row',
			array(
				'type'       => 'dropdown',
				'param_name' => 'background_text_enable',
				'heading'    => esc_html__( 'Enable Background Text', 'teenglow-core' ),
				'value'      => array(
					esc_html__( 'Default', 'teenglow-core' ) => '',
					esc_html__( 'Yes', 'teenglow-core' ) => 'yes',
					esc_html__( 'No', 'teenglow-core' )  => 'no',
				),
				'group'      => esc_html__( 'Teenglow Core Settings', 'teenglow-core' ),
			)
		);

		vc_add_param(
			'vc_row',
			array(
				'type'       => 'textfield',
				'param_name' => 'background_text',
				'heading'    => esc_html__( 'Background Text', 'teenglow-core' ),
				'group'      => esc_html__( 'Teenglow Core Settings', 'teenglow-core' ),
				'dependency' => array(
					'element' => 'background_text_enable',
					'value'   => array( 'yes' ),
				),
			)
		);

		vc_add_param(
			'vc_row',
			array(
				'type'       => 'colorpicker',
				'param_name' => 'background_text_color',
				'heading'    => esc_html__( 'Background Text  Color', 'teenglow-core' ),
				'group'      => esc_html__( 'Teenglow Core Settings', 'teenglow-core' ),
				'dependency' => array(
					'element' => 'background_text_enable',
					'value'   => array( 'yes' ),
				),
			)
		);

		vc_add_param(
			'vc_row',
			array(
				'type'        => 'textfield',
				'param_name'  => 'background_text_size',
				'heading'     => esc_html__( 'Background Text Size', 'teenglow-core' ),
				'description' => esc_html( 'Set the background text size in px or em', 'teenglow-core' ),
				'group'       => esc_html__( 'Teenglow Core Settings', 'teenglow-core' ),
				'dependency'  => array(
					'element' => 'background_text_enable',
					'value'   => array( 'yes' ),
				),
			)
		);

		vc_add_param(
			'vc_row',
			array(
				'type'       => 'colorpicker',
				'param_name' => 'background_text_outline_color',
				'heading'    => esc_html__( 'Text Outline Color', 'teenglow-core' ),
				'group'      => esc_html__( 'Teenglow Core Settings', 'teenglow-core' ),
				'dependency' => array(
					'element' => 'background_text_enable',
					'value'   => array( 'yes' ),
				),
			)
		);

		vc_add_param(
			'vc_row',
			array(
				'type'       => 'textfield',
				'param_name' => 'background_text_outline_stroke_width',
				'heading'    => esc_html__( 'Text Outline Width', 'teenglow-core' ),
				'group'      => esc_html__( 'Teenglow Core Settings', 'teenglow-core' ),
				'dependency' => array(
					'element' => 'background_text_enable',
					'value'   => array( 'yes' ),
				),
			)
		);

		vc_add_param(
			'vc_row',
			array(
				'type'       => 'dropdown',
				'param_name' => 'background_text_align',
				'heading'    => esc_html__( 'Background Text Align', 'teenglow-core' ),
				'value'      => array(
					esc_html__( 'Default', 'teenglow-core' ) => '',
					esc_html__( 'Left', 'teenglow-core' )  => 'left',
					esc_html__( 'Center', 'teenglow-core' ) => 'center',
					esc_html__( 'Right', 'teenglow-core' ) => 'right',
				),
				'group'      => esc_html__( 'Teenglow Core Settings', 'teenglow-core' ),
				'dependency' => array(
					'element' => 'background_text_enable',
					'value'   => array( 'yes' ),
				),
			)
		);

		vc_add_param(
			'vc_row',
			array(
				'type'       => 'dropdown',
				'param_name' => 'background_text_vertical_align',
				'heading'    => esc_html__( 'Background Text Vertical Align', 'teenglow-core' ),
				'value'      => array(
					esc_html__( 'Default', 'teenglow-core' ) => '',
					esc_html__( 'Top', 'teenglow-core' ) => 'flex-start',
					esc_html__( 'Middle', 'teenglow-core' ) => 'center',
					esc_html__( 'Bottom', 'teenglow-core' ) => 'flex-end',
				),
				'group'      => esc_html__( 'Teenglow Core Settings', 'teenglow-core' ),
				'dependency' => array(
					'element' => 'background_text_enable',
					'value'   => array( 'yes' ),
				),
			)
		);

		/******* VC Row shortcode - end *******/

	}

	add_action( 'teenglow_core_action_additional_vc_row_params', 'teenglow_core_vc_row_background_text' );
}

// row inner

if ( ! function_exists( 'teenglow_core_vc_row_inner_background_text' ) ) {
	/**
	 * Map VC Row inner shortcode
	 * Hooks on vc_after_init action
	 */
	function teenglow_core_vc_row_inner_background_text() {

		/******* VC Row Inner shortcode - begin *******/

		vc_add_param(
			'vc_row_inner',
			array(
				'type'       => 'dropdown',
				'param_name' => 'background_text_enable',
				'heading'    => esc_html__( 'Enable Background Text', 'teenglow-core' ),
				'value'      => array(
					esc_html__( 'Default', 'teenglow-core' ) => '',
					esc_html__( 'Yes', 'teenglow-core' ) => 'yes',
					esc_html__( 'No', 'teenglow-core' )  => 'no',
				),
				'group'      => esc_html__( 'Teenglow Core Settings', 'teenglow-core' ),
			)
		);

		vc_add_param(
			'vc_row_inner',
			array(
				'type'       => 'textfield',
				'param_name' => 'background_text',
				'heading'    => esc_html__( 'Background Text', 'teenglow-core' ),
				'group'      => esc_html__( 'Teenglow Core Settings', 'teenglow-core' ),
				'dependency' => array(
					'element' => 'background_text_enable',
					'value'   => array( 'yes' ),
				),
			)
		);

		vc_add_param(
			'vc_row_inner',
			array(
				'type'       => 'colorpicker',
				'param_name' => 'background_text_color',
				'heading'    => esc_html__( 'Background Text  Color', 'teenglow-core' ),
				'group'      => esc_html__( 'Teenglow Core Settings', 'teenglow-core' ),
				'dependency' => array(
					'element' => 'background_text_enable',
					'value'   => array( 'yes' ),
				),
			)
		);

		vc_add_param(
			'vc_row_inner',
			array(
				'type'       => 'textfield',
				'param_name' => 'background_text_size',
				'heading'    => esc_html__( 'Background Text Size', 'teenglow-core' ),
				'group'      => esc_html__( 'Teenglow Core Settings', 'teenglow-core' ),
				'dependency' => array(
					'element' => 'background_text_enable',
					'value'   => array( 'yes' ),
				),
			)
		);

		vc_add_param(
			'vc_row_inner',
			array(
				'type'       => 'colorpicker',
				'param_name' => 'background_text_outline_color',
				'heading'    => esc_html__( 'Text Outline Color', 'teenglow-core' ),
				'group'      => esc_html__( 'Teenglow Core Settings', 'teenglow-core' ),
				'dependency' => array(
					'element' => 'background_text_enable',
					'value'   => array( 'yes' ),
				),
			)
		);

		vc_add_param(
			'vc_row_inner',
			array(
				'type'        => 'textfield',
				'param_name'  => 'background_text_outline_stroke_width',
				'heading'     => esc_html__( 'Text Outline Width', 'teenglow-core' ),
				'description' => esc_html( 'Set the background text size in px or em', 'teenglow-core' ),
				'group'       => esc_html__( 'Teenglow Core Settings', 'teenglow-core' ),
				'dependency'  => array(
					'element' => 'background_text_enable',
					'value'   => array( 'yes' ),
				),
			)
		);

		vc_add_param(
			'vc_row_inner',
			array(
				'type'       => 'dropdown',
				'param_name' => 'background_text_align',
				'heading'    => esc_html__( 'Background Text Align', 'teenglow-core' ),
				'value'      => array(
					esc_html__( 'Default', 'teenglow-core' ) => '',
					esc_html__( 'Left', 'teenglow-core' )  => 'flex-start',
					esc_html__( 'Center', 'teenglow-core' ) => 'center',
					esc_html__( 'Right', 'teenglow-core' ) => 'flex-end',
				),
				'group'      => esc_html__( 'Teenglow Core Settings', 'teenglow-core' ),
				'dependency' => array(
					'element' => 'background_text_enable',
					'value'   => array( 'yes' ),
				),
			)
		);

		vc_add_param(
			'vc_row_inner',
			array(
				'type'       => 'dropdown',
				'param_name' => 'background_text_vertical_align',
				'heading'    => esc_html__( 'Background Text Vertical Align', 'teenglow-core' ),
				'value'      => array(
					esc_html__( 'Default', 'teenglow-core' ) => '',
					esc_html__( 'Top', 'teenglow-core' ) => 'flex-start',
					esc_html__( 'Middle', 'teenglow-core' ) => 'center',
					esc_html__( 'Bottom', 'teenglow-core' ) => 'flex-end',
				),
				'group'      => esc_html__( 'Teenglow Core Settings', 'teenglow-core' ),
				'dependency' => array(
					'element' => 'background_text_enable',
					'value'   => array( 'yes' ),
				),
			)
		);

		/******* VC Row Inner shortcode - end *******/

	}

	add_action( 'teenglow_core_action_additional_vc_row_inner_params', 'teenglow_core_vc_row_inner_background_text' );
}

if ( ! function_exists( 'teenglow_core_add_background_text' ) ) {
	function teenglow_core_add_background_text( $html, $atts ) {

		$params = array();

		//text
		$params['text'] = $atts['background_text'];

		//content style
		$background_text_content_style = array();
		if ( '' !== $atts['background_text_align'] ) {
			$background_text_content_style[] = 'justify-content:' . $atts['background_text_align'];
		}

		if ( '' !== $atts['background_text_vertical_align'] ) {
			$background_text_content_style[] = 'align-items:' . $atts['background_text_vertical_align'];
		}
		$params['background_text_content_style'] = implode( '; ', $background_text_content_style );

		//text style
		$background_text_style = array();
		if ( '' !== $atts['background_text_color'] ) {
			$background_text_style [] = 'color:' . $atts['background_text_color'];
		}

		if ( '' !== $atts['background_text_size'] ) {
			$background_text_style [] = 'font-size:' . intval( $atts['background_text_size'] ) . 'px';
		}

		if ( '' !== $atts['background_text_outline_stroke_width'] ) {
			$background_text_style [] = '-webkit-text-stroke-width:' . intval( $atts['background_text_outline_stroke_width'] ) . 'px';
		}

		if ( '' !== $atts['background_text_outline_color'] ) {
			$background_text_style [] = '-webkit-text-stroke-color:' . $atts['background_text_outline_color'];
		}

		$params['background_text_style'] = implode( '; ', $background_text_style );

		if ( '' !== $atts['background_text'] ) {
			$html .= teenglow_core_get_template_part( 'background-text', 'templates/background-text', '', $params );
		}

		return $html;
	}

	add_filter( 'teenglow_core_filter_vc_row_after_wrapper_open', 'teenglow_core_add_background_text', 10, 2 );
	add_filter( 'teenglow_core_filter_vc_row_inner_after_wrapper_open', 'teenglow_core_add_background_text', 10, 2 );
}

if ( ! function_exists( 'teenglow_core_add_additional_classes_on_row_text' ) ) {
	function teenglow_core_add_additional_classes_on_row_text( $classes, $base, $atts ) {

		if ( 'vc_row' === $base || 'vc_row_inner' === $base ) {
			if ( 'yes' === $atts['background_text_enable'] ) {
				$classes .= ' qodef-background-text';
			}

			if ( '' !== $atts['background_text_align'] ) {
				$classes .= ' qodef-background-text-alignment--' . $atts['background_text_align'];
			}
		}

		return $classes;
	}

	add_filter( 'vc_shortcodes_css_class', 'teenglow_core_add_additional_classes_on_row_text', 10, 3 );
}
