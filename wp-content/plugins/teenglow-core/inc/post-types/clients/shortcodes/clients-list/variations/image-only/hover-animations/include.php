<?php

include_once TEENGLOW_CORE_CPT_PATH . '/clients/shortcodes/clients-list/variations/image-only/hover-animations/hover-animations.php';

foreach ( glob( TEENGLOW_CORE_CPT_PATH . '/clients/shortcodes/clients-list/variations/image-only/hover-animations/*/include.php' ) as $animation ) {
	include_once $animation;
}
