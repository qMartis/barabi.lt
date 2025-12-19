<?php

include_once BARABI_CORE_SHORTCODES_PATH . '/single-image/class-barabicore-single-image-shortcode.php';

foreach ( glob( BARABI_CORE_SHORTCODES_PATH . '/single-image/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
