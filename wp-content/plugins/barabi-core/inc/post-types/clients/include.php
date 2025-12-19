<?php

include_once BARABI_CORE_CPT_PATH . '/clients/helper.php';

foreach ( glob( BARABI_CORE_CPT_PATH . '/clients/dashboard/meta-box/*.php' ) as $module ) {
	include_once $module;
}
