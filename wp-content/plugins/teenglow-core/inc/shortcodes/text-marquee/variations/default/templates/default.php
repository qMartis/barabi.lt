<div <?php qode_framework_class_attribute( $holder_classes ); ?> <?php qode_framework_inline_style( $holder_styles ); ?>>
	<div class="qodef-m-content" <?php qode_framework_inline_style( $text_styles ); ?>>
		<div class="qodef-m-content-inner">
			<?php if ( ! empty( $text_1 ) ) : ?>
				<span class="qodef-m-text-1" <?php qode_framework_inline_style( $text_individual_styles['first'] ); ?>>
					<?php echo esc_html( $text_1 ); ?>
				</span>
			<?php endif; ?>
			<?php if ( 'yes' === $enable_star_separator ): ?>
				<span class="qodef-m-separator" <?php qode_framework_inline_style( $text_individual_styles['separator'] ); ?>>
					<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25">
						<g>
							<path d="M16.968 8.032A14.594 14.594 0 0 1 12.552 0h-.1A16.427 16.427 0 0 1 .004 12.448v.1a16.427 16.427 0 0 1 12.448 12.448h.1a16.427 16.427 0 0 1 12.447-12.448v-.1a14.594 14.594 0 0 1-8.031-4.416Z"/>
						</g>
					</svg>
				</span>
			<?php endif; ?>
			<?php if ( ! empty( $text_2 ) ) : ?>
				<span class="qodef-m-text-2" <?php qode_framework_inline_style( $text_individual_styles['second'] ); ?>>
					<?php echo esc_html( $text_2 ); ?>
				</span>
			<?php endif; ?>
			<?php if ( 'yes' === $enable_star_separator ): ?>
				<span class="qodef-m-separator" <?php qode_framework_inline_style( $text_individual_styles['separator'] ); ?>>
					<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25">
						<g>
							<path d="M16.968 8.032A14.594 14.594 0 0 1 12.552 0h-.1A16.427 16.427 0 0 1 .004 12.448v.1a16.427 16.427 0 0 1 12.448 12.448h.1a16.427 16.427 0 0 1 12.447-12.448v-.1a14.594 14.594 0 0 1-8.031-4.416Z"/>
						</g>
					</svg>
				</span>
			<?php endif; ?>
			<?php if ( ! empty( $text_3 ) ) : ?>
				<span class="qodef-m-text-3" <?php qode_framework_inline_style( $text_individual_styles['third'] ); ?>>
					<?php echo esc_html( $text_3 ); ?>
				</span>
			<?php endif; ?>
			<?php if ( 'yes' === $enable_star_separator ): ?>
				<span class="qodef-m-separator" <?php qode_framework_inline_style( $text_individual_styles['separator'] ); ?>>
					<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25">
						<g>
							<path d="M16.968 8.032A14.594 14.594 0 0 1 12.552 0h-.1A16.427 16.427 0 0 1 .004 12.448v.1a16.427 16.427 0 0 1 12.448 12.448h.1a16.427 16.427 0 0 1 12.447-12.448v-.1a14.594 14.594 0 0 1-8.031-4.416Z"/>
						</g>
					</svg>
				</span>
			<?php endif; ?>
		</div>
	</div>
</div>
