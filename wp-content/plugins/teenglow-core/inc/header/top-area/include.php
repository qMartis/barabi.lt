<?php

include_once TEENGLOW_CORE_INC_PATH . '/header/top-area/class-teenglowcore-top-area.php';
include_once TEENGLOW_CORE_INC_PATH . '/header/top-area/helper.php';

foreach ( glob( TEENGLOW_CORE_INC_PATH . '/header/top-area/dashboard/*/*.php' ) as $dashboard ) {
	include_once $dashboard;
}
