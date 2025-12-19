<div class="qodef-grid-item <?php echo esc_attr( barabi_core_get_page_content_sidebar_classes() ); ?>">
	<div class="qodef-tutorial qodef-m <?php echo esc_attr( barabi_core_get_tutorial_holder_classes() ); ?>">
		<?php
		// Include tutorial posts loop
		barabi_core_template_part( 'post-types/tutorial', 'templates/parts/loop' );
		?>
	</div>
</div>
