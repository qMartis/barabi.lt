<?php

include_once TEENGLOW_CORE_SHORTCODES_PATH . '/text-marquee/class-teenglowcore-text-marquee-shortcode.php';

foreach ( glob( TEENGLOW_CORE_INC_PATH . '/shortcodes/text-marquee/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
