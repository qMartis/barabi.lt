<?php
$background_color = barabi_core_get_post_value_through_levels( 'qodef_content_bottom_background_color' );
$styles = array();
if ( ! empty( $background_color ) ) {
	$styles[] = 'background-color: ' . $background_color;
}
?>
<?php if ( is_active_sidebar( $sidebar ) ) : ?>
    <div id="qodef-content-bottom" <?php qode_framework_inline_style( $styles ); ?>>
        <div id="qodef-content-bottom-inner" class="<?php echo esc_attr( barabi_core_get_content_bottom_classes() ); ?>">
            <div class="qodef-grid-inner clear">
                <?php dynamic_sidebar( $sidebar ); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
