<?php

class BarabiCore_Text_Marquee_Shortcode_Elementor extends BarabiCore_Elementor_Widget_Base {

	public function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'barabi_core_text_marquee' );

		parent::__construct( $data, $args );
	}
}

barabi_core_register_new_elementor_widget( new BarabiCore_Text_Marquee_Shortcode_Elementor() );
