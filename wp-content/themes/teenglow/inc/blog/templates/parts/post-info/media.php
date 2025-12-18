<div class="qodef-e-media">
	<?php
	switch ( get_post_format() ) {
		case 'gallery':
			teenglow_template_part( 'blog', 'templates/parts/post-format/gallery' );
			break;
		case 'video':
			teenglow_template_part( 'blog', 'templates/parts/post-format/video' );
			break;
		case 'audio':
			teenglow_template_part( 'blog', 'templates/parts/post-format/audio' );
			break;
		default:
			teenglow_template_part( 'blog', 'templates/parts/post-info/image' );
			break;
	}
	?>
</div>
