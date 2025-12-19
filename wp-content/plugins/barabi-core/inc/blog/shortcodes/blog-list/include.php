<?php

include_once BARABI_CORE_INC_PATH . '/blog/shortcodes/blog-list/class-barabicore-blog-list-shortcode.php';

foreach ( glob( BARABI_CORE_INC_PATH . '/blog/shortcodes/blog-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
