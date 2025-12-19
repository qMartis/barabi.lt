<?php

include_once TEENGLOW_CORE_INC_PATH . '/header/above-header-area/class-teenglowcore-above-header-area.php';
include_once TEENGLOW_CORE_INC_PATH . '/header/above-header-area/helper.php';

foreach ( glob( TEENGLOW_CORE_INC_PATH . '/header/above-header-area/dashboard/*/*.php' ) as $dashboard ) {
	include_once $dashboard;
}