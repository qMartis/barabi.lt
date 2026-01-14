<?php if ( comments_open() ) { ?>
	<a itemprop="url" href="<?php comments_link(); ?>" class="qodef-e-info-comments-link">
		<?php comments_number( '0 ' . esc_html__( 'Comments', 'barabi' ), '1 ' . esc_html__( 'Comment', 'barabi' ), '% ' . esc_html__( 'Comments', 'barabi' ) ); ?>
	</a><div class="qodef-info-separator-end"></div>
<?php } ?>
