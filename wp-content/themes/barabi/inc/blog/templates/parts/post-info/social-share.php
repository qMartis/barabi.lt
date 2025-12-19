<?php
$params                      = array();
$params['layout']            = 'dropdown';
$params['icon_font']         = 'font-awesome';

if( class_exists( 'BarabiCore_Social_Share_Shortcode' ) ) {
	echo BarabiCore_Social_Share_Shortcode::call_shortcode($params);
}