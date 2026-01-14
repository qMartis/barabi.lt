<?php
/*
Template Name: Timetable Event
*/
get_header();

// Include event content template
if ( barabi_is_installed( 'core' ) ) {
	barabi_core_template_part( 'plugins/timetable', 'templates/content' );
}

get_footer();
