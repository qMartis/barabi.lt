<?php

include_once BARABI_CORE_SHORTCODES_PATH . '/tabs/class-barabicore-tab-shortcode.php';
include_once BARABI_CORE_SHORTCODES_PATH . '/tabs/class-barabicore-tab-child-shortcode.php';

foreach ( glob( BARABI_CORE_SHORTCODES_PATH . '/tabs/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
