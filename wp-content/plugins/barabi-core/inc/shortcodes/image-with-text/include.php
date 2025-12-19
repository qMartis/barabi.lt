<?php

include_once BARABI_CORE_SHORTCODES_PATH . '/image-with-text/class-barabicore-image-with-text-shortcode.php';

foreach ( glob( BARABI_CORE_SHORTCODES_PATH . '/image-with-text/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
