<?php

if ( ! function_exists( 'teenglow_core_add_testimonials_meta_box' ) ) {
	/**
	 * Function that adds fields for testimonials
	 */
	function teenglow_core_add_testimonials_meta_box() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope' => array( 'testimonials' ),
				'type'  => 'meta',
				'slug'  => 'testimonials',
				'title' => esc_html__( 'Testimonials Parameters', 'teenglow-core' ),
			)
		);

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_testimonials_title',
					'title'      => esc_html__( 'Title', 'teenglow-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'textarea',
					'name'       => 'qodef_testimonials_text',
					'title'      => esc_html__( 'Text', 'teenglow-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_testimonials_author',
					'title'      => esc_html__( 'Author', 'teenglow-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_testimonials_author_job',
					'title'      => esc_html__( 'Author Job Title', 'teenglow-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_testimonials_author_age',
					'title'      => esc_html__( 'Author Age (Years)', 'teenglow-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_testimonials_rating',
					'title'      => esc_html__( 'Rating', 'teenglow-core' ),
					'options'    => array(
						'' => esc_html__( 'No Rating', 'teenglow-core' ),
						'5' => esc_html__( 'Five Stars', 'teenglow-core' ),
						'4' => esc_html__( 'Four Stars', 'teenglow-core' ),
						'3' => esc_html__( 'Three Stars', 'teenglow-core' ),
						'2' => esc_html__( 'Two Stars', 'teenglow-core' ),
						'1' => esc_html__( 'One Star', 'teenglow-core' ),
					),
					'deafult_value' => ''
				)
			);

			// Hook to include additional options after module options
			do_action( 'teenglow_core_action_after_testimonials_meta_box_map', $page );
		}
	}

	add_action( 'teenglow_core_action_default_meta_boxes_init', 'teenglow_core_add_testimonials_meta_box' );
}
