<?php if ( comments_open() ) { ?>
	<a itemprop="url" href="<?php comments_link(); ?>" class="qodef-e-info-comments-link">
		<?php comments_number( '0 ' . esc_html__( 'Comments', 'teenglow' ), '1 ' . esc_html__( 'Comment', 'teenglow' ), '% ' . esc_html__( 'Comments', 'teenglow' ) ); ?>
	</a><div class="qodef-info-separator-end"></div>
<?php } ?>
