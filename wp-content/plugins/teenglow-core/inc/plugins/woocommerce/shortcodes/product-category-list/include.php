<?php

include_once TEENGLOW_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-category-list/media-custom-fields.php';
include_once TEENGLOW_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-category-list/class-teenglowcore-product-category-list-shortcode.php';

foreach ( glob( TEENGLOW_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-category-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
