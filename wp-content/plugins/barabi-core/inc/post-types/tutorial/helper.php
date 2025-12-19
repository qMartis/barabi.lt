<?php

if ( ! function_exists( 'barabi_core_tutorial_has_single' ) ) {
	/**
	 * Function that check if custom post type has single page
	 *
	 * @return bool
	 */
	function barabi_core_tutorial_has_single() {
		return true;
	}
}

if ( ! function_exists( 'barabi_core_generate_tutorial_single_layout' ) ) {
	/**
	 * Function that return default layout for custom post type single page
	 *
	 * @return string
	 */
	function barabi_core_generate_tutorial_single_layout() {
		$tutorial_template = barabi_core_get_post_value_through_levels( 'qodef_tutorial_single_layout' );
		$tutorial_template = empty( $tutorial_template ) ? 'default' : $tutorial_template;

		return $tutorial_template;
	}

	add_filter( 'barabi_core_filter_tutorial_single_layout', 'barabi_core_generate_tutorial_single_layout' );
}

if ( ! function_exists( 'barabi_core_get_tutorial_holder_classes' ) ) {
	/**
	 * Function that return classes for the main tutorial holder
	 *
	 * @return string
	 */
	function barabi_core_get_tutorial_holder_classes() {
		$classes = array( '' );

		$classes[] = 'qodef-tutorial-single';

		$item_layout = barabi_core_generate_tutorial_single_layout();
		$classes[]   = 'qodef-item-layout--' . $item_layout;

		return implode( ' ', $classes );
	}
}

if ( ! function_exists( 'barabi_core_generate_tutorial_archive_with_shortcode' ) ) {
	/**
	 * Function that executes tutorial list shortcode with params on archive pages
	 *
	 * @param string $tax - type of taxonomy
	 * @param string $tax_slug - slug of taxonomy
	 */
	function barabi_core_generate_tutorial_archive_with_shortcode( $tax, $tax_slug ) {
		$params = array();

		$params['additional_params']          = 'tax';
		$params['tax']                        = $tax;
		$params['tax_slug']                   = $tax_slug;
		$params['layout']                     = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_item_layout' );
		$params['behavior']                   = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_behavior' );
		$params['columns']                    = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_columns' );
		$params['space']                      = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_space' );
		$params['space_custom']               = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_space_custom' );
		$params['space_custom_1440']          = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_space_custom_1440' );
		$params['space_custom_1024']          = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_space_custom_1024' );
		$params['space_custom_680']           = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_space_custom_680' );
		$params['vertical_space']             = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_vertical_space' );
		$params['vertical_space_custom']      = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_vertical_space_custom' );
		$params['vertical_space_custom_1440'] = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_vertical_space_custom_1440' );
		$params['vertical_space_custom_1024'] = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_vertical_space_custom_1024' );
		$params['vertical_space_custom_680']  = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_vertical_space_custom_680' );
		$params['columns_responsive']         = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_columns_responsive' );
		$params['columns_1440']               = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_columns_1440' );
		$params['columns_1366']               = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_columns_1366' );
		$params['columns_1024']               = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_columns_1024' );
		$params['columns_768']                = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_columns_768' );
		$params['columns_680']                = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_columns_680' );
		$params['columns_480']                = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_columns_480' );
		$params['slider_loop']                = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_slider_loop' );
		$params['slider_autoplay']            = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_slider_autoplay' );
		$params['slider_speed']               = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_slider_speed' );
		$params['slider_navigation']          = barabi_core_get_post_value_through_levels( 'navigation' );
		$params['slider_pagination']          = barabi_core_get_post_value_through_levels( 'pagination' );
		$params['pagination_type']            = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_pagination_type' );

		echo BarabiCore_Tutorial_List_Shortcode::call_shortcode( $params );
	}
}

if ( ! function_exists( 'barabi_core_is_tutorial_title_enabled' ) ) {
	/**
	 * Function that check is module enabled
	 *
	 * @param bool $is_enabled
	 *
	 * @return bool
	 */
	function barabi_core_is_tutorial_title_enabled( $is_enabled ) {
		if ( is_singular( 'tutorial' ) ) {
			$is_enabled = 'no' !== barabi_core_get_post_value_through_levels( 'qodef_enable_tutorial_title' );
		}

		return $is_enabled;
	}

	add_filter( 'barabi_filter_enable_page_title', 'barabi_core_is_tutorial_title_enabled' );
}

if ( ! function_exists( 'barabi_core_tutorial_title_grid' ) ) {
	/**
	 * Function that check is option enabled
	 *
	 * @param bool $enable_title_grid
	 *
	 * @return bool
	 */
	function barabi_core_tutorial_title_grid( $enable_title_grid ) {
		if ( is_singular( 'tutorial' ) ) {
			$enable_title_grid = 'no' !== barabi_core_get_post_value_through_levels( 'qodef_set_tutorial_title_area_in_grid' );
		}

		return $enable_title_grid;
	}

	add_filter( 'barabi_core_filter_page_title_grid', 'barabi_core_tutorial_title_grid' );
}

if ( ! function_exists( 'barabi_core_tutorial_breadcrumbs_title' ) ) {
	/**
	 * Improve main breadcrumb template with additional cases
	 *
	 * @param string|html $wrap_child
	 * @param array $settings
	 *
	 * @return string|html
	 */
	function barabi_core_tutorial_breadcrumbs_title( $wrap_child, $settings ) {
		if ( is_tax( 'tutorial-category' ) ) {
			$wrap_child  = '';
			$term_object = get_term( get_queried_object_id(), 'tutorial-category' );

			if ( isset( $term_object->parent ) && 0 !== $term_object->parent ) {
				$parent      = get_term( $term_object->parent );
				$wrap_child .= sprintf( $settings['link'], get_term_link( $parent->term_id ), $parent->name ) . $settings['separator'];
			}

			$wrap_child .= sprintf( $settings['current_item'], single_cat_title( '', false ) );
		} elseif ( is_singular( 'tutorial' ) ) {
			$wrap_child = '';
			$post_terms = wp_get_post_terms( get_the_ID(), 'tutorial-category' );

			if ( ! empty( $post_terms ) ) {
				$post_term = $post_terms[0];
				if ( isset( $post_term->parent ) && 0 !== $post_term->parent ) {
					$parent      = get_term( $post_term->parent );
					$wrap_child .= sprintf( $settings['link'], get_term_link( $parent->term_id ), $parent->name ) . $settings['separator'];
				}
				$wrap_child .= sprintf( $settings['link'], get_term_link( $post_term ), $post_term->name ) . $settings['separator'];
			}

			$wrap_child .= sprintf( $settings['current_item'], get_the_title() );
		}

		return $wrap_child;
	}

	add_filter( 'barabi_core_filter_breadcrumbs_content', 'barabi_core_tutorial_breadcrumbs_title', 10, 2 );
}

if ( ! function_exists( 'barabi_core_set_tutorial_custom_sidebar_name' ) ) {
	/**
	 * Function that return sidebar name
	 *
	 * @param string $sidebar_name
	 *
	 * @return string
	 */
	function barabi_core_set_tutorial_custom_sidebar_name( $sidebar_name ) {

		if ( is_singular( 'tutorial' ) ) {
			$option = barabi_core_get_post_value_through_levels( 'qodef_tutorial_single_custom_sidebar' );
		} elseif ( is_tax() ) {
			$taxonomies = get_object_taxonomies( 'tutorial' );

			foreach ( $taxonomies as $tax ) {
				if ( is_tax( $tax ) ) {
					$option = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_custom_sidebar' );
				}
			}
		}

		if ( isset( $option ) && ! empty( $option ) ) {
			$sidebar_name = $option;
		}

		return $sidebar_name;
	}

	add_filter( 'barabi_filter_sidebar_name', 'barabi_core_set_tutorial_custom_sidebar_name' );
}

if ( ! function_exists( 'barabi_core_set_tutorial_sidebar_layout' ) ) {
	/**
	 * Function that return sidebar layout
	 *
	 * @param string $layout
	 *
	 * @return string
	 */
	function barabi_core_set_tutorial_sidebar_layout( $layout ) {

		if ( is_singular( 'tutorial' ) ) {
			$option = barabi_core_get_post_value_through_levels( 'qodef_tutorial_single_sidebar_layout' );
		} elseif ( is_tax() ) {
			$taxonomies = get_object_taxonomies( 'tutorial' );
			foreach ( $taxonomies as $tax ) {
				if ( is_tax( $tax ) ) {
					$option = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_sidebar_layout' );
				}
			}
		}

		if ( isset( $option ) && ! empty( $option ) ) {
			$layout = $option;
		}

		return $layout;
	}

	add_filter( 'barabi_filter_sidebar_layout', 'barabi_core_set_tutorial_sidebar_layout' );
}

if ( ! function_exists( 'barabi_core_set_tutorial_sidebar_grid_gutter_classes' ) ) {
	/**
	 * Function that returns grid gutter classes
	 *
	 * @param string $classes
	 *
	 * @return string
	 */
	function barabi_core_set_tutorial_sidebar_grid_gutter_classes( $classes ) {

		if ( is_singular( 'tutorial' ) ) {
			$option = barabi_core_get_post_value_through_levels( 'qodef_tutorial_single_sidebar_grid_gutter' );
		} elseif ( is_tax() ) {
			$taxonomies = get_object_taxonomies( 'tutorial' );
			foreach ( $taxonomies as $tax ) {
				if ( is_tax( $tax ) ) {
					$option = barabi_core_get_post_value_through_levels( 'qodef_tutorial_archive_sidebar_grid_gutter' );
				}
			}
		}
		if ( isset( $option ) && ! empty( $option ) ) {
			$classes = 'qodef-gutter--' . esc_attr( $option );
		}

		return $classes;
	}

	add_filter( 'barabi_filter_grid_gutter_classes', 'barabi_core_set_tutorial_sidebar_grid_gutter_classes' );
}

if ( ! function_exists( 'barabi_core_set_tutorial_sidebar_grid_gutter_styles' ) ) {
	/**
	 * Function that returns grid gutter styles
	 *
	 * @param array $styles
	 *
	 * @return array
	 */
	function barabi_core_set_tutorial_sidebar_grid_gutter_styles( $styles ) {

		if ( is_singular( 'tutorial' ) ) {
			$styles = barabi_core_get_gutter_custom_styles( 'qodef_tutorial_single_sidebar_grid_gutter_' );
		} elseif ( is_tax() ) {
			$taxonomies = get_object_taxonomies( 'tutorial' );
			foreach ( $taxonomies as $tax ) {
				if ( is_tax( $tax ) ) {
					$styles = barabi_core_get_gutter_custom_styles( 'qodef_tutorial_archive_sidebar_grid_gutter_' );
				}
			}
		}

		return $styles;
	}

	add_filter( 'barabi_filter_grid_gutter_styles', 'barabi_core_set_tutorial_sidebar_grid_gutter_styles' );
}

if ( ! function_exists( 'barabi_core_tutorial_set_admin_options_map_position' ) ) {
	/**
	 * Function that set dashboard admin options map position for this module
	 *
	 * @param int $position
	 * @param string $map
	 *
	 * @return int
	 */
	function barabi_core_tutorial_set_admin_options_map_position( $position, $map ) {

		if ( 'tutorial' === $map ) {
			$position = 52;
		}

		return $position;
	}

	add_filter( 'barabi_core_filter_admin_options_map_position', 'barabi_core_tutorial_set_admin_options_map_position', 10, 2 );
}

if ( ! function_exists( 'barabi_core_get_tutorial_single_post_taxonomies' ) ) {
	/**
	 * Function that return single post taxonomies list
	 *
	 * @param int $post_id
	 *
	 * @return array
	 */
	function barabi_core_get_tutorial_single_post_taxonomies( $post_id ) {
		$options = array();

		if ( ! empty( $post_id ) ) {
			$options['tutorial-category'] = wp_get_post_terms( $post_id, 'tutorial-category' );
		}

		return $options;
	}
}

if ( ! function_exists( 'barabi_core_set_tutorial_single_page_inner_classes' ) ) {
	function barabi_core_set_tutorial_single_page_inner_classes( $classes ) {
		if ( is_singular( 'tutorial' ) ) {
			$classes = 'qodef-content-full-width';
		}

		return $classes;
	}

	add_filter( 'barabi_filter_page_inner_classes', 'barabi_core_set_tutorial_single_page_inner_classes' );
}
