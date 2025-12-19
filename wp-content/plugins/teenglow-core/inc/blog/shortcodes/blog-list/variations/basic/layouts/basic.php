<article <?php post_class( $item_classes ); ?>>
	<div class="qodef-e-inner">
		<?php
		// Include post media
		teenglow_core_template_part( 'blog/shortcodes/blog-list', 'templates/post-info/media', '', $params );
		?>
		<div class="qodef-e-content">
			<div class="qodef-e-top-holder">
				<div class="qodef-e-info">
					<div class="qodef-e-categories">
						<?php
						// Include post category info
						teenglow_core_theme_template_part( 'blog', 'templates/parts/post-info/categories' );
						?>
					</div>
					<?php
					// Include post date info
					teenglow_core_theme_template_part( 'blog', 'templates/parts/post-info/date' );
					?>
				</div>
			</div>
			<div class="qodef-e-text">
				<?php
				// Include post title
				teenglow_core_template_part( 'blog/shortcodes/blog-list', 'templates/post-info/title', '', $params );

				// Include post excerpt
				teenglow_core_theme_template_part( 'blog', 'templates/parts/post-info/excerpt', '', $params );

				// Hook to include additional content after blog single content
				do_action( 'teenglow_action_after_blog_single_content' );
				?>
			</div>
		</div>
	</div>
</article>
