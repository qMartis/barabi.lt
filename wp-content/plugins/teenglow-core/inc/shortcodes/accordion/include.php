<?php

include_once TEENGLOW_CORE_SHORTCODES_PATH . '/accordion/class-teenglowcore-accordion-shortcode.php';
include_once TEENGLOW_CORE_SHORTCODES_PATH . '/accordion/class-teenglowcore-accordion-child-shortcode.php';

foreach ( glob( TEENGLOW_CORE_SHORTCODES_PATH . '/accordion/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
