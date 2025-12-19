<?php $item_target = ! empty( $item_target ) ? $item_target : '_self'; ?>

<?php if( ! empty( $item_video_url ) ) { ?>
	<div class="<?php echo esc_attr( $item_classes ); ?>">
		<?php if ( ! empty( $item_link ) ) { ?>
			<a itemprop="url" href="<?php echo esc_url( $item_link ); ?>" target="<?php echo esc_attr( $item_link_target ); ?>">
		<?php } ?>
				<video class="qodef-e-video" muted playsinline loop src="<?php echo esc_url( $item_video_url ) ?>"></video>
		<?php if( ! empty( $item_link ) ) { ?>
			</a>
		<?php } ?>
	</div>
<?php } ?>
