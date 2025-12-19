<?php
$author_age = get_post_meta( get_the_ID(), 'qodef_testimonials_author_age', true );

if ( ! empty( $author_age ) ) { ?>
	<div class="qodef-e-author-age-holder">
		<div class="qodef-e-author-age"><?php echo esc_html( $author_age ); ?></div>
		<div class="qodef-e-author-age-label"><?php echo esc_html( sprintf( _n( 'Year', 'Years', intval( $author_age ), 'barabi-core' ), intval( $author_age ) ) ); ?></div>
	</div>
<?php } ?>
