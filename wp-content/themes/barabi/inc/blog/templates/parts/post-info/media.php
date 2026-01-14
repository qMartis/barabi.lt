<div class="qodef-e-media">
	<?php
	switch ( get_post_format() ) {
		case 'gallery':
			barabi_template_part( 'blog', 'templates/parts/post-format/gallery' );
			break;
		case 'video':
			barabi_template_part( 'blog', 'templates/parts/post-format/video' );
			break;
		case 'audio':
			barabi_template_part( 'blog', 'templates/parts/post-format/audio' );
			break;
		default:
			barabi_template_part( 'blog', 'templates/parts/post-info/image' );
			break;
	}
	?>
</div>
