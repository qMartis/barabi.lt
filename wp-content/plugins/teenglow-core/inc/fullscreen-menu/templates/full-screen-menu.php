<div id="qodef-fullscreen-area">
	<?php if ( $fullscreen_menu_in_grid ) { ?>
	<div class="qodef-content-grid">
	<?php } ?>

		<div id="qodef-fullscreen-area-inner">
			<?php if ( has_nav_menu( 'fullscreen-menu-navigation' ) ) { ?>
				<nav class="qodef-fullscreen-menu" role="navigation" aria-label="<?php esc_attr_e( 'Full Screen Menu', 'teenglow-core' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'fullscreen-menu-navigation',
							'container'      => '',
							'link_before'    => '<span class="qodef-menu-item-text">',
							'link_after'     => '</span>',
							'walker'         => new TeenglowCoreRootMainMenuWalker(),
						)
					);
					?>
				</nav>
			<?php } ?>
			
			<div class="qodef-fullscreen-area-widgets">
				<?php

				// Include widget area one
				teenglow_core_template_part( 'fullscreen-menu', 'templates/parts/widget-area-one' );

				// Include widget area two
				teenglow_core_template_part( 'fullscreen-menu', 'templates/parts/widget-area-two' );
				?>
			</div>
		</div>

	<?php if ( $fullscreen_menu_in_grid ) { ?>
	</div>
	<?php } ?>

	<?php
	// Include image
	teenglow_core_template_part( 'fullscreen-menu', 'templates/parts/image' );
	?>
</div>
