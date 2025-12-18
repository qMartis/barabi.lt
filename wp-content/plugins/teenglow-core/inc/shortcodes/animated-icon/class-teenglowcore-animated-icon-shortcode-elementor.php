<?php

class TeenglowCore_Animated_Icon_Shortcode_Elementor extends TeenglowCore_Elementor_Widget_Base {

	public function __construct( array $data = array(), $args = null ) {
		$this->set_shortcode_slug( 'teenglow_core_animated_icon' );

		parent::__construct( $data, $args );
	}
}

teenglow_core_register_new_elementor_widget( new TeenglowCore_Animated_Icon_Shortcode_Elementor() );
