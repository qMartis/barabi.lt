<?php

include_once TEENGLOW_CORE_SHORTCODES_PATH . '/banner/class-teenglowcore-banner-shortcode.php';

foreach ( glob( TEENGLOW_CORE_INC_PATH . '/shortcodes/banner/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
