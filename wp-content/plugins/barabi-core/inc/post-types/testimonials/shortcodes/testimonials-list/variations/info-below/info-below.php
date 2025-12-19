<?php

if ( ! function_exists( 'barabi_core_add_testimonials_list_variation_info_below' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function barabi_core_add_testimonials_list_variation_info_below( $variations ) {
		$variations['info-below'] = esc_html__( 'Info Below', 'barabi-core' );

		return $variations;
	}

	add_filter( 'barabi_core_filter_testimonials_list_layouts', 'barabi_core_add_testimonials_list_variation_info_below' );
}

if ( ! function_exists( 'barabi_core_add_testimonials_list_options_info_below' ) ) {
	/**
	 * Function that add additional options for variation layout
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	function barabi_core_add_testimonials_list_options_info_below( $options ) {
		$info_below_options   = array();
		$margin_option        = array(
			'field_type' => 'text',
			'name'       => 'info_below_content_margin_top',
			'title'      => esc_html__( 'Content Top Margin', 'barabi-core' ),
			'dependency' => array(
				'show' => array(
					'layout' => array(
						'values'        => 'info-below',
						'default_value' => 'default',
					),
				),
			),
			'group'      => esc_html__( 'Layout', 'barabi-core' ),
		);
		$info_below_options[] = $margin_option;

		return array_merge( $options, $info_below_options );
	}

	add_filter( 'barabi_core_filter_testimonials_list_extra_options', 'barabi_core_add_testimonials_list_options_info_below' );
}

if ( ! function_exists( 'barabi_core_calculate_average_testimonials_rating' ) ) {
	function barabi_core_calculate_average_testimonials_rating() {
		$posts_count = 0;
		$ratings_sum = 0;

		$args = array( 'post_type' => 'testimonials');
		$loop = new WP_Query( $args );

		while ( $loop->have_posts() ) : $loop->the_post();
			$ratings_sum += intval( get_post_meta( get_the_ID(), 'qodef_testimonials_rating', true ) );
			$posts_count++;
		endwhile;

		$average_rating = round($ratings_sum / $posts_count, 1);

		return array($average_rating, $posts_count);
	}
	add_filter( 'barabi_core_filter_testimonials_average_rating', 'barabi_core_calculate_average_testimonials_rating' );
}