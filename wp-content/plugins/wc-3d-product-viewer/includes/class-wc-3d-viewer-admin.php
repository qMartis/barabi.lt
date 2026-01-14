<?php
/**
 * Admin functionality for 3D Viewer
 */

if (!defined('ABSPATH')) {
    exit;
}

class WC_3D_Viewer_Admin {
    
    /**
     * Constructor
     */
    public function __construct() {
        // Add variation settings
        add_action('woocommerce_product_after_variable_attributes', array($this, 'add_variation_3d_field'), 10, 3);
        add_action('woocommerce_save_product_variation', array($this, 'save_variation_3d_field'), 10, 2);
        
        // Add product-level 3D model settings
        add_action('add_meta_boxes', array($this, 'add_product_3d_meta_box'));
        add_action('woocommerce_product_options_general_product_data', array($this, 'add_default_3d_field'));
        add_action('woocommerce_process_product_meta', array($this, 'save_product_3d_model'));
        
        // Enqueue admin scripts
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        
        // AJAX handlers
        add_action('wp_ajax_wc_3d_upload_model', array($this, 'handle_3d_upload'));
        add_action('wp_ajax_wc_3d_remove_model', array($this, 'handle_3d_remove'));
    }
    
    /**
     * Enqueue admin scripts
     */
    public function enqueue_admin_scripts($hook) {
        global $post_type;
        
        if (('post.php' === $hook || 'post-new.php' === $hook) && 'product' === $post_type) {
            wp_enqueue_media();
            wp_enqueue_script(
                'wc-3d-viewer-admin',
                WC_3D_VIEWER_PLUGIN_URL . 'assets/js/admin.js',
                array('jquery'),
                WC_3D_VIEWER_VERSION,
                true
            );
            
            wp_localize_script('wc-3d-viewer-admin', 'wc3dViewerAdmin', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('wc_3d_viewer_nonce'),
                'upload_title' => __('Select 3D Model', 'wc-3d-viewer'),
                'upload_button' => __('Use this model', 'wc-3d-viewer'),
                'allowed_extensions' => array('glb', 'gltf', 'obj', 'fbx', 'stl'),
            ));
            
            wp_enqueue_style(
                'wc-3d-viewer-admin',
                WC_3D_VIEWER_PLUGIN_URL . 'assets/css/admin.css',
                array(),
                WC_3D_VIEWER_VERSION
            );
        }
    }
    
    /**
     * Add 3D model meta box for simple products
     */
    public function add_product_3d_meta_box() {
        add_meta_box(
            'wc_3d_product_model',
            __('3D Model', 'wc-3d-viewer'),
            array($this, 'render_product_3d_meta_box'),
            'product',
            'side',
            'default'
        );
    }
    
    /**
     * Render 3D model meta box
     */
    public function render_product_3d_meta_box($post) {
        $product = wc_get_product($post->ID);
        
        // Only show for simple products or as info for variable products
        if (!$product) {
            return;
        }
        
        $model_id = get_post_meta($post->ID, '_product_3d_model_id', true);
        $model_url = $model_id ? wp_get_attachment_url($model_id) : '';
        
        if ($product->is_type('variable')) {
            echo '<p>' . esc_html__('For variable products, set the default 3D model in General tab or add 3D models to individual variations below.', 'wc-3d-viewer') . '</p>';
            return;
        }
        
        wp_nonce_field('wc_3d_product_model_nonce', 'wc_3d_product_model_nonce');
        ?>
        <div class="wc-3d-model-upload-wrapper">
            <input 
                type="hidden" 
                name="_product_3d_model_id" 
                id="product_3d_model_id"
                value="<?php echo esc_attr($model_id); ?>"
                class="wc-3d-model-id"
            />
            
            <div class="wc-3d-model-preview">
                <?php if ($model_url) : ?>
                    <div class="wc-3d-model-info">
                        <span class="dashicons dashicons-media-3d"></span>
                        <span class="model-filename"><?php echo esc_html(basename($model_url)); ?></span>
                    </div>
                <?php else : ?>
                    <p><?php esc_html_e('No 3D model uploaded', 'wc-3d-viewer'); ?></p>
                <?php endif; ?>
            </div>
            
            <div class="wc-3d-model-actions">
                <button type="button" class="button wc-3d-upload-btn" data-loop="product">
                    <?php echo $model_url ? esc_html__('Change 3D Model', 'wc-3d-viewer') : esc_html__('Upload 3D Model', 'wc-3d-viewer'); ?>
                </button>
                
                <?php if ($model_url) : ?>
                    <button type="button" class="button wc-3d-remove-btn" data-loop="product">
                        <?php esc_html_e('Remove', 'wc-3d-viewer'); ?>
                    </button>
                <?php endif; ?>
            </div>
            
            <p class="description">
                <?php esc_html_e('Supported formats: GLB, GLTF, OBJ, FBX, STL', 'wc-3d-viewer'); ?>
            </p>
        </div>
        <?php
    }
    
    /**
     * Add default 3D model field for variable products in General tab
     */
    public function add_default_3d_field() {
        global $post;
        
        if (!$post || !$post->ID) {
            return;
        }
        
        $product = wc_get_product($post->ID);
        
        // Only show for variable products
        if (!$product || !$product->is_type('variable')) {
            return;
        }
        
        $model_id = get_post_meta($post->ID, '_product_3d_model_id', true);
        $model_url = $model_id ? wp_get_attachment_url($model_id) : '';
        
        echo '<div class="options_group">';
        
        echo '<p class="form-field"><strong>' . esc_html__('3D Model Settings', 'wc-3d-viewer') . '</strong></p>';
        
        woocommerce_wp_text_input(array(
            'id' => '_product_3d_model_id_display',
            'label' => __('Default 3D Model', 'wc-3d-viewer'),
            'desc_tip' => true,
            'description' => __('Default 3D model shown when no variation is selected. Click the button below to upload.', 'wc-3d-viewer'),
            'type' => 'hidden',
            'custom_attributes' => array('readonly' => 'readonly'),
            'value' => $model_url ? basename($model_url) : __('No model uploaded', 'wc-3d-viewer')
        ));
        
        ?>
        <p class="form-field">
            <label>&nbsp;</label>
            <div class="wc-3d-model-upload-wrapper">
                <input 
                    type="hidden" 
                    name="_product_3d_model_id" 
                    id="product_3d_model_id"
                    value="<?php echo esc_attr($model_id); ?>"
                    class="wc-3d-model-id"
                />
                
                <?php if ($model_url) : ?>
                    <div class="wc-3d-model-preview" style="margin-bottom: 10px;">
                        <div class="wc-3d-model-info">
                            <span class="dashicons dashicons-media-3d"></span>
                            <span class="model-filename"><?php echo esc_html(basename($model_url)); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
                
                <button type="button" class="button wc-3d-upload-btn" data-loop="product">
                    <?php echo $model_url ? esc_html__('Change 3D Model', 'wc-3d-viewer') : esc_html__('Upload 3D Model', 'wc-3d-viewer'); ?>
                </button>
                
                <?php if ($model_url) : ?>
                    <button type="button" class="button wc-3d-remove-btn" data-loop="product">
                        <?php esc_html_e('Remove', 'wc-3d-viewer'); ?>
                    </button>
                <?php endif; ?>
                
                <span class="description" style="display: block; margin-top: 5px;">
                    <?php esc_html_e('Supported formats: GLB, GLTF, OBJ, FBX, STL', 'wc-3d-viewer'); ?>
                </span>
            </div>
        </p>
        <?php
        
        echo '</div>';
    }
    
    /**
     * Add 3D model field to variation
     */
    public function add_variation_3d_field($loop, $variation_data, $variation) {
        $variation_id = $variation->ID;
        $model_id = get_post_meta($variation_id, '_3d_model_id', true);
        $model_url = '';
        
        if ($model_id) {
            $model_url = wp_get_attachment_url($model_id);
        }
        
        ?>
        <div class="form-row form-row-full wc-3d-model-field">
            <p class="form-field">
                <label><?php esc_html_e('3D Model', 'wc-3d-viewer'); ?></label>
                <span class="description"><?php esc_html_e('Upload a 3D model for this variation (GLB, GLTF, OBJ, FBX, STL)', 'wc-3d-viewer'); ?></span>
            </p>
            
            <div class="wc-3d-model-upload-wrapper">
                <input 
                    type="hidden" 
                    name="_3d_model_id[<?php echo esc_attr($loop); ?>]" 
                    id="3d_model_id_<?php echo esc_attr($loop); ?>"
                    value="<?php echo esc_attr($model_id); ?>"
                    class="wc-3d-model-id"
                />
                
                <div class="wc-3d-model-preview">
                    <?php if ($model_url) : ?>
                        <div class="wc-3d-model-info">
                            <span class="dashicons dashicons-media-3d"></span>
                            <span class="model-filename"><?php echo esc_html(basename($model_url)); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="wc-3d-model-actions">
                    <button type="button" class="button wc-3d-upload-btn" data-loop="<?php echo esc_attr($loop); ?>">
                        <?php echo $model_url ? esc_html__('Change 3D Model', 'wc-3d-viewer') : esc_html__('Upload 3D Model', 'wc-3d-viewer'); ?>
                    </button>
                    
                    <?php if ($model_url) : ?>
                        <button type="button" class="button wc-3d-remove-btn" data-loop="<?php echo esc_attr($loop); ?>">
                            <?php esc_html_e('Remove', 'wc-3d-viewer'); ?>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Save product-level 3D model
     */
    public function save_product_3d_model($post_id) {
        // Verify nonce for simple products
        if (isset($_POST['wc_3d_product_model_nonce']) && !wp_verify_nonce($_POST['wc_3d_product_model_nonce'], 'wc_3d_product_model_nonce')) {
            return;
        }
        
        if (isset($_POST['_product_3d_model_id'])) {
            $model_id = absint($_POST['_product_3d_model_id']);
            
            if ($model_id > 0) {
                $file_path = get_attached_file($model_id);
                if ($file_path && $this->is_valid_3d_file($file_path)) {
                    update_post_meta($post_id, '_product_3d_model_id', $model_id);
                } else {
                    delete_post_meta($post_id, '_product_3d_model_id');
                }
            } else {
                delete_post_meta($post_id, '_product_3d_model_id');
            }
        }
    }
    
    /**
     * Save variation 3D model field
     */
    public function save_variation_3d_field($variation_id, $loop) {
        if (isset($_POST['_3d_model_id'][$loop])) {
            $model_id = absint($_POST['_3d_model_id'][$loop]);
            
            if ($model_id > 0) {
                // Validate that it's a 3D model file
                $file_path = get_attached_file($model_id);
                if ($file_path && $this->is_valid_3d_file($file_path)) {
                    update_post_meta($variation_id, '_3d_model_id', $model_id);
                } else {
                    delete_post_meta($variation_id, '_3d_model_id');
                }
            } else {
                delete_post_meta($variation_id, '_3d_model_id');
            }
        }
    }
    
    /**
     * Validate if file is a 3D model
     */
    private function is_valid_3d_file($file_path) {
        $allowed_extensions = array('glb', 'gltf', 'obj', 'fbx', 'stl');
        $extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
        
        return in_array($extension, $allowed_extensions);
    }
    
    /**
     * Handle AJAX 3D model upload
     */
    public function handle_3d_upload() {
        check_ajax_referer('wc_3d_viewer_nonce', 'nonce');
        
        if (!current_user_can('edit_products')) {
            wp_send_json_error(array('message' => __('Permission denied', 'wc-3d-viewer')));
        }
        
        if (empty($_POST['attachment_id'])) {
            wp_send_json_error(array('message' => __('No attachment ID provided', 'wc-3d-viewer')));
        }
        
        $attachment_id = absint($_POST['attachment_id']);
        $file_path = get_attached_file($attachment_id);
        
        if (!$this->is_valid_3d_file($file_path)) {
            wp_send_json_error(array('message' => __('Invalid 3D model file format', 'wc-3d-viewer')));
        }
        
        $file_url = wp_get_attachment_url($attachment_id);
        
        wp_send_json_success(array(
            'id' => $attachment_id,
            'url' => $file_url,
            'filename' => basename($file_url)
        ));
    }
    
    /**
     * Handle AJAX 3D model removal
     */
    public function handle_3d_remove() {
        check_ajax_referer('wc_3d_viewer_nonce', 'nonce');
        
        if (!current_user_can('edit_products')) {
            wp_send_json_error(array('message' => __('Permission denied', 'wc-3d-viewer')));
        }
        
        wp_send_json_success();
    }
}
