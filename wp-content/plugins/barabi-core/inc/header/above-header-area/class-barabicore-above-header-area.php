<?php

class BarabiCore_Above_Header_Area {
	private static $instance;
	private $is_above_header_area_enabled;
	private $above_header_area_height;

	public function __construct() {
		add_action( 'wp', array( $this, 'set_variables' ), 11 ); //after header
		add_action( 'barabi_action_before_page_header', array( $this, 'load_template' ) );
		add_action( 'body_class', array( $this, 'add_body_class' ) );
	}

	public static function get_instance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	function is_top_area_enabled() {
		$above_header_area_enabled = barabi_core_get_post_value_through_levels( 'qodef_above_header_area_header' ) === 'yes';

		if ( is_404() ) {
			$above_header_area_enabled = false;
		}

		$this->is_above_header_area_enabled = $above_header_area_enabled;
	}

	public function set_variables() {
		$this->is_top_area_enabled();
	}

	public function load_template() {
		$parameters = array(
			'show_header_area' => $this->is_above_header_area_enabled,
		);

		barabi_core_template_part( 'header/above-header-area/', 'templates/above-header-area', '', $parameters );
	}

	public function add_body_class( $classes ) {
		if ( $this->is_above_header_area_enabled ) {
			$classes[] = 'qodef-above-header-area--enabled';
		}

		return $classes;
	}
}

BarabiCore_Above_Header_Area::get_instance();
