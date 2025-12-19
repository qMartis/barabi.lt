<div <?php post_class( $item_classes ); ?>>
	<div class="qodef-e-inner">
		<div class="qodef-e-image">
			<?php teenglow_core_list_sc_template_part( 'post-types/tutorial/shortcodes/tutorial-list', 'post-info/image', '', $params ); ?>
		</div>
		<div class="qodef-e-content">
			<div class="qodef-e-top-content">
				<?php teenglow_core_list_sc_template_part( 'post-types/tutorial/shortcodes/tutorial-list', 'post-info/categories', '', $params ); ?>
				<?php teenglow_core_list_sc_template_part( 'post-types/tutorial/shortcodes/tutorial-list', 'post-info/video-info', '', $params ); ?>
			</div>
			<?php teenglow_core_list_sc_template_part( 'post-types/tutorial/shortcodes/tutorial-list', 'post-info/title', '', $params ); ?>
			<?php teenglow_core_list_sc_template_part( 'post-types/tutorial/shortcodes/tutorial-list', 'post-info/author', '', $params ); ?>
		</div>
	</div>
</div>
