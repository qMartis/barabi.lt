<?php
$styles = array();
if ( ! empty( $info_below_content_margin_top ) ) {
	$margin_top = qode_framework_string_ends_with_space_units( $info_below_content_margin_top ) ? $info_below_content_margin_top : intval( $info_below_content_margin_top ) . 'px';
	$styles[]   = 'margin-top:' . $margin_top;
}
?>
<div <?php post_class( $item_classes ); ?>>
	<div class="qodef-e-inner">
		<div class="qodef-e-image">
			<?php teenglow_core_list_sc_template_part( 'post-types/tutorial/shortcodes/tutorial-list', 'post-info/image', '', $params ); ?>
		</div>
		<div class="qodef-e-content" <?php qode_framework_inline_style( $styles ); ?>>
			<div class="qodef-e-top-content">
				<?php teenglow_core_list_sc_template_part( 'post-types/tutorial/shortcodes/tutorial-list', 'post-info/categories', '', $params ); ?>
				<?php teenglow_core_list_sc_template_part( 'post-types/tutorial/shortcodes/tutorial-list', 'post-info/video-info', '', $params ); ?>
			</div>
			<?php teenglow_core_list_sc_template_part( 'post-types/tutorial/shortcodes/tutorial-list', 'post-info/title', '', $params ); ?>
			<?php teenglow_core_list_sc_template_part( 'post-types/tutorial/shortcodes/tutorial-list', 'post-info/author', '', $params ); ?>
		</div>
	</div>
</div>
