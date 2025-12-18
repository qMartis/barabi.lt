<?php

$button_params = array(
	'custom_class'  => 'qodef-e-category-link',
	'button_layout' => 'filled',
	'size'          => 'full',
	'text'          => $category_name,
	'link'          => get_term_link( $category_slug, 'product_cat' ),
);

if ( class_exists( 'TeenglowCore_Button_Shortcode' ) ) {
	echo TeenglowCore_Button_Shortcode::call_shortcode( $button_params );
}
