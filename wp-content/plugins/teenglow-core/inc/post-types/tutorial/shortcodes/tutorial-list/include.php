<?php

include_once TEENGLOW_CORE_CPT_PATH . '/tutorial/shortcodes/tutorial-list/class-teenglowcore-tutorial-list-shortcode.php';

foreach ( glob( TEENGLOW_CORE_CPT_PATH . '/tutorial/shortcodes/tutorial-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
