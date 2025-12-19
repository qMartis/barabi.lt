<div <?php qode_framework_class_attribute( $holder_classes ); ?>>
	<?php teenglow_core_template_part( 'shortcodes/banner', 'templates/parts/image', '', $params ); ?>
	<div class="qodef-m-content">
		<div class="qodef-m-content-inner" <?php qode_framework_inline_style( $content_styles ); ?>>
			<?php teenglow_core_template_part( 'shortcodes/banner', 'templates/parts/svg-path', '', $params ); ?>
			<?php teenglow_core_template_part( 'shortcodes/banner', 'templates/parts/title', '', $params ); ?>
			<?php teenglow_core_template_part( 'shortcodes/banner', 'templates/parts/text', '', $params ); ?>
			<?php teenglow_core_template_part( 'shortcodes/banner', 'templates/parts/button', '', $params ); ?>
		</div>
	</div>
</div>
