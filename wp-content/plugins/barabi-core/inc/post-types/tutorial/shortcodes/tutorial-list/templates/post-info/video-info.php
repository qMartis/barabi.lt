<?php

require_once ABSPATH . '/wp-admin/includes/media.php';

$tutorial_id     = get_the_ID();
$video_url       = get_post_meta( $tutorial_id, 'qodef_tutorial_video_url', true );
$tutorial_layout = get_post_meta( $tutorial_id, 'qodef_tutorial_single_layout', true );

if ( ! empty( $video_url ) && 'custom' !== $tutorial_layout ) {
	$video_id = qode_framework_get_attachment_id_from_url( $video_url );

	if ( ! empty( $video_id ) ) {
		$video_file_path = get_attached_file( $video_id );

		if ( ! empty( $video_file_path ) ) {
			$video_metadata = wp_read_video_metadata( $video_file_path );

			if ( is_array( $video_metadata ) && isset( $video_metadata['length_formatted'] ) ) { ?>
				<div class="qodef-e-video-info">
					<span class="qodef-e-play"></span>
					<span class="qodef-e-duration"><?php echo esc_html( $video_metadata['length_formatted'] ); ?></span>
				</div>
				<?php
			}
		}
	}
}
