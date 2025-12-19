<?php

$author_id       = get_the_author_meta( 'ID' );
$author_name     = get_the_author_meta( 'display_name' );
$author_link     = get_author_posts_url( $author_id );
$author_position = get_the_author_meta( 'qodef_user_position' );
$author_bio      = get_the_author_meta( 'description' );

?>

<div class="qodef-e-author-advanced-info">
	<div class="qodef-e-left">
		<div class="qodef-m-image">
			<a itemprop="url" href="<?php echo esc_url( $author_link ); ?>">
				<?php echo get_avatar( $author_id, 108 ); ?>
			</a>
		</div>
	</div>
	<div class="qodef-e-right">
		<?php if ( ! empty( $author_name ) ) { ?>
			<div class="qodef-author-name">
				<a itemprop="author" href="<?php echo esc_url( $author_link ); ?>" class="qodef-e-info-author">
					<?php echo esc_html( $author_name ); ?>
				</a>
			</div>
		<?php } ?>
		
		<?php if ( ! empty( $author_position ) ) { ?>
			<div class="qodef-author-position">
				<?php echo esc_html( $author_position ); ?>
			</div>
		<?php } ?>
		
		<?php if ( ! empty( $author_bio ) ) { ?>
			<div class="qodef-author-description">
				<?php echo esc_html( $author_bio ); ?>
			</div>
		<?php } ?>
		
	</div>
</div>
