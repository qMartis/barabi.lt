<?php
/**
 * Plugin Name: Barabi Engraving
 * Description: WooCommerce engraving image (admin) + text/font/size (frontend).
 * Version: 1.0.0
 */

defined('ABSPATH') || exit;

add_filter('use_block_editor_for_post_type', function ($use, $post_type) {
    if ($post_type === 'product') {
        return false;
    }
    return $use;
}, 10, 2);

define('BARABI_ENGRAVING_PATH', plugin_dir_path(__FILE__));

require_once BARABI_ENGRAVING_PATH . 'includes/admin.php';
require_once BARABI_ENGRAVING_PATH . 'includes/frontend.php';
require_once BARABI_ENGRAVING_PATH . 'includes/cart-order.php';
