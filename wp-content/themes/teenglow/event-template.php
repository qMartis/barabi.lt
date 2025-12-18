<?php
/*
Template Name: Timetable Event
*/
get_header();

// Include event content template
if ( teenglow_is_installed( 'core' ) ) {
	teenglow_core_template_part( 'plugins/timetable', 'templates/content' );
}

get_footer();
