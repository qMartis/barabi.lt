<?php

if ( ! function_exists( 'teenglow_core_include_widgets' ) ) {
	/**
	 * Function that includes widgets
	 */
	function teenglow_core_include_widgets() {

		foreach ( glob( TEENGLOW_CORE_INC_PATH . '/widgets/*/include.php' ) as $widget ) {
			$is_disabled = teenglow_core_performance_get_option_value( dirname( $widget ), 'teenglow_core_performance_widget_' );

			if ( empty( $is_disabled ) ) {
				include_once $widget;
			}
		}
	}

	add_action( 'qode_framework_action_before_widgets_register', 'teenglow_core_include_widgets' );
}

if ( ! function_exists( 'teenglow_core_register_widgets' ) ) {
	/**
	 * Function that register widgets
	 */
	function teenglow_core_register_widgets() {
		$qode_framework = qode_framework_get_framework_root();
		$widgets        = apply_filters( 'teenglow_core_filter_register_widgets', array() );

		if ( ! empty( $widgets ) ) {
			foreach ( $widgets as $widget ) {
				$qode_framework->add_widget( new $widget() );
			}
		}
	}

	add_action( 'qode_framework_action_before_widgets_register', 'teenglow_core_register_widgets', 11 ); // Priority 11 set because include of files is called on default action 10
}
