<?php if ( ! empty( $static_title ) || ! empty( $static_image ) ) { ?>
<div class="qodef-e-product-list-outer" <?php qode_framework_inline_style( $params['outer_holder_styles'] ); ?>>
	<div class="qodef-e-static-content">
		<?php teenglow_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/parts/static-title', '', $params ); ?>
	</div>
	<?php } ?>
	<div <?php qode_framework_class_attribute( $holder_classes ); ?> <?php qode_framework_inline_style( $holder_styles ); ?> <?php qode_framework_inline_attr( $data_attr, 'data-options' ); ?>>
		<?php
		// Include global filter from theme
		teenglow_core_theme_template_part( 'filter', 'templates/filter', '', $params );
		?>
		<ul class="qodef-grid-inner">
			<?php
			// Include global masonry template from theme
			teenglow_core_theme_template_part( 'masonry', 'templates/sizer-gutter', '', $params['behavior'] );
			
			// Include items
			teenglow_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/loop', '', $params );
			?>
		</ul>
		<?php
		// Include global pagination from theme
		teenglow_core_theme_template_part( 'pagination', 'templates/pagination', $params['pagination_type'], $params );
		?>
	</div>
	<?php if ( ! empty( $static_title ) || ! empty( $static_image ) ) { ?>
</div>
<?php } ?>
