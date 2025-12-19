<?php
if ( ! function_exists( 'barabi_core_dependency_for_above_header_area_options' ) ) {
	function barabi_core_dependency_for_above_header_area_options() {
		$dependency_options = apply_filters( 'barabi_core_filter_above_header_area_hide_option', $hide_dep_options = array() );
		
		return $dependency_options;
	}
}

if ( ! function_exists( 'barabi_core_register_above_header_area_header_areas' ) ) {
	function barabi_core_register_above_header_area_header_areas() {
		register_sidebar(
			array(
				'id'            => 'qodef-header-widget-area-above',
				'name'          => esc_html__( 'Above Header Area', 'barabi-core' ),
				'description'   => esc_html__( 'Widgets added here will appear in above header area', 'barabi-core' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s qodef-header-widget-area-above">',
				'after_widget'  => '</div>'
			)
		);
	}
	
	add_action( 'barabi_core_action_additional_header_widgets_area', 'barabi_core_register_above_header_area_header_areas' );
}