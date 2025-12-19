<?php

include_once TEENGLOW_CORE_SHORTCODES_PATH . '/custom-font/class-teenglowcore-custom-font-shortcode.php';

foreach ( glob( TEENGLOW_CORE_SHORTCODES_PATH . '/custom-font/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
