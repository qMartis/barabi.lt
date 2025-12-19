<?php

include_once BARABI_CORE_CPT_PATH . '/tutorial/shortcodes/tutorial-list/class-barabicore-tutorial-list-shortcode.php';

foreach ( glob( BARABI_CORE_CPT_PATH . '/tutorial/shortcodes/tutorial-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
