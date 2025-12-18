<?php

if ( ! function_exists( 'teenglow_child_theme_enqueue_scripts' ) ) {
	/**
	 * Function that enqueue theme's child style
	 */
	function teenglow_child_theme_enqueue_scripts() {
		$main_style = 'teenglow-main';

		wp_enqueue_style( 'teenglow-child-style', get_stylesheet_directory_uri() . '/style.css', array( $main_style ) );
	}

	add_action( 'wp_enqueue_scripts', 'teenglow_child_theme_enqueue_scripts' );
}
