<?php

include_once BARABI_CORE_SHORTCODES_PATH . '/banner/class-barabicore-banner-shortcode.php';

foreach ( glob( BARABI_CORE_INC_PATH . '/shortcodes/banner/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
