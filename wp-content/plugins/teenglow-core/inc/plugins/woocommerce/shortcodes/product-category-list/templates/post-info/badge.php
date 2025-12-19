<?php
$is_new = qode_framework_get_option_value( '', 'taxonomy', 'qodef_product_category_new_badge', '', $category_id );

if ( 'yes' === $show_new_badge && 'yes' === $is_new ) { ?>
	<span class="qodef-e-badge"><?php echo esc_html__( 'New', 'teenglow-core' ); ?></span>
<?php } ?>
