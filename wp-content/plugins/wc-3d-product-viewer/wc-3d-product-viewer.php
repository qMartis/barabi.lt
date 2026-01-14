<?php
/**
 * Plugin Name: WooCommerce 3D Product Viewer
 * Plugin URI: https://example.com
 * Description: Add 3D model viewing capability to WooCommerce variable products. Upload 3D models for each variation and display them on the product page.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * Text Domain: wc-3d-viewer
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * WC requires at least: 5.0
 * WC tested up to: 8.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('WC_3D_VIEWER_VERSION', '1.0.0');
define('WC_3D_VIEWER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WC_3D_VIEWER_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Check if WooCommerce is active
 */
function wc_3d_viewer_check_woocommerce() {
    if (!class_exists('WooCommerce')) {
        add_action('admin_notices', 'wc_3d_viewer_woocommerce_notice');
        deactivate_plugins(plugin_basename(__FILE__));
        return false;
    }
    return true;
}

/**
 * Display admin notice if WooCommerce is not active
 */
function wc_3d_viewer_woocommerce_notice() {
    ?>
    <div class="error">
        <p><?php esc_html_e('WooCommerce 3D Product Viewer requires WooCommerce to be installed and active.', 'wc-3d-viewer'); ?></p>
    </div>
    <?php
}

/**
 * Initialize the plugin
 */
function wc_3d_viewer_init() {
    if (!wc_3d_viewer_check_woocommerce()) {
        return;
    }
    
    // Load plugin files
    require_once WC_3D_VIEWER_PLUGIN_DIR . 'includes/class-wc-3d-viewer-admin.php';
    require_once WC_3D_VIEWER_PLUGIN_DIR . 'includes/class-wc-3d-viewer-frontend.php';
    
    // Initialize classes
    new WC_3D_Viewer_Admin();
    new WC_3D_Viewer_Frontend();
}
add_action('plugins_loaded', 'wc_3d_viewer_init');

/**
 * Plugin activation
 */
function wc_3d_viewer_activate() {
    if (!class_exists('WooCommerce')) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die(esc_html__('WooCommerce 3D Product Viewer requires WooCommerce to be installed and active.', 'wc-3d-viewer'));
    }
}
register_activation_hook(__FILE__, 'wc_3d_viewer_activate');

/**
 * Add custom MIME types for 3D files
 */
function wc_3d_viewer_mime_types($mimes) {
    $mimes['glb'] = 'model/gltf-binary';
    $mimes['gltf'] = 'model/gltf+json';
    $mimes['obj'] = 'model/obj';
    $mimes['fbx'] = 'application/octet-stream';
    $mimes['stl'] = 'application/sla';
    return $mimes;
}
add_filter('upload_mimes', 'wc_3d_viewer_mime_types');

/**
 * Allow 3D file extensions
 */
function wc_3d_viewer_check_filetype_and_ext($data, $file, $filename, $mimes) {
    $filetype = wp_check_filetype($filename, $mimes);
    $ext = $filetype['ext'];
    $type = $filetype['type'];
    
    $allowed_3d_extensions = array('glb', 'gltf', 'obj', 'fbx', 'stl');
    
    if (in_array($ext, $allowed_3d_extensions)) {
        $data['ext'] = $ext;
        $data['type'] = $type;
    }
    
    return $data;
}
add_filter('wp_check_filetype_and_ext', 'wc_3d_viewer_check_filetype_and_ext', 10, 4);
