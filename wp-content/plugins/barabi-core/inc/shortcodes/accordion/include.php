<?php

include_once BARABI_CORE_SHORTCODES_PATH . '/accordion/class-barabicore-accordion-shortcode.php';
include_once BARABI_CORE_SHORTCODES_PATH . '/accordion/class-barabicore-accordion-child-shortcode.php';

foreach ( glob( BARABI_CORE_SHORTCODES_PATH . '/accordion/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
