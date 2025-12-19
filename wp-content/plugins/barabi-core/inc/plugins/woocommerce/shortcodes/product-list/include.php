<?php

include_once BARABI_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-list/class-barabicore-product-list-shortcode.php';

foreach ( glob( BARABI_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
