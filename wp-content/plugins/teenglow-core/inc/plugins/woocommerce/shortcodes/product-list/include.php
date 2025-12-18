<?php

include_once TEENGLOW_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-list/class-teenglowcore-product-list-shortcode.php';

foreach ( glob( TEENGLOW_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
