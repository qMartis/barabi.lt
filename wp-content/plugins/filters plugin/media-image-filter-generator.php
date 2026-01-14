<?php
/**
 * Plugin Name: Media Image Filter Generator
 * Plugin URI: ttps://weso.lt
 * Description: Generate new filtered image variants directly from the WordPress Media Library modal. Never modifies originals.
 * Version: 1.0.0
 * Author: Martynas Beržinskas Barabi.jp
 * Author URI: https://weso.lt
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: media-image-filter-generator
 * Requires at least: 5.0
 * Requires PHP: 7.2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin constants
define( 'MIFG_VERSION', '1.0.0' );
define( 'MIFG_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'MIFG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Initialize plugin
 */
class Media_Image_Filter_Generator {
    
    /**
     * Available filters
     */
    private $filters = array(
        'bw'    => 'Black & White',
        'vivid' => 'Vivid',
        'warm'  => 'Warm',
        'cold'  => 'Cold'
    );
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
        add_action( 'wp_ajax_generate_filtered_image', array( $this, 'ajax_generate_filtered_image' ) );
    }
    
    /**
     * Enqueue admin scripts and styles
     */
    public function enqueue_admin_scripts( $hook ) {
        // Load on all admin pages - media modal can be opened from many places
        // This ensures compatibility with Gutenberg, WooCommerce, and custom admin pages
        
        // Ensure media scripts are loaded
        wp_enqueue_media();
        
        wp_enqueue_script(
            'mifg-media-modal',
            MIFG_PLUGIN_URL . 'admin/media-modal.js',
            array( 'media-editor', 'media-views', 'underscore', 'jquery', 'wp-util' ),
            MIFG_VERSION,
            true
        );
        
        wp_localize_script( 'mifg-media-modal', 'mifgData', array(
            'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
            'nonce'     => wp_create_nonce( 'mifg_generate_filter' ),
            'filters'   => $this->filters,
            'strings'   => array(
                'label'        => __( 'Generate Filtered Image', 'media-image-filter-generator' ),
                'button'       => __( 'Apply & Create', 'media-image-filter-generator' ),
                'processing'   => __( 'Generating...', 'media-image-filter-generator' ),
                'success'      => __( 'Filtered image created successfully!', 'media-image-filter-generator' ),
                'error'        => __( 'Error generating filtered image.', 'media-image-filter-generator' ),
                'selectFilter' => __( 'Select a filter', 'media-image-filter-generator' )
            )
        ) );
    }
    
    /**
     * AJAX handler for generating filtered images
     */
    public function ajax_generate_filtered_image() {
        // Log the request
        error_log('MIFG: AJAX request received - ' . print_r($_POST, true));
        
        // Verify nonce first
        $nonce_check = isset( $_POST['_ajax_nonce'] ) && wp_verify_nonce( $_POST['_ajax_nonce'], 'mifg_generate_filter' );
        
        if ( ! $nonce_check ) {
            error_log('MIFG: Nonce verification failed');
            wp_send_json_error( array(
                'message' => __( 'Security check failed. Please refresh the page.', 'media-image-filter-generator' )
            ) );
            wp_die();
        }
        
        error_log('MIFG: Nonce verified successfully');
        
        // Check user capability
        if ( ! current_user_can( 'upload_files' ) ) {
            error_log('MIFG: User lacks upload_files capability');
            wp_send_json_error( array(
                'message' => __( 'You do not have permission to upload files.', 'media-image-filter-generator' )
            ) );
            wp_die();
        }
        
        // Get and validate parameters
        $attachment_id = isset( $_POST['attachmentId'] ) ? intval( $_POST['attachmentId'] ) : 0;
        $filter        = isset( $_POST['filter'] ) ? sanitize_key( $_POST['filter'] ) : '';
        
        error_log('MIFG: Processing attachment ID: ' . $attachment_id . ', filter: ' . $filter);
        
        if ( ! $attachment_id ) {
            error_log('MIFG: Invalid attachment ID');
            wp_send_json_error( array(
                'message' => __( 'Invalid attachment ID.', 'media-image-filter-generator' )
            ) );
            wp_die();
        }
        
        if ( ! array_key_exists( $filter, $this->filters ) ) {
            error_log('MIFG: Invalid filter specified: ' . $filter);
            wp_send_json_error( array(
                'message' => __( 'Invalid filter specified.', 'media-image-filter-generator' )
            ) );
            wp_die();
        }
        
        // Validate attachment is an image
        if ( ! wp_attachment_is_image( $attachment_id ) ) {
            error_log('MIFG: Attachment is not an image');
            wp_send_json_error( array(
                'message' => __( 'Attachment must be an image.', 'media-image-filter-generator' )
            ) );
            wp_die();
        }
        
        // Generate filtered image
        try {
            $result = $this->generate_filtered_image( $attachment_id, $filter );
            
            if ( is_wp_error( $result ) ) {
                error_log('MIFG: Error generating filtered image: ' . $result->get_error_message());
                wp_send_json_error( array(
                    'message' => $result->get_error_message()
                ) );
                wp_die();
            }
            
            error_log('MIFG: Successfully created filtered image with ID: ' . $result);
            wp_send_json_success( array(
                'attachment_id' => $result,
                'message'       => __( 'Filtered image created successfully!', 'media-image-filter-generator' )
            ) );
            wp_die();
        } catch ( Exception $e ) {
            error_log('MIFG: Exception during image generation: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            wp_send_json_error( array(
                'message' => sprintf( __( 'Error: %s', 'media-image-filter-generator' ), $e->getMessage() )
            ) );
            wp_die();
        }
    }
    
    /**
     * Generate filtered image
     *
     * @param int    $attachment_id Original attachment ID
     * @param string $filter        Filter key
     * @return int|WP_Error New attachment ID or error
     */
    private function generate_filtered_image( $attachment_id, $filter ) {
        error_log('MIFG: generate_filtered_image called');
        
        // Get original file path
        $original_file = get_attached_file( $attachment_id );
        error_log('MIFG: Original file path: ' . $original_file);
        
        if ( ! $original_file || ! file_exists( $original_file ) ) {
            error_log('MIFG: File not found or does not exist');
            return new WP_Error( 'file_not_found', __( 'Original image file not found.', 'media-image-filter-generator' ) );
        }
        
        // Get mime type
        $mime_type = get_post_mime_type( $attachment_id );
        error_log('MIFG: MIME type: ' . $mime_type);
        
        // Load image using GD
        $image = null;
        switch ( $mime_type ) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg( $original_file );
                break;
            case 'image/png':
                $image = imagecreatefrompng( $original_file );
                break;
            case 'image/gif':
                $image = imagecreatefromgif( $original_file );
                break;
            case 'image/webp':
                $image = imagecreatefromwebp( $original_file );
                break;
            default:
                return new WP_Error( 'unsupported_type', __( 'Unsupported image type.', 'media-image-filter-generator' ) );
        }
        
        if ( ! $image ) {
            error_log('MIFG: Failed to load image with GD');
            return new WP_Error( 'load_error', __( 'Failed to load image.', 'media-image-filter-generator' ) );
        }
        
        error_log('MIFG: Image loaded, applying filter: ' . $filter);
        
        // Apply filter
        $filter_result = $this->apply_filter( $image, $filter );
        
        if ( is_wp_error( $filter_result ) ) {
            imagedestroy( $image );
            error_log('MIFG: Filter application error: ' . $filter_result->get_error_message());
            return $filter_result;
        }
        
        error_log('MIFG: Filter applied successfully, generating filename');
        
        // Generate new filename
        $pathinfo     = pathinfo( $original_file );
        $upload_dir   = wp_upload_dir();
        $new_filename = $pathinfo['filename'] . '-' . $filter . '.' . $pathinfo['extension'];
        $new_file     = $upload_dir['path'] . '/' . $new_filename;
        
        error_log('MIFG: New file will be: ' . $new_file);
        
        // Handle filename collisions
        $counter = 1;
        while ( file_exists( $new_file ) ) {
            $new_filename = $pathinfo['filename'] . '-' . $filter . '-' . $counter . '.' . $pathinfo['extension'];
            $new_file     = $upload_dir['path'] . '/' . $new_filename;
            $counter++;
        }
        
        error_log('MIFG: Saving image to: ' . $new_file);
        
        // Save image based on type
        $save_result = false;
        switch ( $mime_type ) {
            case 'image/jpeg':
                $save_result = imagejpeg( $image, $new_file, 90 );
                break;
            case 'image/png':
                $save_result = imagepng( $image, $new_file, 9 );
                break;
            case 'image/gif':
                $save_result = imagegif( $image, $new_file );
                break;
            case 'image/webp':
                $save_result = imagewebp( $image, $new_file, 90 );
                break;
        }
        
        // Free memory
        imagedestroy( $image );
        
        if ( ! $save_result ) {
            error_log('MIFG: Failed to save image');
            return new WP_Error( 'save_error', __( 'Failed to save filtered image.', 'media-image-filter-generator' ) );
        }
        
        error_log('MIFG: Image saved successfully, creating attachment');
        
        // Get original attachment data
        $original_post = get_post( $attachment_id );
        
        // Prepare attachment data
        $attachment = array(
            'post_mime_type' => $mime_type,
            'post_title'     => $original_post->post_title . ' (' . $this->filters[ $filter ] . ')',
            'post_content'   => $original_post->post_content,
            'post_excerpt'   => $original_post->post_excerpt,
            'post_status'    => 'inherit'
        );
        
        // Insert attachment
        $new_attachment_id = wp_insert_attachment( $attachment, $new_file );
        
        if ( is_wp_error( $new_attachment_id ) ) {
            // Clean up file on error
            @unlink( $new_file );
            return new WP_Error( 'insert_error', __( 'Failed to create attachment.', 'media-image-filter-generator' ) );
        }
        
        // Generate and update attachment metadata
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        $attach_data = wp_generate_attachment_metadata( $new_attachment_id, $new_file );
        wp_update_attachment_metadata( $new_attachment_id, $attach_data );
        
        // Store reference to original attachment
        update_post_meta( $new_attachment_id, '_generated_from_attachment', $attachment_id );
        update_post_meta( $new_attachment_id, '_applied_filter', $filter );
        
        return $new_attachment_id;
    }
    
    /**
     * Apply filter to image using PHP GD
     *
     * @param resource $image  GD image resource
     * @param string   $filter Filter key
     * @return true|WP_Error
     */
    private function apply_filter( $image, $filter ) {
        error_log('MIFG: apply_filter called for: ' . $filter);
        
        switch ( $filter ) {
            case 'bw':
                // Black & White
                if ( imagefilter( $image, IMG_FILTER_GRAYSCALE ) ) {
                    error_log('MIFG: BW filter applied');
                    return true;
                }
                break;
                
            case 'vivid':
                // Vivid - boost contrast and brightness
                if ( imagefilter( $image, IMG_FILTER_CONTRAST, -20 ) && 
                     imagefilter( $image, IMG_FILTER_BRIGHTNESS, 10 ) ) {
                    error_log('MIFG: Vivid filter applied');
                    return true;
                }
                break;
                
            case 'warm':
                // Warm - add red and yellow, reduce blue
                if ( imagefilter( $image, IMG_FILTER_COLORIZE, 40, 20, -40 ) ) {
                    error_log('MIFG: Warm filter applied');
                    return true;
                }
                break;
                
            case 'cold':
                // Cold - reduce red, add blue
                if ( imagefilter( $image, IMG_FILTER_COLORIZE, -40, 0, 40 ) ) {
                    error_log('MIFG: Cold filter applied');
                    return true;
                }
                break;
                
            default:
                return new WP_Error( 'invalid_filter', __( 'Invalid filter specified.', 'media-image-filter-generator' ) );
        }
        
        error_log('MIFG: Filter failed to apply');
        return new WP_Error( 'filter_error', __( 'Failed to apply filter.', 'media-image-filter-generator' ) );
    }
}

// Initialize plugin
new Media_Image_Filter_Generator();
