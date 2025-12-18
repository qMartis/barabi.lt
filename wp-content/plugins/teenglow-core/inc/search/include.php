<?php

include_once TEENGLOW_CORE_INC_PATH . '/search/class-teenglowcore-search.php';
include_once TEENGLOW_CORE_INC_PATH . '/search/helper.php';
include_once TEENGLOW_CORE_INC_PATH . '/search/dashboard/admin/search-options.php';

foreach ( glob( TEENGLOW_CORE_INC_PATH . '/search/layouts/*/include.php' ) as $layout ) {
	include_once $layout;
}
