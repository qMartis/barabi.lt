<?php

include_once TEENGLOW_CORE_CPT_PATH . '/clients/shortcodes/clients-list/class-teenglowcore-clients-list-shortcode.php';

foreach ( glob( TEENGLOW_CORE_CPT_PATH . '/clients/shortcodes/clients-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
