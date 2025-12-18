<?php

if ( ! function_exists( 'teenglow_core_add_woocommerce_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function teenglow_core_add_woocommerce_options() {
		$qode_framework = qode_framework_get_framework_root();

		$list_item_layouts = apply_filters( 'teenglow_core_filter_product_list_layouts', array() );
		$options_map       = teenglow_core_get_variations_options_map( $list_item_layouts );

		$page = $qode_framework->add_options_page(
			array(
				'scope'       => TEENGLOW_CORE_OPTIONS_NAME,
				'type'        => 'admin',
				'slug'        => 'woocommerce',
				'icon'        => 'fa fa-book',
				'title'       => esc_html__( 'WooCommerce', 'teenglow-core' ),
				'description' => esc_html__( 'Global WooCommerce Options', 'teenglow-core' ),
				'layout'      => 'tabbed',
			)
		);

		if ( $page ) {

			$list_tab = $page->add_tab_element(
				array(
					'name'        => 'tab-list',
					'icon'        => 'fa fa-cog',
					'title'       => esc_html__( 'Product List', 'teenglow-core' ),
					'description' => esc_html__( 'Settings related to product list', 'teenglow-core' ),
				)
			);

			if ( $options_map['visibility'] ) {
				$list_tab->add_field_element(
					array(
						'field_type'    => 'select',
						'name'          => 'qodef_product_list_item_layout',
						'title'         => esc_html__( 'Item Layout', 'teenglow-core' ),
						'description'   => esc_html__( 'Choose layout for list item on shop lists', 'teenglow-core' ),
						'options'       => array(
							'info-below'    => esc_html__( 'Info Below', 'teenglow-core' ),
							'info-on-image' => esc_html__( 'Info On Image', 'teenglow-core' ),
						),
						'default_value' => 'info-below',
					)
				);
			}

			$list_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_woo_product_list_columns',
					'title'       => esc_html__( 'Number of Columns', 'teenglow-core' ),
					'description' => esc_html__( 'Choose number of columns for product list on shop pages', 'teenglow-core' ),
					'options'     => teenglow_core_get_select_type_options_pool( 'columns_number' ),
				)
			);

			$list_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_woo_product_list_columns_space',
					'title'       => esc_html__( 'Items Horizontal Spacing', 'teenglow-core' ),
					'description' => esc_html__( 'Choose horizontal space between items for product list on shop pages', 'teenglow-core' ),
					'options'     => teenglow_core_get_select_type_options_pool( 'items_space' ),
				)
			);

			$woo_product_list_columns_space_row = $list_tab->add_row_element(
				array(
					'name'       => 'qodef_woo_product_list_columns_space_row',
					'dependency' => array(
						'show' => array(
							'qodef_woo_product_list_columns_space' => array(
								'values'        => 'custom',
								'default_value' => '',
							),
						),
					),
				)
			);

			$woo_product_list_columns_space_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_woo_product_list_columns_space_custom',
					'title'       => esc_html__( 'Custom Horizontal Spacing', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$woo_product_list_columns_space_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_woo_product_list_columns_space_custom_1440',
					'title'       => esc_html__( 'Custom Horizontal Spacing - 1440', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 1440px', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$woo_product_list_columns_space_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_woo_product_list_columns_space_custom_1024',
					'title'       => esc_html__( 'Custom Horizontal Spacing - 1024', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 1024px', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$woo_product_list_columns_space_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_woo_product_list_columns_space_custom_680',
					'title'       => esc_html__( 'Custom Horizontal Spacing - 680', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 680px', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$list_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_woo_product_list_columns_vertical_space',
					'title'       => esc_html__( 'Items Vertical Spacing', 'teenglow-core' ),
					'description' => esc_html__( 'Choose vertical space between items for product list on shop pages', 'teenglow-core' ),
					'options'     => teenglow_core_get_select_type_options_pool( 'items_space' ),
				)
			);

			$woo_product_list_columns_vertical_space_row = $list_tab->add_row_element(
				array(
					'name'       => 'qodef_woo_product_list_columns_vertical_space_row',
					'dependency' => array(
						'show' => array(
							'qodef_woo_product_list_columns_vertical_space' => array(
								'values'        => 'custom',
								'default_value' => '',
							),
						),
					),
				)
			);

			$woo_product_list_columns_vertical_space_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_woo_product_list_columns_vertical_space_custom',
					'title'       => esc_html__( 'Custom Vertical Spacing', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$woo_product_list_columns_vertical_space_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_woo_product_list_columns_vertical_space_custom_1440',
					'title'       => esc_html__( 'Custom Vertical Spacing - 1440', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 1440px', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$woo_product_list_columns_vertical_space_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_woo_product_list_columns_vertical_space_custom_1024',
					'title'       => esc_html__( 'Custom Vertical Spacing - 1024', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 1024px', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$woo_product_list_columns_vertical_space_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_woo_product_list_columns_vertical_space_custom_680',
					'title'       => esc_html__( 'Custom Vertical Spacing - 680', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 680px', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$list_tab->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_woo_product_list_products_per_page',
					'title'       => esc_html__( 'Products per Page', 'teenglow-core' ),
					'description' => esc_html__( 'Set number of products on shop pages. Default value is 12', 'teenglow-core' ),
				)
			);

			$list_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_woo_product_list_title_tag',
					'title'       => esc_html__( 'Title Tag', 'teenglow-core' ),
					'description' => esc_html__( 'Choose title tag for product list item on shop pages', 'teenglow-core' ),
					'options'     => teenglow_core_get_select_type_options_pool( 'title_tag' ),
				)
			);

			$list_tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_woo_product_list_sidebar_layout',
					'title'         => esc_html__( 'Sidebar Layout', 'teenglow-core' ),
					'description'   => esc_html__( 'Choose default sidebar layout for shop pages', 'teenglow-core' ),
					'default_value' => 'no-sidebar',
					'options'       => teenglow_core_get_select_type_options_pool( 'sidebar_layouts', false ),
				)
			);

			$custom_sidebars = teenglow_core_get_custom_sidebars();
			if ( ! empty( $custom_sidebars ) && count( $custom_sidebars ) > 1 ) {
				$list_tab->add_field_element(
					array(
						'field_type'  => 'select',
						'name'        => 'qodef_woo_product_list_custom_sidebar',
						'title'       => esc_html__( 'Custom Sidebar', 'teenglow-core' ),
						'description' => esc_html__( 'Choose a custom sidebar to display on shop pages', 'teenglow-core' ),
						'options'     => $custom_sidebars,
					)
				);
			}

			$list_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_woo_product_list_sidebar_grid_gutter',
					'title'       => esc_html__( 'Set Grid Gutter', 'teenglow-core' ),
					'description' => esc_html__( 'Choose grid gutter size to set space between content and sidebar', 'teenglow-core' ),
					'options'     => teenglow_core_get_select_type_options_pool( 'items_space' ),
				)
			);

			$woo_product_list_sidebar_grid_gutter_row = $list_tab->add_row_element(
				array(
					'name'       => 'qodef_woo_product_list_sidebar_grid_gutter_row',
					'dependency' => array(
						'show' => array(
							'qodef_woo_product_list_sidebar_grid_gutter' => array(
								'values'        => 'custom',
								'default_value' => '',
							),
						),
					),
				)
			);

			$woo_product_list_sidebar_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_woo_product_list_sidebar_grid_gutter_custom',
					'title'       => esc_html__( 'Custom Grid Gutter', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$woo_product_list_sidebar_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_woo_product_list_sidebar_grid_gutter_custom_1440',
					'title'       => esc_html__( 'Custom Grid Gutter - 1440', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 1440px', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$woo_product_list_sidebar_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_woo_product_list_sidebar_grid_gutter_custom_1024',
					'title'       => esc_html__( 'Custom Grid Gutter - 1024', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 1024px', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$woo_product_list_sidebar_grid_gutter_row->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_woo_product_list_sidebar_grid_gutter_custom_680',
					'title'       => esc_html__( 'Custom Grid Gutter - 680', 'teenglow-core' ),
					'description' => esc_html__( 'Enter grid gutter size in pixels for screen size below 680px', 'teenglow-core' ),
					'args'        => array(
						'col_width' => 3,
					),
				)
			);

			$list_tab->add_field_element(
				array(
					'field_type'    => 'yesno',
					'default_value' => 'no',
					'name'          => 'qodef_woo_enable_percent_sign_value',
					'title'         => esc_html__( 'Enable Percent Sign', 'teenglow-core' ),
					'description'   => esc_html__( 'Enabling this option will show percent value mark instead of sale label on products', 'teenglow-core' ),
				)
			);

			// Hook to include additional options after section module options
			do_action( 'teenglow_core_action_after_woo_product_list_options_map', $list_tab );

			$single_tab = $page->add_tab_element(
				array(
					'name'        => 'tab-single',
					'icon'        => 'fa fa-cog',
					'title'       => esc_html__( 'Product Single', 'teenglow-core' ),
					'description' => esc_html__( 'Settings related to product single', 'teenglow-core' ),
				)
			);

			$single_tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_woo_single_layout',
					'title'         => esc_html__( 'Product layout', 'teenglow-core' ),
					'description'   => esc_html__( 'Choose a default layout for single product page', 'teenglow-core' ),
					'options'       => array(
						'standard' => esc_html__( 'Standard', 'teenglow-core' ),
						'gallery'  => esc_html__( 'Gallery', 'teenglow-core' ),
					),
					'default_value' => 'standard',
				)
			);

			$single_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_woo_single_enable_page_title',
					'title'       => esc_html__( 'Enable Page Title', 'teenglow-core' ),
					'description' => esc_html__( 'Use this option to enable/disable page title on single product page', 'teenglow-core' ),
					'options'     => teenglow_core_get_select_type_options_pool( 'no_yes' ),
				)
			);

			$single_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_woo_single_title_tag',
					'title'       => esc_html__( 'Title Tag', 'teenglow-core' ),
					'description' => esc_html__( 'Choose title tag for product on single product page', 'teenglow-core' ),
					'options'     => teenglow_core_get_select_type_options_pool( 'title_tag' ),
				)
			);

			$single_tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_woo_single_enable_image_lightbox',
					'title'         => esc_html__( 'Enable Image Lightbox', 'teenglow-core' ),
					'description'   => esc_html__( 'Enabling this option will set lightbox functionality for images on single product page', 'teenglow-core' ),
					'options'       => array(
						''               => esc_html__( 'None', 'teenglow-core' ),
						'photo-swipe'    => esc_html__( 'Photo Swipe', 'teenglow-core' ),
						'magnific-popup' => esc_html__( 'Magnific Popup', 'teenglow-core' ),
					),
					'default_value' => 'magnific-popup',
				)
			);

			$single_tab->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_woo_single_enable_image_zoom',
					'title'         => esc_html__( 'Enable Zoom Magnifier', 'teenglow-core' ),
					'description'   => esc_html__( 'Enabling this option will show magnifier image on hover on single product page', 'teenglow-core' ),
					'default_value' => 'yes',
				)
			);

			$single_tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_woo_single_thumb_images_position',
					'title'         => esc_html__( 'Set Thumbnail Images Position', 'teenglow-core' ),
					'description'   => esc_html__( 'Choose position of the thumbnail images on single product page relative to featured image', 'teenglow-core' ),
					'options'       => array(
						'below' => esc_html__( 'Below', 'teenglow-core' ),
						'left'  => esc_html__( 'Left', 'teenglow-core' ),
					),
					'default_value' => 'below',
				)
			);

			$single_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_woo_single_thumbnail_images_columns',
					'title'       => esc_html__( 'Number of Thumbnail Image Columns', 'teenglow-core' ),
					'description' => esc_html__( 'Set a number of columns for thumbnail images on single product pages. This option will be applied if Thumbnail Images Position is \'Below\'', 'teenglow-core' ),
					'options'     => teenglow_core_get_select_type_options_pool( 'columns_number' ),
				)
			);

			$single_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_woo_single_related_product_list_columns',
					'title'       => esc_html__( 'Number of Related Product Columns', 'teenglow-core' ),
					'description' => esc_html__( 'Set a number of columns for related products on single product pages', 'teenglow-core' ),
					'options'     => teenglow_core_get_select_type_options_pool( 'columns_number' ),
				)
			);

			$single_tab->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_woo_single_enable_fake_live_viewing',
					'title'         => esc_html__( 'Enable Fake Live Viewing', 'teenglow-core' ),
					'description'   => esc_html__( 'Enabling this option will show live viewing message on single product pages', 'teenglow-core' ),
					'default_value' => 'yes',
				)
			);

			$flw_section = $single_tab->add_section_element(
				array(
					'name'        => 'qodef_woo_single_fake_live_viewing_section',
					'title'       => esc_html__( 'Fake Live Viewing', 'teenglow-core' ),
					'description' => esc_html__( 'Fake Live Viewing settings', 'teenglow-core' ),
					'dependency'  => array(
						'show' => array(
							'qodef_woo_single_enable_fake_live_viewing' => array(
								'values'        => 'yes',
								'default_value' => 'yes',
							),
						),
					),
				)
			);

			$flw_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_woo_single_fake_live_viewing_min',
					'title'       => esc_html__( 'Min Viewers Count', 'teenglow-core' ),
					'description' => esc_html__( 'Set minimum count for number of fake live viewers.', 'teenglow-core' ),
				)
			);

			$flw_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_woo_single_fake_live_viewing_max',
					'title'       => esc_html__( 'Max Viewers Count', 'teenglow-core' ),
					'description' => esc_html__( 'Set maximum count for number of fake live viewers.', 'teenglow-core' ),
				)
			);

			$single_tab->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_woo_single_enable_sales_count',
					'title'         => esc_html__( 'Enable Sales Count', 'teenglow-core' ),
					'description'   => esc_html__( 'Enabling this option will show number of sales on single product pages', 'teenglow-core' ),
					'default_value' => 'yes',
				)
			);

			$single_tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_woo_single_sales_count_type',
					'title'         => esc_html__( 'Sales Type', 'teenglow-core' ),
					'description'   => esc_html__( 'Choose time period for fake sales count.', 'teenglow-core' ),
					'options'       => array(
						'fake'  => esc_html__( 'Fake', 'teenglow-core' ),
						'total' => esc_html__( 'Total', 'teenglow-core' ),
					),
					'default_value' => 'fake',
					'dependency'    => array(
						'show' => array(
							'qodef_woo_single_enable_sales_count' => array(
								'values'        => 'yes',
								'default_value' => 'yes',
							),
						),
					),
				)
			);

			$fsc_section = $single_tab->add_section_element(
				array(
					'name'        => 'qodef_woo_single_fake_sales_count_section',
					'title'       => esc_html__( 'Fake Sales Count', 'teenglow-core' ),
					'description' => esc_html__( 'Fake Sales Count settings', 'teenglow-core' ),
					'dependency'  => array(
						'show' => array(
							'qodef_woo_single_sales_count_type' => array(
								'values'        => 'fake',
								'default_value' => 'fake',
							),
						),
					),
				)
			);

			$fsc_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_woo_single_fake_sales_count_min',
					'title'       => esc_html__( 'Min Sales Count', 'teenglow-core' ),
					'description' => esc_html__( 'Set minimum count for number fake sales.', 'teenglow-core' ),
				)
			);

			$fsc_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_woo_single_fake_sales_count_max',
					'title'       => esc_html__( 'Max Sales Count', 'teenglow-core' ),
					'description' => esc_html__( 'Set maximum count for number of fake sales.', 'teenglow-core' ),
				)
			);

			$fsc_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_woo_single_fake_sales_time_period',
					'title'       => esc_html__( 'Time Period', 'teenglow-core' ),
					'description' => esc_html__( 'Choose time period for fake sales count.', 'teenglow-core' ),
					'options'     => array(
						''       => esc_html__( 'Default', 'teenglow-core' ),
						'minute' => esc_html__( 'Minutes', 'teenglow-core' ),
						'hour'   => esc_html__( 'Hours', 'teenglow-core' ),
						'day'    => esc_html__( 'Days', 'teenglow-core' ),
						'week'   => esc_html__( 'Weeks', 'teenglow-core' ),
					),
				)
			);

			$fsc_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_woo_single_fake_sales_time_frame',
					'title'       => esc_html__( 'Time Frame', 'teenglow-core' ),
					'description' => esc_html__( 'Enter custom time frame value.', 'teenglow-core' ),
				)
			);

			// Hook to include additional options after section module options
			do_action( 'teenglow_core_action_after_woo_product_single_options_map', $single_tab );

			// Hook to include additional options after module options
			do_action( 'teenglow_core_action_after_woo_options_map', $page );
		}
	}

	add_action( 'teenglow_core_action_default_options_init', 'teenglow_core_add_woocommerce_options', teenglow_core_get_admin_options_map_position( 'woocommerce' ) );
}
