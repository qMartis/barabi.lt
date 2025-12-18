<?php

include_once TEENGLOW_CORE_SHORTCODES_PATH . '/info-section/class-teenglowcore-info-section-shortcode.php';

foreach ( glob( TEENGLOW_CORE_SHORTCODES_PATH . '/info-section/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
