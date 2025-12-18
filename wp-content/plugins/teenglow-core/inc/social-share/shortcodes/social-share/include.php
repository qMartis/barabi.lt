<?php

include_once TEENGLOW_CORE_INC_PATH . '/social-share/shortcodes/social-share/class-teenglowcore-social-share-shortcode.php';

foreach ( glob( TEENGLOW_CORE_INC_PATH . '/social-share/shortcodes/social-share/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
