<article <?php post_class( $item_classes ); ?>>
	<div class="qodef-e-inner">
		<?php
		// Include post media
		barabi_core_template_part( 'blog/shortcodes/blog-list', 'templates/post-info/image', '', $params );
		?>
		<div class="qodef-e-content">
			<div class="qodef-e-top-holder">
				<div class="qodef-e-info">
					<div class="qodef-e-categories">
						<?php
						// Include post category info
						barabi_core_theme_template_part( 'blog', 'templates/parts/post-info/categories' );
						?>
					</div>
					<?php
					// Include post date info
					barabi_core_theme_template_part( 'blog', 'templates/parts/post-info/date' );
					?>
				</div>
			</div>
			<div class="qodef-e-bottom-holder">
				<?php
				// Include post title
				barabi_core_template_part( 'blog/shortcodes/blog-list', 'templates/post-info/title', '', $params );
				?>
			</div>
		</div>
	</div>
</article>
