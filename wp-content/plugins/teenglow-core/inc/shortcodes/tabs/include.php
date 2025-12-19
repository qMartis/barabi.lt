<?php

include_once TEENGLOW_CORE_SHORTCODES_PATH . '/tabs/class-teenglowcore-tab-shortcode.php';
include_once TEENGLOW_CORE_SHORTCODES_PATH . '/tabs/class-teenglowcore-tab-child-shortcode.php';

foreach ( glob( TEENGLOW_CORE_SHORTCODES_PATH . '/tabs/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
