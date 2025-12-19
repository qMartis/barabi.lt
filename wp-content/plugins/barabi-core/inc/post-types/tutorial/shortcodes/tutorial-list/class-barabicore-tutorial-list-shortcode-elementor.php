<?php

class BarabiCore_Tutorial_List_Shortcode_Elementor extends BarabiCore_Elementor_Widget_Base {

	public function __construct( array $data = array(), $args = null ) {
		$this->set_shortcode_slug( 'barabi_core_tutorial_list' );

		parent::__construct( $data, $args );
	}
}

barabi_core_register_new_elementor_widget( new BarabiCore_Tutorial_List_Shortcode_Elementor() );
