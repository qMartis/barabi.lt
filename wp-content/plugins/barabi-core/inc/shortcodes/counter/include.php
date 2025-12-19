<?php

include_once BARABI_CORE_SHORTCODES_PATH . '/counter/class-barabicore-counter-shortcode.php';

foreach ( glob( BARABI_CORE_SHORTCODES_PATH . '/counter/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
