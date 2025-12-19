<?php do_action( 'barabi_core_action_before_tutorial_single_item' ); ?>

<article <?php post_class( 'qodef-content-grid qodef-tutorial-item qodef-tutorial-item qodef-e' ); ?>>
	<div class="qodef-e-inner">
		<?php barabi_core_template_part( 'post-types/tutorial', 'templates/parts/post-info/content' ); ?>
	</div>
</article>

<?php do_action( 'barabi_core_action_after_tutorial_single_item' ); ?>
