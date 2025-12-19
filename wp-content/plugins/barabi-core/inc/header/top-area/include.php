<?php

include_once BARABI_CORE_INC_PATH . '/header/top-area/class-barabicore-top-area.php';
include_once BARABI_CORE_INC_PATH . '/header/top-area/helper.php';

foreach ( glob( BARABI_CORE_INC_PATH . '/header/top-area/dashboard/*/*.php' ) as $dashboard ) {
	include_once $dashboard;
}
