<?php

$button_params = array(
	'button_layout' => 'textual',
	'link'          => ! empty( $button_link ) ? $button_link : '#',
	'text'          => ! empty( $button_text ) ? $button_text : esc_html__( 'See Products', 'barabi-core' ),
	'target'        => ! empty( $button_target ) ? $button_target : '_self',
);

if ( class_exists( 'BarabiCore_Button_Shortcode' ) ) {
	echo BarabiCore_Button_Shortcode::call_shortcode( $button_params );
}
