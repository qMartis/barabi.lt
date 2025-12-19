<?php
$title_tag = isset( $static_title_tag ) && ! empty( $static_title_tag ) ? $static_title_tag : 'h2';
?>
<div class="qodef-e-content-holder">
	<?php if ( ! empty( $static_title ) ) { ?>
		<<?php echo esc_attr( $title_tag ); ?> class="qodef-m-title" <?php qode_framework_inline_style( $static_title_styles ); ?>>
			<?php echo esc_html( $static_title ); ?>
		</<?php echo esc_attr( $title_tag ); ?>>
	<?php } ?>
	<?php
	if ( ! empty( $static_button_link ) ) {
		$button_params = array(
			'button_layout' => 'textual',
			'text'          => ! empty( $static_button_label ) ? $static_button_label : '',
			'link'          => $static_button_link,
			'target'        => '_self',
		);
		if ( class_exists( 'BarabiCore_Button_Shortcode' ) ) {
			?>
			<div class="qodef-m-button">
				<?php echo BarabiCore_Button_Shortcode::call_shortcode( $button_params ); ?>
			</div>
			<?php
		}
	}
	?>
</div>
<?php if ( ! empty( $static_image ) ) { ?>
	<div class="qodef-e-media">
		<?php echo wp_get_attachment_image( $static_image, 'full' ); ?>
	</div>
<?php } ?>
