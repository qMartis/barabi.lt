<?php $play_label = ! empty( $play_label ) ? $play_label : esc_html__( 'Video', 'teenglow-core' ); ?>

<?php if ( ! empty( $video_link ) ) { ?>
	<a itemprop="url" class="qodef-m-play qodef-magnific-popup qodef-popup-item" href="<?php echo esc_url( $video_link ); ?>" data-type="iframe">
		<span class="qodef-m-play-circle" <?php echo qode_framework_get_inline_style( $play_button_styles ); ?>>
			<span class="qodef-m-play-label"><?php echo esc_html( $play_label ); ?></span>
		</span>
	</a>
<?php } ?>
