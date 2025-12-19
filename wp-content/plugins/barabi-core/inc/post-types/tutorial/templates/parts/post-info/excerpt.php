<?php

if ( post_password_required() ) {
	echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
} else {
	$excerpt = barabi_core_get_custom_post_type_excerpt( 600 );

	if ( ! empty( $excerpt ) ) { ?>
		<p itemprop="description" class="qodef-e-excerpt"><?php echo esc_html( $excerpt ); ?></p>
		<?php
	}
}
?>
