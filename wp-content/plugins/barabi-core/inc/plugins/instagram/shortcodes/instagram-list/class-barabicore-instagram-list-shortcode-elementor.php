<?php

class BarabiCore_Instagram_List_Shortcode_Elementor extends BarabiCore_Elementor_Widget_Base {

	public function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'barabi_core_instagram_list' );

		parent::__construct( $data, $args );
	}
}

if ( qode_framework_is_installed( 'instagram' ) ) {
	barabi_core_register_new_elementor_widget( new BarabiCore_Instagram_List_Shortcode_Elementor() );
}
