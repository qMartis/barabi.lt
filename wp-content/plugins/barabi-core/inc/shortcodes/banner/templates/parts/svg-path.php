<?php if ( ! empty( $svg_path ) ) : ?>
	<div class="qodef-svg-holder" <?php qode_framework_inline_style( $svg_styles ); ?>>
        <?php echo qode_framework_wp_kses_html( 'svg', $svg_path ); ?>
    </div>
<?php endif; ?>
