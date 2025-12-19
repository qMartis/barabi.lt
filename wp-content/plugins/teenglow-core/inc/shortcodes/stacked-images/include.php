<?php

include_once TEENGLOW_CORE_SHORTCODES_PATH . '/stacked-images/class-teenglowcore-stacked-images-shortcode.php';

foreach ( glob( TEENGLOW_CORE_SHORTCODES_PATH . '/stacked-images/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
