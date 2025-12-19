<?php

include_once BARABI_CORE_SHORTCODES_PATH . '/icon-with-text/class-barabicore-icon-with-text-shortcode.php';

foreach ( glob( BARABI_CORE_SHORTCODES_PATH . '/icon-with-text/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
