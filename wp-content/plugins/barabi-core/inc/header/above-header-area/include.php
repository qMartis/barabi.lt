<?php

include_once BARABI_CORE_INC_PATH . '/header/above-header-area/class-barabicore-above-header-area.php';
include_once BARABI_CORE_INC_PATH . '/header/above-header-area/helper.php';

foreach ( glob( BARABI_CORE_INC_PATH . '/header/above-header-area/dashboard/*/*.php' ) as $dashboard ) {
	include_once $dashboard;
}