<?php

include_once TEENGLOW_CORE_SHORTCODES_PATH . '/countdown/class-teenglowcore-countdown-shortcode.php';

foreach ( glob( TEENGLOW_CORE_SHORTCODES_PATH . '/countdown/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
