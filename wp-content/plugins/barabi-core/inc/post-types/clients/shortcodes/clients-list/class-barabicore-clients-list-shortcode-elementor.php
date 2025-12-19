<?php

class BarabiCore_Clients_List_Shortcode_Elementor extends BarabiCore_Elementor_Widget_Base {

	public function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'barabi_core_clients_list' );

		parent::__construct( $data, $args );
	}
}

barabi_core_register_new_elementor_widget( new BarabiCore_Clients_List_Shortcode_Elementor() );
