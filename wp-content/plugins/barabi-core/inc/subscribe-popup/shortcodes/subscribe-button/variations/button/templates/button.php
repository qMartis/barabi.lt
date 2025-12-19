<?php if ( barabi_core_is_subscribe_popup_enabled() ) { ?>
	<div <?php qode_framework_class_attribute( $holder_classes ); ?>>
		<a class="qodef-subscribe-button-link" itemprop="url" href="#">
			<?php barabi_core_render_svg_icon( 'fingers' ); ?>
		</a>
	</div>
<?php } ?>
