<?php

include_once TEENGLOW_CORE_SHORTCODES_PATH . '/image-with-text/class-teenglowcore-image-with-text-shortcode.php';

foreach ( glob( TEENGLOW_CORE_SHORTCODES_PATH . '/image-with-text/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
