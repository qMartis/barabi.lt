<?php

include_once BARABI_CORE_CPT_PATH . '/testimonials/shortcodes/testimonials-list/class-barabicore-testimonials-list-shortcode.php';

foreach ( glob( BARABI_CORE_CPT_PATH . '/testimonials/shortcodes/testimonials-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
