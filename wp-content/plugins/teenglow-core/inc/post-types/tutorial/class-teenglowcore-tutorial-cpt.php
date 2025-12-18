<?php

if ( ! function_exists( 'teenglow_core_register_tutorial_for_meta_options' ) ) {
	/**
	 * Function that add custom post type into global meta box allowed items array for saving meta box options
	 *
	 * @param array $post_types
	 *
	 * @return array
	 */
	function teenglow_core_register_tutorial_for_meta_options( $post_types ) {
		$post_types[] = 'tutorial';

		return $post_types;
	}

	add_filter( 'qode_framework_filter_meta_box_save', 'teenglow_core_register_tutorial_for_meta_options' );
	add_filter( 'qode_framework_filter_meta_box_remove', 'teenglow_core_register_tutorial_for_meta_options' );
}

if ( ! function_exists( 'teenglow_core_add_tutorial_custom_post_type' ) ) {
	/**
	 * Function that adds tutorial custom post type
	 *
	 * @param array $cpts
	 *
	 * @return array
	 */
	function teenglow_core_add_tutorial_custom_post_type( $cpts ) {
		$cpts[] = 'TeenglowCore_Tutorial_CPT';

		return $cpts;
	}

	add_filter( 'teenglow_core_filter_register_custom_post_types', 'teenglow_core_add_tutorial_custom_post_type' );
}

if ( class_exists( 'QodeFrameworkCustomPostType' ) ) {
	class TeenglowCore_Tutorial_CPT extends QodeFrameworkCustomPostType {

		public function map_post_type() {
			$name = esc_html__( 'Tutorial', 'teenglow-core' );
			$this->set_base( 'tutorial' );
			$this->set_menu_position( 10 );
			$this->set_menu_icon( 'dashicons-video-alt2' );
			$this->set_slug( 'tutorial' );
			$this->set_name( $name );
			$this->set_path( TEENGLOW_CORE_CPT_PATH . '/tutorial' );
			$this->set_labels(
				array(
					'name'          => esc_html__( 'Teenglow Tutorial', 'teenglow-core' ),
					'singular_name' => esc_html__( 'Tutorial', 'teenglow-core' ),
					'add_item'      => esc_html__( 'New Tutorial Item', 'teenglow-core' ),
					'add_new_item'  => esc_html__( 'Add New Tutorial Item', 'teenglow-core' ),
					'edit_item'     => esc_html__( 'Edit Tutorial Item', 'teenglow-core' ),
				)
			);
			if ( ! teenglow_core_tutorial_has_single() ) {
				$this->set_public( false );
				$this->set_archive( false );
				$this->set_supports(
					array(
						'title',
						'thumbnail',
					)
				);
			}
			$this->add_post_taxonomy(
				array(
					'base'          => 'tutorial-category',
					'slug'          => 'tutorial-category',
					'singular_name' => esc_html__( 'Category', 'teenglow-core' ),
					'plural_name'   => esc_html__( 'Categories', 'teenglow-core' ),
				)
			);
		}
	}
}
