<?php

if ( ! function_exists( 'barabi_core_add_admin_user_options' ) ) {
	/**
	 * Function that add global user options
	 */
	function barabi_core_add_admin_user_options() {
		$qode_framework     = qode_framework_get_framework_root();
		$roles_social_scope = apply_filters( 'barabi_core_filter_role_social_array', array( 'administrator', 'author' ) );

		$additional_user_data_page = $qode_framework->add_options_page(
			array(
				'scope' => array( 'administrator', 'author' ),
				'type'  => 'user',
				'title' => esc_html__( 'Additional User Data', 'barabi-core' ),
				'slug'  => 'admin-additional-user-data-options',
			)
		);
		if ( $additional_user_data_page ) {
			$additional_user_data_page->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_user_position',
					'title'       => esc_html__( 'Position', 'barabi-core' ),
					'description' => esc_html__( 'Enter user position', 'barabi-core' ),
				)
			);
			// Hook to include additional options after module options
			do_action( 'castella_core_action_after_admin_user_options_map', $additional_user_data_page );
		}

		$page = $qode_framework->add_options_page(
			array(
				'scope' => $roles_social_scope,
				'type'  => 'user',
				'title' => esc_html__( 'Social Networks', 'barabi-core' ),
				'slug'  => 'admin-options',
			)
		);

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_user_facebook',
					'title'       => esc_html__( 'Facebook', 'barabi-core' ),
					'description' => esc_html__( 'Enter user Facebook profile URL', 'barabi-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_user_instagram',
					'title'       => esc_html__( 'Instagram', 'barabi-core' ),
					'description' => esc_html__( 'Enter user Instagram profile URL', 'barabi-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_user_twitter',
					'title'       => esc_html__( 'Twitter', 'barabi-core' ),
					'description' => esc_html__( 'Enter user Twitter profile URL', 'barabi-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_user_linkedin',
					'title'       => esc_html__( 'LinkedIn', 'barabi-core' ),
					'description' => esc_html__( 'Enter user LinkedIn profile URL', 'barabi-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_user_pinterest',
					'title'       => esc_html__( 'Pinterest', 'barabi-core' ),
					'description' => esc_html__( 'Enter user Pinterest profile URL', 'barabi-core' ),
				)
			);

			// Hook to include additional options after module options
			do_action( 'barabi_core_action_after_admin_user_options_map', $page );
		}
	}

	add_action( 'barabi_core_action_register_role_custom_fields', 'barabi_core_add_admin_user_options' );
}
