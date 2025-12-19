<?php

class BarabiCore_Dropcaps_Shortcode_Elementor extends BarabiCore_Elementor_Widget_Base {

	public function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'barabi_core_dropcaps' );

		parent::__construct( $data, $args );
	}
}

barabi_core_register_new_elementor_widget( new BarabiCore_Dropcaps_Shortcode_Elementor() );
