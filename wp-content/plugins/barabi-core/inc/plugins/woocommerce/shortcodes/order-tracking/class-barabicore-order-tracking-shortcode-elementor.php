<?php

class BarabiCore_Order_Tracking_Shortcode_Elementor extends BarabiCore_Elementor_Widget_Base {

	public function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'barabi_core_order_tracking' );

		parent::__construct( $data, $args );
	}
}

if ( qode_framework_is_installed( 'woocommerce' ) ) {
	barabi_core_register_new_elementor_widget( new BarabiCore_Order_Tracking_Shortcode_Elementor() );
}
