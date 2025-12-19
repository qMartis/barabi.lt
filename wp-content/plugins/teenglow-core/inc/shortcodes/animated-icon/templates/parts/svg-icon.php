<?php if ( 'svg-icon' === $icon_type && ! empty( $svg_icon ) ) { ?>
	<?php if ( ! empty( $link ) ) : ?>
		<a itemprop="url" href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>">
	<?php endif; ?>
	<?php echo qode_framework_wp_kses_html( 'svg', $svg_icon );?>
	<?php if ( ! empty( $link ) ) : ?>
		</a>
	<?php endif; ?>
<?php } ?>
