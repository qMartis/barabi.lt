<?php

include_once TEENGLOW_CORE_SHORTCODES_PATH . '/button/class-teenglowcore-button-shortcode.php';

foreach ( glob( TEENGLOW_CORE_SHORTCODES_PATH . '/button/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
