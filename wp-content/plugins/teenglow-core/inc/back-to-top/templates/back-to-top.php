<?php
$custom_icon    = teenglow_core_get_custom_svg_opener_icon_html( 'back_to_top' );
$holder_classes = array();
if ( empty( $custom_icon ) ) {
	$holder_classes[] = 'qodef--predefined';
}
?>
<a id="qodef-back-to-top" href="#" <?php qode_framework_class_attribute( $holder_classes ); ?>>
	<span class="qodef-back-to-top-icon">
		<?php
		if ( ! empty( $custom_icon ) ) {
			echo teenglow_core_get_custom_svg_opener_icon_html( 'back_to_top' );
		} else {
			teenglow_render_svg_icon( 'back-to-top', 'qodef-e-back-to-top-icon' );
		}
		?>
	</span>
</a>
