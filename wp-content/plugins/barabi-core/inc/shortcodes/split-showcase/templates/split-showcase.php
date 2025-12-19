<div <?php qode_framework_class_attribute( $holder_classes ); ?>>
	<div class="qodef-e-inner">
		<div class="qodef-e-left" <?php qode_framework_inline_style( $left_section_styles ); ?>>
			<div class="qodef-e-left-inner">
				<?php barabi_core_template_part( 'shortcodes/split-showcase', 'templates/parts/image', '', $params ); ?>
			</div>
		</div>
		<div class="qodef-e-right" <?php qode_framework_inline_style( $right_section_styles ); ?>>
			<div class="qodef-e-right-top">
				<?php barabi_core_template_part( 'shortcodes/split-showcase', 'templates/parts/title', '', $params ); ?>
				<?php barabi_core_template_part( 'shortcodes/split-showcase', 'templates/parts/button', '', $params ); ?>
			</div>
			<div class="qodef-e-right-bottom">
				<?php barabi_core_template_part( 'shortcodes/split-showcase', 'templates/parts/text', '', $params ); ?>
				<?php barabi_core_template_part( 'shortcodes/split-showcase', 'templates/parts/features', '', $params ); ?>
			</div>
		</div>
	</div>
</div>
