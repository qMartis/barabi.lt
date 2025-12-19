<?php
if ( ! function_exists( 'teenglow_core_add_above_header_area_options' ) ) {
	function teenglow_core_add_above_header_area_options( $page ) {
		
		$above_header_area_section = $page->add_section_element(
			array(
				'name'        => 'qodef_above_header_area_section',
				'title'       => esc_html__( 'Above Header Area', 'teenglow-core' ),
				'description' => esc_html__( 'Options related to above header area', 'teenglow-core' ),
				'dependency'  => array(
					'hide' => array(
						'qodef_header_layout' => array(
							'values'        => teenglow_core_dependency_for_above_header_area_options(),
							'default_value' => ''
						)
					)
				)
			)
		);
		
		$above_header_area_section->add_field_element(
			array(
				'field_type'    => 'yesno',
				'default_value' => 'no',
				'name'          => 'qodef_above_header_area_header',
				'title'         => esc_html__( 'Above Header Area', 'teenglow-core' ),
				'description'   => esc_html__( 'Enable above header area', 'teenglow-core' )
			)
		);
	}
	
	add_action( 'teenglow_core_action_after_header_options_map', 'teenglow_core_add_above_header_area_options' );
}