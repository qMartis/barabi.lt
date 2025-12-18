<?php

include_once TEENGLOW_CORE_SHORTCODES_PATH . '/icon-with-text/class-teenglowcore-icon-with-text-shortcode.php';

foreach ( glob( TEENGLOW_CORE_SHORTCODES_PATH . '/icon-with-text/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
