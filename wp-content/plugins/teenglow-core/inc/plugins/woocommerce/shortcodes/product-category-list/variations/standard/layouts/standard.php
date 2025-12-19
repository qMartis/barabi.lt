<div <?php wc_product_cat_class( $item_classes ); ?>>
	<div class="qodef-e-inner">
		<a href="<?php echo get_term_link( $category_slug, 'product_cat' ); ?>" class="qodef-e-image-link">
			<?php teenglow_core_template_part( 'plugins/woocommerce/shortcodes/product-category-list', 'templates/post-info/image', '', $params ); ?>
			<?php teenglow_core_template_part( 'plugins/woocommerce/shortcodes/product-category-list', 'templates/post-info/badge', '', $params ); ?>
		</a>
		<?php teenglow_core_template_part( 'plugins/woocommerce/shortcodes/product-category-list', 'templates/post-info/title-button', '', $params ); ?>
	</div>
</div>
