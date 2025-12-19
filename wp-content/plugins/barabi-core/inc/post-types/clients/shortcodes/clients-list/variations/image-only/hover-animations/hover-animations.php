<?php

if ( ! function_exists( 'barabi_core_filter_clients_list_image_only_animation_options' ) ) {
	/**
	 * Function that add additional options for variation layout
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	function barabi_core_filter_clients_list_image_only_animation_options( $options ) {
		$hover_option  = array();
		$option_filter = apply_filters( 'barabi_core_filter_clients_list_image_only_animation_options', array() );
		$options_map   = barabi_core_get_variations_options_map( $option_filter );

		$option = array(
			'field_type'    => 'select',
			'name'          => 'hover_animation_image-only',
			'title'         => esc_html__( 'Hover Animation', 'barabi-core' ),
			'options'       => $option_filter,
			'default_value' => $options_map['default_value'],
			'dependency'    => array(
				'show' => array(
					'layout' => array(
						'values'        => 'image-only',
						'default_value' => '',
					),
				),
			),
			'group'         => esc_html__( 'Layout', 'barabi-core' ),
			'visibility'    => array( 'map_for_page_builder' => $options_map['visibility'] ),
		);

		$hover_option[] = $option;

		return array_merge( $options, $hover_option );
	}

	add_filter( 'barabi_core_filter_clients_list_hover_animation_options', 'barabi_core_filter_clients_list_image_only_animation_options' );
}
