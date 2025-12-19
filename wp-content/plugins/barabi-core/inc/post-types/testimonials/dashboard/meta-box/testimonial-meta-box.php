<?php

if ( ! function_exists( 'barabi_core_add_testimonials_meta_box' ) ) {
	/**
	 * Function that adds fields for testimonials
	 */
	function barabi_core_add_testimonials_meta_box() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope' => array( 'testimonials' ),
				'type'  => 'meta',
				'slug'  => 'testimonials',
				'title' => esc_html__( 'Testimonials Parameters', 'barabi-core' ),
			)
		);

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_testimonials_title',
					'title'      => esc_html__( 'Title', 'barabi-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'textarea',
					'name'       => 'qodef_testimonials_text',
					'title'      => esc_html__( 'Text', 'barabi-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_testimonials_author',
					'title'      => esc_html__( 'Author', 'barabi-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_testimonials_author_job',
					'title'      => esc_html__( 'Author Job Title', 'barabi-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_testimonials_author_age',
					'title'      => esc_html__( 'Author Age (Years)', 'barabi-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_testimonials_rating',
					'title'      => esc_html__( 'Rating', 'barabi-core' ),
					'options'    => array(
						'' => esc_html__( 'No Rating', 'barabi-core' ),
						'5' => esc_html__( 'Five Stars', 'barabi-core' ),
						'4' => esc_html__( 'Four Stars', 'barabi-core' ),
						'3' => esc_html__( 'Three Stars', 'barabi-core' ),
						'2' => esc_html__( 'Two Stars', 'barabi-core' ),
						'1' => esc_html__( 'One Star', 'barabi-core' ),
					),
					'deafult_value' => ''
				)
			);

			// Hook to include additional options after module options
			do_action( 'barabi_core_action_after_testimonials_meta_box_map', $page );
		}
	}

	add_action( 'barabi_core_action_default_meta_boxes_init', 'barabi_core_add_testimonials_meta_box' );
}
