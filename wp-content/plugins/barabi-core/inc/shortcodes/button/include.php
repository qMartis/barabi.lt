<?php

include_once BARABI_CORE_SHORTCODES_PATH . '/button/class-barabicore-button-shortcode.php';

foreach ( glob( BARABI_CORE_SHORTCODES_PATH . '/button/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
