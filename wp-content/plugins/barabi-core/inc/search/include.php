<?php

include_once BARABI_CORE_INC_PATH . '/search/class-barabicore-search.php';
include_once BARABI_CORE_INC_PATH . '/search/helper.php';
include_once BARABI_CORE_INC_PATH . '/search/dashboard/admin/search-options.php';

foreach ( glob( BARABI_CORE_INC_PATH . '/search/layouts/*/include.php' ) as $layout ) {
	include_once $layout;
}
