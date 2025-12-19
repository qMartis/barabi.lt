<?php

include_once BARABI_CORE_INC_PATH . '/social-share/shortcodes/social-share/class-barabicore-social-share-shortcode.php';

foreach ( glob( BARABI_CORE_INC_PATH . '/social-share/shortcodes/social-share/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
