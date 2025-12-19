<?php

class TeenglowCore_Order_Tracking_Shortcode_Elementor extends TeenglowCore_Elementor_Widget_Base {

	public function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'teenglow_core_order_tracking' );

		parent::__construct( $data, $args );
	}
}

if ( qode_framework_is_installed( 'woocommerce' ) ) {
	teenglow_core_register_new_elementor_widget( new TeenglowCore_Order_Tracking_Shortcode_Elementor() );
}
