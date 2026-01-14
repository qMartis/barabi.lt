<?php
/**
 * Frontend functionality for 3D Viewer
 */

if (!defined('ABSPATH')) {
    exit;
}

class WC_3D_Viewer_Frontend {
    
    /**
     * Constructor
     */
    public function __construct() {
        // Enqueue frontend scripts
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts'));
        
        // Add 3D button to product images
        add_action('woocommerce_product_thumbnails', array($this, 'add_3d_button'), 25);
        
        // AJAX handler to get variation 3D model
        add_action('wp_ajax_get_variation_3d_model', array($this, 'get_variation_3d_model'));
        add_action('wp_ajax_nopriv_get_variation_3d_model', array($this, 'get_variation_3d_model'));
    }
    
    /**
     * Enqueue frontend scripts
     */
    public function enqueue_frontend_scripts() {
        if (!is_product()) {
            return;
        }
        
        global $product;
        
        // Only load on variable products
        if (!$product || !$product->is_type('variable')) {
            return;
        }
        
        // Check if any variation has a 3D model
        $has_3d_model = false;
        $available_variations = $product->get_available_variations();
        
        foreach ($available_variations as $variation) {
            $variation_id = $variation['variation_id'];
            $model_id = get_post_meta($variation_id, '_3d_model_id', true);
            if ($model_id) {
                $has_3d_model = true;
                break;
            }
        }
        
        if (!$has_3d_model) {
            return;
        }
        
        // Enqueue Three.js from CDN
        wp_enqueue_script(
            'threejs',
            'https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.min.js',
            array(),
            '0.160.0',
            true
        );
        
        // Enqueue GLTFLoader
        wp_enqueue_script(
            'threejs-gltf-loader',
            'https://cdn.jsdelivr.net/npm/three@0.160.0/examples/js/loaders/GLTFLoader.js',
            array('threejs'),
            '0.160.0',
            true
        );
        
        // Enqueue OBJLoader
        wp_enqueue_script(
            'threejs-obj-loader',
            'https://cdn.jsdelivr.net/npm/three@0.160.0/examples/js/loaders/OBJLoader.js',
            array('threejs'),
            '0.160.0',
            true
        );
        
        // Enqueue OrbitControls
        wp_enqueue_script(
            'threejs-orbit-controls',
            'https://cdn.jsdelivr.net/npm/three@0.160.0/examples/js/controls/OrbitControls.js',
            array('threejs'),
            '0.160.0',
            true
        );
        
        // Enqueue custom frontend script
        wp_enqueue_script(
            'wc-3d-viewer-frontend',
            WC_3D_VIEWER_PLUGIN_URL . 'assets/js/frontend.js',
            array('jquery', 'threejs', 'threejs-gltf-loader', 'threejs-obj-loader', 'threejs-orbit-controls'),
            WC_3D_VIEWER_VERSION,
            true
        );
        
        // Prepare variation 3D models data
        $variations_3d_data = array();
        foreach ($available_variations as $variation) {
            $variation_id = $variation['variation_id'];
            $model_id = get_post_meta($variation_id, '_3d_model_id', true);
            
            if ($model_id) {
                $model_url = wp_get_attachment_url($model_id);
                $variations_3d_data[$variation_id] = array(
                    'model_url' => $model_url,
                    'model_id' => $model_id,
                    'extension' => strtolower(pathinfo($model_url, PATHINFO_EXTENSION))
                );
            }
        }
        
        wp_localize_script('wc-3d-viewer-frontend', 'wc3dViewer', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wc_3d_viewer_nonce'),
            'variations_3d' => $variations_3d_data,
            'button_text' => __('View 3D', 'wc-3d-viewer'),
            'close_text' => __('Close 3D View', 'wc-3d-viewer'),
        ));
        
        // Enqueue frontend styles
        wp_enqueue_style(
            'wc-3d-viewer-frontend',
            WC_3D_VIEWER_PLUGIN_URL . 'assets/css/frontend.css',
            array(),
            WC_3D_VIEWER_VERSION
        );
    }
    
    /**
     * Add 3D button to product images
     */
    public function add_3d_button() {
        global $product;
        
        if (!$product || !$product->is_type('variable')) {
            return;
        }
        
        ?>
        <div id="wc-3d-viewer-button-container" style="display: none;">
            <button type="button" id="wc-3d-viewer-button" class="wc-3d-viewer-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span><?php esc_html_e('View 3D', 'wc-3d-viewer'); ?></span>
            </button>
        </div>
        
        <div id="wc-3d-viewer-modal" class="wc-3d-modal" style="display: none;">
            <div class="wc-3d-modal-overlay"></div>
            <div class="wc-3d-modal-content">
                <button type="button" class="wc-3d-modal-close">
                    <span>&times;</span>
                </button>
                <div id="wc-3d-viewer-container"></div>
                <div class="wc-3d-viewer-controls">
                    <p class="wc-3d-viewer-instructions">
                        <?php esc_html_e('Drag to rotate • Scroll to zoom • Right-click drag to pan', 'wc-3d-viewer'); ?>
                    </p>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * AJAX handler to get variation 3D model
     */
    public function get_variation_3d_model() {
        check_ajax_referer('wc_3d_viewer_nonce', 'nonce');
        
        if (empty($_POST['variation_id'])) {
            wp_send_json_error(array('message' => __('No variation ID provided', 'wc-3d-viewer')));
        }
        
        $variation_id = absint($_POST['variation_id']);
        $model_id = get_post_meta($variation_id, '_3d_model_id', true);
        
        if (!$model_id) {
            wp_send_json_error(array('message' => __('No 3D model found', 'wc-3d-viewer')));
        }
        
        $model_url = wp_get_attachment_url($model_id);
        
        if (!$model_url) {
            wp_send_json_error(array('message' => __('3D model file not found', 'wc-3d-viewer')));
        }
        
        wp_send_json_success(array(
            'model_url' => $model_url,
            'extension' => strtolower(pathinfo($model_url, PATHINFO_EXTENSION))
        ));
    }
}
