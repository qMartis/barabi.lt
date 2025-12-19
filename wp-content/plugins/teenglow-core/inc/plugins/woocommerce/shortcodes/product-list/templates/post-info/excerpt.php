<?php
$excerpt      = teenglow_core_get_custom_post_type_excerpt( isset( $excerpt_length ) ? $excerpt_length : '' );
$list_excerpt = get_post_meta( get_the_ID(), 'qodef_product_list_excerpt', true );

$excerpt = ! empty( $list_excerpt ) ? $list_excerpt : $excerpt;

if ( ! empty( $excerpt ) ) { ?>
	<p itemprop="description" class="qodef-woo-product-excerpt"><?php echo esc_html( $excerpt ); ?></p>
<?php } ?>
