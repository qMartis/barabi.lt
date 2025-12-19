<?php

include_once TEENGLOW_CORE_INC_PATH . '/blog/shortcodes/blog-list/class-teenglowcore-blog-list-shortcode.php';

foreach ( glob( TEENGLOW_CORE_INC_PATH . '/blog/shortcodes/blog-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
