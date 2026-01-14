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
        
        // Add 3D button and overlay HTML
        add_action('woocommerce_before_single_product_summary', array($this, 'add_3d_button'), 5);
        
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
        
        // Get product object if not set or if it's not an object
        if (!is_object($product)) {
            $product = wc_get_product(get_the_ID());
        }
        
        if (!$product || !is_object($product)) {
            return;
        }
        
        $has_3d_model = false;
        $product_3d_model = null;
        $variations_3d_data = array();
        
        // Check for product-level 3D model (for simple products or default for variable)
        $product_model_id = get_post_meta($product->get_id(), '_product_3d_model_id', true);
        if ($product_model_id) {
            $has_3d_model = true;
            $product_model_url = wp_get_attachment_url($product_model_id);
            if ($product_model_url) {
                $product_3d_model = array(
                    'model_url' => $product_model_url,
                    'model_id' => $product_model_id,
                    'extension' => strtolower(pathinfo($product_model_url, PATHINFO_EXTENSION))
                );
            }
        }
        
        // For variable products, check variations
        if ($product->is_type('variable')) {
            $available_variations = $product->get_available_variations();
            
            foreach ($available_variations as $variation) {
                $variation_id = $variation['variation_id'];
                $model_id = get_post_meta($variation_id, '_3d_model_id', true);
                if ($model_id) {
                    $has_3d_model = true;
                    $model_url = wp_get_attachment_url($model_id);
                    $variations_3d_data[$variation_id] = array(
                        'model_url' => $model_url,
                        'model_id' => $model_id,
                        'extension' => strtolower(pathinfo($model_url, PATHINFO_EXTENSION))
                    );
                }
            }
        }
        
        if (!$has_3d_model) {
            return;
        }
        
        // Enqueue custom frontend script as module
        wp_enqueue_script(
            'wc-3d-viewer-frontend',
            WC_3D_VIEWER_PLUGIN_URL . 'assets/js/frontend.js',
            array('jquery'),
            WC_3D_VIEWER_VERSION,
            true
        );
        
        // Add module type for frontend script
        add_filter('script_loader_tag', array($this, 'add_type_attribute'), 10, 3);
        
        wp_localize_script('wc-3d-viewer-frontend', 'wc3dViewer', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wc_3d_viewer_nonce'),
            'product_3d' => $product_3d_model,
            'variations_3d' => $variations_3d_data,
            'is_variable' => $product->is_type('variable'),
            'button_text' => __('View 3D', 'wc-3d-viewer'),
            'close_text' => __('Close 3D View', 'wc-3d-viewer'),
            'plugin_url' => WC_3D_VIEWER_PLUGIN_URL,
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
     * Add 3D button and overlay HTML
     */
    public function add_3d_button() {
        global $product;
        
        // Get product object if not set or if it's not an object
        if (!is_object($product)) {
            $product = wc_get_product(get_the_ID());
        }
        
        if (!$product || !is_object($product)) {
            return;
        }
        
        // Check if product has any 3D model
        $has_3d = false;
        
        // Check product-level model
        if (get_post_meta($product->get_id(), '_product_3d_model_id', true)) {
            $has_3d = true;
        }
        
        // For variable products, check variations
        if (!$has_3d && $product->is_type('variable')) {
            $available_variations = $product->get_available_variations();
            foreach ($available_variations as $variation) {
                if (get_post_meta($variation['variation_id'], '_3d_model_id', true)) {
                    $has_3d = true;
                    break;
                }
            }
        }
        
        if (!$has_3d) {
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
        
        <div id="wc-3d-viewer-overlay" style="display: none;">
            <button type="button" id="wc-3d-close-btn" class="wc-3d-close-btn">
                <span>&times;</span>
            </button>
            <div id="wc-3d-viewer-container"></div>
            <div class="wc-3d-viewer-instructions">
                <?php esc_html_e('Drag to rotate • Scroll to zoom • Right-click drag to pan', 'wc-3d-viewer'); ?>
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
    
    /**
     * Add type="module" to specific scripts
     */
    public function add_type_attribute($tag, $handle, $src) {
        if ('wc-3d-viewer-frontend' === $handle) {
            $tag = str_replace('<script ', '<script type="module" ', $tag);
        }
        
        return $tag;
    }
}
