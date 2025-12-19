<?php

get_header();

$params                  = array();
$params['template_slug'] = 'shortcode';

// Include cpt content template
teenglow_core_template_part( 'post-types/tutorial', 'templates/content', '', $params );

get_footer();
