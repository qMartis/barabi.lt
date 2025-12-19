<?php

if ( ! function_exists( 'teenglow_child_theme_enqueue_scripts' ) ) {
	/**
	 * Function that enqueue theme's child style
	 */
	function teenglow_child_theme_enqueue_scripts() {
		$main_style = 'teenglow-main';

		wp_enqueue_style( 'teenglow-child-style', get_stylesheet_directory_uri() . '/style.css', array( $main_style ) );
	}

	add_action( 'wp_enqueue_scripts', 'teenglow_child_theme_enqueue_scripts' );
}

// Barabi woo images watermark logic add

add_filter('wp_generate_attachment_metadata', 'watermark_only_for_products', 10, 2);

function watermark_only_for_products($metadata, $attachment_id) {
    $is_product = false;

    if (isset($_REQUEST['post_id']) && get_post_type($_REQUEST['post_id']) === 'product') {
        $is_product = true;
    } 
    elseif (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'post_type=product') !== false) {
        $is_product = true;
    }
    elseif (get_post_type(get_post($attachment_id)->post_parent) === 'product') {
        $is_product = true;
    }

    if (!$is_product) return $metadata;

    $upload_dir = wp_get_upload_dir();
    $watermark_path = $upload_dir['basedir'] . '/watermark.png';

    if (!file_exists($watermark_path)) return $metadata;

    $base_file = $upload_dir['basedir'] . '/' . $metadata['file'];
    $files = [$base_file];
    $dir = dirname($base_file) . '/';

    if (!empty($metadata['sizes'])) {
        foreach ($metadata['sizes'] as $size) {
            $files[] = $dir . $size['file'];
        }
    }

    foreach ($files as $file_path) {
        if (!file_exists($file_path)) continue;

        $info = getimagesize($file_path);
        if (!$info) continue;

        $mime = $info['mime'];
        $img = null;

        if ($mime == 'image/jpeg') $img = imagecreatefromjpeg($file_path);
        elseif ($mime == 'image/png') $img = imagecreatefrompng($file_path);
        elseif ($mime == 'image/webp') $img = imagecreatefromwebp($file_path);

        if (!$img) continue;

        $watermark = imagecreatefrompng($watermark_path);
        imagealphablending($watermark, false);
        imagesavealpha($watermark, true);

        $img_w = imagesx($img);
        $img_h = imagesy($img);
        $wm_w = imagesx($watermark);
        $wm_h = imagesy($watermark);

        $pos_x = $img_w - $wm_w - 20;
        $pos_y = $img_h - $wm_h - 20;

        if ($pos_x > 0 && $pos_y > 0) {
            imagealphablending($img, true);
            imagecopy($img, $watermark, $pos_x, $pos_y, 0, 0, $wm_w, $wm_h);

            if ($mime == 'image/jpeg') imagejpeg($img, $file_path, 90);
            elseif ($mime == 'image/png') imagepng($img, $file_path);
            elseif ($mime == 'image/webp') imagewebp($img, $file_path, 85);
        }

        imagedestroy($img);
        imagedestroy($watermark);
    }

    return $metadata;
}