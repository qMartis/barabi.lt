<?php

class TeenglowCore_Google_Map_Shortcode_Elementor extends TeenglowCore_Elementor_Widget_Base {

	public function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'teenglow_core_google_map' );

		parent::__construct( $data, $args );
	}
}

teenglow_core_register_new_elementor_widget( new TeenglowCore_Google_Map_Shortcode_Elementor() );
