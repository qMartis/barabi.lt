<?php

if ( ! function_exists( 'barabi_core_add_import_sub_page_to_list' ) ) {
	/**
	 * Function that add additional sub-page item into welcome page list
	 *
	 * @param array $sub_pages
	 *
	 * @return array
	 */
	function barabi_core_add_import_sub_page_to_list( $sub_pages ) {
		$sub_pages[] = 'BarabiCore_Dashboard_Import_Page';

		return $sub_pages;
	}

	add_filter( 'barabi_core_filter_add_welcome_sub_page', 'barabi_core_add_import_sub_page_to_list', 11 );
}

if ( class_exists( 'BarabiCore_Dashboard_Sub_Page' ) ) {
	class BarabiCore_Dashboard_Import_Page extends BarabiCore_Dashboard_Sub_Page {

		public function __construct() {
			parent::__construct();
		}

		public function add_sub_page() {
			$this->set_base( 'import' );
			$this->set_title( esc_html__( 'Import', 'barabi-core' ) );
			$this->set_atts( $this->set_atributtes() );
		}

		public function set_atributtes() {
			$params = array();

			$iparams = BarabiCore_Dashboard::get_instance()->get_import_params();
			if ( is_array( $iparams ) && isset( $iparams['submit'] ) ) {
				$params['submit'] = $iparams['submit'];
			}

			return $params;
		}
	}
}
