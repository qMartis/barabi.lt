<?php

include_once BARABI_CORE_CPT_PATH . '/clients/shortcodes/clients-list/class-barabicore-clients-list-shortcode.php';

foreach ( glob( BARABI_CORE_CPT_PATH . '/clients/shortcodes/clients-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
