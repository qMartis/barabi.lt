<?php
$params                      = array();
$params['layout']            = 'dropdown';
$params['icon_font']         = 'font-awesome';

if( class_exists( 'TeenglowCore_Social_Share_Shortcode' ) ) {
	echo TeenglowCore_Social_Share_Shortcode::call_shortcode($params);
}