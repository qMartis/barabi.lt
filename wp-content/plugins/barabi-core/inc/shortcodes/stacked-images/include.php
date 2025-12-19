<?php

include_once BARABI_CORE_SHORTCODES_PATH . '/stacked-images/class-barabicore-stacked-images-shortcode.php';

foreach ( glob( BARABI_CORE_SHORTCODES_PATH . '/stacked-images/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
