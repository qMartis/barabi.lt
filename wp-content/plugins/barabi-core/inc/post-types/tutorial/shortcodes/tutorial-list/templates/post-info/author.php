<a itemprop="author" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="qodef-e-info-author">
	<span class="qodef-author-label">
		<?php echo esc_html__( 'By:', 'barabi-core' ) ?>
	</span>
	<span class="qodef-author-name">
		<?php the_author_meta( 'display_name' ); ?>
	</span>
</a><div class="qodef-info-separator-end"></div>
