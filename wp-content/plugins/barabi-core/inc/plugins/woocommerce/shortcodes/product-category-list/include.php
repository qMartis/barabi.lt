<?php

include_once BARABI_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-category-list/media-custom-fields.php';
include_once BARABI_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-category-list/class-barabicore-product-category-list-shortcode.php';

foreach ( glob( BARABI_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-category-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
