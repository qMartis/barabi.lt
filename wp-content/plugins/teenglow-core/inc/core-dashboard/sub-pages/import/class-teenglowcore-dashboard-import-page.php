<?php

if ( ! function_exists( 'teenglow_core_add_import_sub_page_to_list' ) ) {
	/**
	 * Function that add additional sub-page item into welcome page list
	 *
	 * @param array $sub_pages
	 *
	 * @return array
	 */
	function teenglow_core_add_import_sub_page_to_list( $sub_pages ) {
		$sub_pages[] = 'TeenglowCore_Dashboard_Import_Page';

		return $sub_pages;
	}

	add_filter( 'teenglow_core_filter_add_welcome_sub_page', 'teenglow_core_add_import_sub_page_to_list', 11 );
}

if ( class_exists( 'TeenglowCore_Dashboard_Sub_Page' ) ) {
	class TeenglowCore_Dashboard_Import_Page extends TeenglowCore_Dashboard_Sub_Page {

		public function __construct() {
			parent::__construct();
		}

		public function add_sub_page() {
			$this->set_base( 'import' );
			$this->set_title( esc_html__( 'Import', 'teenglow-core' ) );
			$this->set_atts( $this->set_atributtes() );
		}

		public function set_atributtes() {
			$params = array();

			$iparams = TeenglowCore_Dashboard::get_instance()->get_import_params();
			if ( is_array( $iparams ) && isset( $iparams['submit'] ) ) {
				$params['submit'] = $iparams['submit'];
			}

			return $params;
		}
	}
}
