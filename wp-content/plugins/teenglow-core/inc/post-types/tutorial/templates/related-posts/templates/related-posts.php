<?php
$post_id       = get_the_ID();
$is_enabled    = teenglow_core_get_post_value_through_levels( 'qodef_tutorial_enable_related_posts' );
$related_posts = teenglow_core_get_custom_post_type_related_posts( $post_id, teenglow_core_get_tutorial_single_post_taxonomies( $post_id ) );

if ( 'yes' === $is_enabled && ! empty( $related_posts ) && class_exists( 'TeenglowCore_Tutorial_List_Shortcode' ) ) { ?>
	<div id="qodef-tutorial-single-related-items">
		<div class="qodef-tutorial-single-related-items-inner">
			<div class="qodef-content-grid">
				<div class="qodef-tutorial-single-related-intro">
					<h2 class="qodef-m-title">
						<?php echo esc_html__( 'Related Tutorials', 'teenglow-core' ); ?>
					</h2>
				</div>
				<div class="qodef-tutorial-single-related-list">
					<?php
					$params = apply_filters(
						'teenglow_core_filter_tutorial_single_related_posts_params',
						array(
							'columns'           => '3',
							'posts_per_page'    => 3,
							'additional_params' => 'id',
							'post_ids'          => $related_posts['items'],
							'layout'            => 'info-below',
							'title_tag'         => 'h5',
							'excerpt_length'    => '100',
						)
					);
					
					echo TeenglowCore_Tutorial_List_Shortcode::call_shortcode( $params );
					?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
