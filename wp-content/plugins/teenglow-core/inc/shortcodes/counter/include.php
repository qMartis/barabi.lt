<?php

include_once TEENGLOW_CORE_SHORTCODES_PATH . '/counter/class-teenglowcore-counter-shortcode.php';

foreach ( glob( TEENGLOW_CORE_SHORTCODES_PATH . '/counter/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
