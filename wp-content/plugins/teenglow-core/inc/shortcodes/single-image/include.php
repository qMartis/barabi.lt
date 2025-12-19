<?php

include_once TEENGLOW_CORE_SHORTCODES_PATH . '/single-image/class-teenglowcore-single-image-shortcode.php';

foreach ( glob( TEENGLOW_CORE_SHORTCODES_PATH . '/single-image/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
