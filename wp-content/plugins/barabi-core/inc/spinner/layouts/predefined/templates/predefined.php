<?php
$image     = barabi_core_get_post_value_through_levels( 'qodef_spinner_image' );
$image_src = wp_get_attachment_image_src( $image, 'full' );
?>
<?php if ( ! empty( $image_src ) ) : ?>
	<span class="qodef-m-spinner-image">
		<img itemprop="image" src="<?php echo esc_url( $image_src[0] ); ?>"
		     width="<?php echo round( $image_src[1] / 2 ); ?>" height="<?php echo round( $image_src[2] / 2 ); ?>"
		     alt="<?php echo esc_attr( $image_src[3] ); ?>"/>
	</span>
<?php endif; ?>
<span class="qodef-m-spinner-svg"><?php barabi_render_svg_icon( 'preloader' ); ?></span>

