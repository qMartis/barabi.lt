<?php

include_once BARABI_CORE_SHORTCODES_PATH . '/info-section/class-barabicore-info-section-shortcode.php';

foreach ( glob( BARABI_CORE_SHORTCODES_PATH . '/info-section/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
