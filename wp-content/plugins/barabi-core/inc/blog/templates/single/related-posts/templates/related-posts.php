<?php
$post_id       = get_the_ID();
$is_enabled    = barabi_core_get_post_value_through_levels( 'qodef_blog_single_enable_related_posts' );
$related_posts = barabi_core_get_custom_post_type_related_posts( $post_id, barabi_core_get_blog_single_post_taxonomies( $post_id ) );

if ( 'yes' === $is_enabled && ! empty( $related_posts ) && class_exists( 'BarabiCore_Blog_List_Shortcode' ) ) { ?>
	<div id="qodef-related-posts">
		<h4 class="qodef-related-posts-title"><?php echo esc_html__( 'Recent posts', 'barabi-core' ); ?></h4>
		<?php
		$params = apply_filters(
			'barabi_core_filter_blog_single_related_posts_params',
			array(
				'columns'           => '3',
				'posts_per_page'    => 3,
				'additional_params' => 'id',
				'post_ids'          => $related_posts['items'],
				'title_tag'         => 'h6',
				'excerpt_length'    => '0',
				'layout'            => 'basic'

			)
		);

		echo BarabiCore_Blog_List_Shortcode::call_shortcode( $params );
		?>
	</div>
<?php } ?>
