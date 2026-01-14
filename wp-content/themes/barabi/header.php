<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
	<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-XNKPFTM8B4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-XNKPFTM8B4');
</script>
	<meta name="verify-paysera" content="cf71db61894b66c4733fd5daae8de3e6">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> itemscope itemtype="https://schema.org/WebPage">
	<?php
	// Hook to include default WordPress hooks after body tag open
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	}

	// Hook to include additional content after body tag open
	do_action( 'barabi_action_after_body_tag_open' );
	?>
	<div id="qodef-page-wrapper" class="<?php echo esc_attr( barabi_get_page_wrapper_classes() ); ?>">
		<?php
		// Hook to include page header template
		do_action( 'barabi_action_page_header_template' );
		?>
		<div id="qodef-page-outer">
			<?php
			// Include title template
			get_template_part( 'title' );

			// Hook to include additional content before page inner content
			do_action( 'barabi_action_before_page_inner' );
			?>
			<div id="qodef-page-inner" class="<?php echo esc_attr( barabi_get_page_inner_classes() ); ?>">
