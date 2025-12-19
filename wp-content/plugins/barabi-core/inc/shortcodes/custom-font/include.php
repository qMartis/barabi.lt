<?php

include_once BARABI_CORE_SHORTCODES_PATH . '/custom-font/class-barabicore-custom-font-shortcode.php';

foreach ( glob( BARABI_CORE_SHORTCODES_PATH . '/custom-font/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
