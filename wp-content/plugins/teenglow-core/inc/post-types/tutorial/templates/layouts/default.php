<?php do_action( 'teenglow_core_action_before_tutorial_single_item' ); ?>

<article <?php post_class( 'qodef-content-grid qodef-tutorial-item qodef-e' ); ?>>
	<div class="qodef-e-inner">
		<?php teenglow_core_template_part( 'post-types/tutorial', 'templates/parts/post-info/media' ); ?>
		<div class="qodef-e-top-content">
			<?php teenglow_core_template_part( 'post-types/tutorial', 'templates/parts/post-info/categories' ); ?>
			<?php teenglow_core_template_part( 'post-types/tutorial', 'templates/parts/post-info/video-info' ); ?>
		</div>
		<?php teenglow_core_template_part( 'post-types/tutorial', 'templates/parts/post-info/excerpt' ); ?>
		<?php teenglow_core_template_part( 'post-types/tutorial', 'templates/parts/post-info/author' ); ?>
		<?php teenglow_core_template_part( 'post-types/tutorial', 'templates/parts/post-info/author-advanced' ); ?>
		<div class="qodef-e-content">
			<?php teenglow_core_template_part( 'post-types/tutorial', 'templates/parts/post-info/content' ); ?>
		</div>
	</div>
</article>

<?php do_action( 'teenglow_core_action_after_tutorial_single_item' ); ?>
