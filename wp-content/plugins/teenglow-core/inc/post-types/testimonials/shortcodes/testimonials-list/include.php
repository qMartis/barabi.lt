<?php

include_once TEENGLOW_CORE_CPT_PATH . '/testimonials/shortcodes/testimonials-list/class-teenglowcore-testimonials-list-shortcode.php';

foreach ( glob( TEENGLOW_CORE_CPT_PATH . '/testimonials/shortcodes/testimonials-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
