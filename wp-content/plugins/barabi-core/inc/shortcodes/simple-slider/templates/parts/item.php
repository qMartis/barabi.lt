<div class="<?php echo esc_attr( $item_classes ); ?>">
	<div class="qodef-e-inner">
		<div class="qodef-e-image">
			<?php echo wp_get_attachment_image( $item_image, 'full' ); ?>
			<?php if ( !empty( $item_link ) ) { ?>
				<a href="<?php echo esc_url( $item_link ) ?>" target="<?php echo esc_attr( $item_target ) ?>"></a>
			<?php } ?>
		</div>
		<div class="qodef-e-content">
			<?php if ( ! empty( $item_title ) ) : ?>
				<p class="qodef-e-title">
					<?php if ( !empty( $item_link ) ) { ?>
						<a href="<?php echo esc_url( $item_link ) ?>" target="<?php echo esc_attr( $item_target ) ?>">
					<?php } ?>
						<?php echo esc_html( $item_title ); ?>
					<?php if ( !empty( $item_link ) ) { ?>
						</a>
					<?php } ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
</div>