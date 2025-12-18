<?php $title_tag = ! empty( $title_tag ) ? $title_tag : 'h6'; ?>

<div <?php qode_framework_class_attribute( $holder_classes ); ?> <?php qode_framework_inline_style( $holder_styles ); ?> >
	<?php
	if ( is_array( $items ) && count( $items ) > 0 ) {
		foreach ( $items as $key => $item ) {
			?>
			<div class="qodef-textual-list-item">
				<?php if ( 'yes' === $enable_icon ) { ?>
					<div class="qodef-e-icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12">
							<path d="M8.145 3.855A7.005 7.005 0 0 1 6.026 0h-.05A7.885 7.885 0 0 1 .001 5.975v.05A7.885 7.885 0 0 1 5.976 12h.05a7.885 7.885 0 0 1 5.975-5.975v-.05a7.005 7.005 0 0 1-3.856-2.12Z"/>
						</svg>
					</div>
				<?php } ?>
				<div class="qodef-textual-list-content">
					<?php if ( ! empty( $item['title'] ) ) { ?>
						<<?php echo esc_attr( $title_tag ); ?> class="qodef-e-title"><?php echo esc_html( $item['title'] ); ?></<?php echo esc_attr( $title_tag ); ?>>
					<?php } ?>
					<?php if ( ! empty( $item['text'] ) ) { ?>
						<p class="qodef-e-text"><?php echo qode_framework_wp_kses_html( 'content', $item['text'] ); ?></p>
					<?php } ?>
				</div>
			</div>
			<?php
		}
	}
	?>
	<?php if( ! empty( $outro_text ) ) { ?>
		<p class="qodef-outro-text">
			<?php echo qode_framework_wp_kses_html( 'content', $outro_text ); ?>
		</p>
	<?php } ?>
</div>
