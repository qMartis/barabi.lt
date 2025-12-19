<article <?php post_class( 'qodef-blog-item qodef-e' ); ?>>
	<div class="qodef-e-inner">
		<?php
		// Include post format part
		teenglow_template_part( 'blog', 'templates/parts/post-format/link' );
		?>
		<div class="qodef-e-content">
			<div class="qodef-e-top-holder">
				<div class="qodef-e-info">
					<div class="qodef-e-categories">
						<?php
						// Include post category info
						teenglow_template_part( 'blog', 'templates/parts/post-info/categories' );
						?>
					</div>
					<?php
					// Include post date info
					teenglow_template_part( 'blog', 'templates/parts/post-info/date' );
					?>
				</div>
			</div>
			<div class="qodef-e-text">
				<?php
				// Include post title
				teenglow_template_part( 'blog', 'templates/parts/post-info/title' );

				// Include post content
				the_content();

				// Hook to include additional content after blog single content
				do_action( 'teenglow_action_after_blog_single_content' );
				?>
			</div>
			<div class="qodef-e-bottom-holder">
				<div class="qodef-e-left qodef-e-info">
					<?php
					// Include post tags info
					teenglow_template_part( 'blog', 'templates/parts/post-info/tags' );
					?>
				</div>
				<div class="qodef-e-right qodef-e-info">
					<?php
					// Include post social share buttons
					teenglow_template_part( 'blog', 'templates/parts/post-info/social-share' );
					?>
				</div>
			</div>
		</div>
	</div>
</article>
