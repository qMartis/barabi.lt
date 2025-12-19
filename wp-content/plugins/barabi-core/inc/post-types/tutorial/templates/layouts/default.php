<?php do_action( 'barabi_core_action_before_tutorial_single_item' ); ?>

<article <?php post_class( 'qodef-content-grid qodef-tutorial-item qodef-e' ); ?>>
	<div class="qodef-e-inner">
		<?php barabi_core_template_part( 'post-types/tutorial', 'templates/parts/post-info/media' ); ?>
		<div class="qodef-e-top-content">
			<?php barabi_core_template_part( 'post-types/tutorial', 'templates/parts/post-info/categories' ); ?>
			<?php barabi_core_template_part( 'post-types/tutorial', 'templates/parts/post-info/video-info' ); ?>
		</div>
		<?php barabi_core_template_part( 'post-types/tutorial', 'templates/parts/post-info/excerpt' ); ?>
		<?php barabi_core_template_part( 'post-types/tutorial', 'templates/parts/post-info/author' ); ?>
		<?php barabi_core_template_part( 'post-types/tutorial', 'templates/parts/post-info/author-advanced' ); ?>
		<div class="qodef-e-content">
			<?php barabi_core_template_part( 'post-types/tutorial', 'templates/parts/post-info/content' ); ?>
		</div>
	</div>
</article>

<?php do_action( 'barabi_core_action_after_tutorial_single_item' ); ?>
