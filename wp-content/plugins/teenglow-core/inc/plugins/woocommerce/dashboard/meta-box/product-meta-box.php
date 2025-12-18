<?php

if ( ! function_exists( 'teenglow_core_add_product_single_meta_box' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function teenglow_core_add_product_single_meta_box() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope' => array( 'product' ),
				'type'  => 'meta',
				'slug'  => 'product-list',
				'title' => esc_html__( 'Product List', 'teenglow-core' ),
			)
		);

		if ( $page ) {

			$page->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_woo_single_layout',
					'title'       => esc_html__( 'Product layout', 'teenglow-core' ),
					'description' => esc_html__( 'Choose a default layout for single product page', 'teenglow-core' ),
					'options'     => array(
						''         => esc_html__( 'Default', 'teenglow-core' ),
						'standard' => esc_html__( 'Standard', 'teenglow-core' ),
						'gallery'  => esc_html__( 'Gallery', 'teenglow-core' ),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_woo_single_page_content_padding',
					'title'       => esc_html__( 'Page Content Padding', 'teenglow-core' ),
					'description' => esc_html__( 'Set padding that will be applied for page content in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'teenglow-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_woo_single_page_content_padding_mobile',
					'title'       => esc_html__( 'Page Content Padding Mobile', 'teenglow-core' ),
					'description' => esc_html__( 'Set padding that will be applied for page content on mobile screens (1024px and below) in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'teenglow-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_single_thumb_images_position',
					'title'         => esc_html__( 'Set Thumbnail Images Position', 'teenglow-core' ),
					'description'   => esc_html__( 'Choose position of the thumbnail images on single product page relative to featured image', 'teenglow-core' ),
					'options'       => array(
						''      => esc_html__( 'Default', 'teenglow-core' ),
						'below' => esc_html__( 'Below', 'teenglow-core' ),
						'left'  => esc_html__( 'Left', 'teenglow-core' ),
					),
					'default_value' => '',
					'dependency'    => array(
						'show' => array(
							'qodef_woo_single_layout' => array(
								'values'        => array( '', 'standard' ),
								'default_value' => '',
							),
						),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_product_list_image',
					'title'       => esc_html__( 'Product List Image', 'teenglow-core' ),
					'description' => esc_html__( 'Upload image to be displayed on product list instead of featured image', 'teenglow-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_masonry_image_dimension_product',
					'title'       => esc_html__( 'Image Dimension', 'teenglow-core' ),
					'description' => esc_html__( 'Choose an image layout for product list. If you are using fixed image proportions on the list, choose an option other than default', 'teenglow-core' ),
					'options'     => teenglow_core_get_select_type_options_pool( 'masonry_image_dimension' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_show_new_sign',
					'title'         => esc_html__( 'Show New Sign', 'teenglow-core' ),
					'description'   => esc_html__( 'Enabling this option will show "New Sign" mark on product.', 'teenglow-core' ),
					'options'       => teenglow_core_get_select_type_options_pool( 'no_yes' ),
					'default_value' => 'no',
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'textarea',
					'name'        => 'qodef_product_list_excerpt',
					'title'       => esc_html__( 'Product List Excerpt', 'teenglow-core' ),
					'description' => esc_html__( 'Additional excerpt that will be shown only in product list shortcode. Default except will be shown if this field is left empty.', 'teenglow-core' ),
				)
			);

			// Hook to include additional options after module options
			do_action( 'teenglow_core_action_after_product_single_meta_box_map', $page );
		}
	}

	add_action( 'teenglow_core_action_default_meta_boxes_init', 'teenglow_core_add_product_single_meta_box' );
}
