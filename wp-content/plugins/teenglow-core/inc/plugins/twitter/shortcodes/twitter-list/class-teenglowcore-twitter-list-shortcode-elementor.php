<?php

class TeenglowCore_Twitter_List_Shortcode_Elementor extends TeenglowCore_Elementor_Widget_Base {

	public function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'teenglow_core_twitter_list' );

		parent::__construct( $data, $args );
	}
}

if ( qode_framework_is_installed( 'twitter' ) ) {
	teenglow_core_register_new_elementor_widget( new TeenglowCore_Twitter_List_Shortcode_Elementor() );
}
