<?php
if ( ! function_exists( 'barabi_core_add_above_header_area_meta_options' ) ) {
	function barabi_core_add_above_header_area_meta_options( $page ) {
		
		$above_header_area_section = $page->add_section_element(
			array(
				'name'       => 'qodef_above_header_area_section',
				'title'      => esc_html__( 'Above Header Area', 'barabi-core' ),
				'dependency' => array(
					'hide' => array(
						'qodef_header_layout' => array(
							'values'        => array( '', 'minimal'),
							'default_value' => ''
						)
					)
				)
			)
		);
		
		$above_header_area_section->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_above_header_area_header',
				'title'       => esc_html__( 'Above Header', 'barabi-core' ),
				'description' => esc_html__( 'Enable above header area', 'barabi-core' ),
				'options'     => barabi_core_get_select_type_options_pool( 'yes_no' )
			)
		);
		
		$custom_sidebars = barabi_core_get_custom_sidebars();
		if ( ! empty( $custom_sidebars ) && count( $custom_sidebars ) > 1 ) {
			
			$above_header_area_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_header_custom_widget_area_above',
					'title'       => esc_html__( 'Choose Custom Above Header Widget Area', 'barabi-core' ),
					'description' => esc_html__( 'Choose custom widget area to display in above header widget area', 'barabi-core' ),
					'options'     => $custom_sidebars,
					'dependency' => array(
						'show' => array(
							'qodef_above_header_area_header' => array(
								'values'        => 'yes',
								'default_value' => 'yes'
							)
						)
					)
				)
			);
		}
	}
	
	add_action( 'barabi_core_action_after_page_header_meta_map', 'barabi_core_add_above_header_area_meta_options' );
}