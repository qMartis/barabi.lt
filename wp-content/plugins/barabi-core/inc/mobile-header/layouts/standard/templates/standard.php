<header id="qodef-page-mobile-header" role="banner">
	<?php
	// Hook to include additional content before page mobile header inner
	do_action( 'barabi_core_action_before_page_mobile_header_inner' );
	?>
	<div id="qodef-page-mobile-header-inner" <?php qode_framework_class_attribute( apply_filters( 'barabi_filter_mobile_header_inner_class', array(), 'mobile' ) ); ?>>
		<?php
		// Include mobile logo
		barabi_core_get_mobile_header_logo_image();

		if ( 'no' !== barabi_core_get_post_value_through_levels( 'qodef_show_mobile_header_widget_areas' ) ) {
			// Include mobile widget area one
			if ( is_active_sidebar( 'qodef-mobile-header-widget-area' ) ) {
				?>
				<div class="qodef-widget-holder qodef--one">
					<?php dynamic_sidebar( 'qodef-mobile-header-widget-area' ); ?>
				</div>
				<?php
			}
		}

		// Include mobile navigation opener
		barabi_core_template_part( 'mobile-header', 'templates/parts/mobile-navigation-opener' );
		?>
	</div>
	<?php
	// Include mobile navigation
	barabi_core_template_part( 'mobile-header', 'templates/parts/mobile-navigation' );

	// Hook to include additional content after page mobile header inner
	do_action( 'barabi_core_action_after_page_mobile_header_inner' );
	?>
</header>
