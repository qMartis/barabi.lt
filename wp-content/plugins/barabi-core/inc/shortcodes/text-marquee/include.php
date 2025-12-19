<?php

include_once BARABI_CORE_SHORTCODES_PATH . '/text-marquee/class-barabicore-text-marquee-shortcode.php';

foreach ( glob( BARABI_CORE_INC_PATH . '/shortcodes/text-marquee/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
