<?php

if ( class_exists( 'TeenglowCore_Dashboard_Rest_API' ) ) {
	class TeenglowCore_Dashboard_Registration extends TeenglowCore_Dashboard_Rest_API {
		private static $instance;

		public function __construct() {
			parent::__construct();
			$this->set_route( 'registration' );
		}

		/**
		 * @return TeenglowCore_Dashboard_Rest_API|TeenglowCore_Dashboard_Registration
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function localize_script( $global ) {
			$global['registrationThemeRoute'] = esc_attr( $this->get_namespace() . '/' . $this->get_route() );

			return $global;
		}

		public function register_rest_api_route() {

			register_rest_route(
				$this->get_namespace(),
				$this->get_route(),
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( TeenglowCore_Dashboard::get_instance(), 'purchase_code_registration' ),
					'permission_callback' => function () {
						return is_user_logged_in();
					},
					'args'                => array(
						'options' => array(
							'required'          => true,
							'validate_callback' => function ( $param, $request, $key ) {
								// Simple solution for validation can be 'is_array' value instead of callback function
								return is_array( $param ) ? $param : (array) strip_tags( $param );
							},
							'description'       => esc_html__( 'Options data is array with parameters', 'teenglow-core' ),
						),
					),
				)
			);
		}
	}

	TeenglowCore_Dashboard_Registration::get_instance();
}
