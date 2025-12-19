<?php

include_once BARABI_CORE_SHORTCODES_PATH . '/countdown/class-barabicore-countdown-shortcode.php';

foreach ( glob( BARABI_CORE_SHORTCODES_PATH . '/countdown/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
