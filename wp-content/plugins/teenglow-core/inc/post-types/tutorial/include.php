<?php

include_once TEENGLOW_CORE_CPT_PATH . '/tutorial/helper.php';

foreach ( glob( TEENGLOW_CORE_CPT_PATH . '/tutorial/dashboard/admin/*.php' ) as $module ) {
	include_once $module;
}

foreach ( glob( TEENGLOW_CORE_CPT_PATH . '/tutorial/dashboard/meta-box/*.php' ) as $module ) {
	include_once $module;
}

foreach ( glob( TEENGLOW_CORE_CPT_PATH . '/tutorial/templates/*/include.php' ) as $single_part ) {
	include_once $single_part;
}
