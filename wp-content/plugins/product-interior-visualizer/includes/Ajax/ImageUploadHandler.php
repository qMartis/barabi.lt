<?php
/**
 * Image Upload AJAX Handler
 *
 * @package ProductInteriorVisualizer
 */

namespace PIV\Ajax;

class ImageUploadHandler {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'wp_ajax_piv_generate_visualization', array( $this, 'handle_generate_visualization' ) );
		add_action( 'wp_ajax_nopriv_piv_generate_visualization', array( $this, 'handle_generate_visualization' ) );
	}

	/**
	 * Handle visualization generation
	 */
	public function handle_generate_visualization() {
		// Verify nonce
		if ( ! check_ajax_referer( 'piv_nonce', 'nonce', false ) ) {
			wp_send_json_error( array(
				'message' => __( 'Security check failed.', 'product-interior-visualizer' ),
			));
		}

		// Check if file was uploaded
		if ( empty( $_FILES['image'] ) ) {
			wp_send_json_error( array(
				'message' => __( 'No image uploaded.', 'product-interior-visualizer' ),
			));
		}

		// Get product ID
		$product_id = absint( $_POST['product_id'] ?? 0 );
		if ( ! $product_id ) {
			wp_send_json_error( array(
				'message' => __( 'Invalid product ID.', 'product-interior-visualizer' ),
			));
		}

		// Check usage limits
		$limit_checker = new \PIV\Core\LimitChecker();
		if ( ! $limit_checker->can_make_request() ) {
			wp_send_json_error( array(
				'message' => __( 'Daily request limit reached. Please try again tomorrow.', 'product-interior-visualizer' ),
				'limit_reached' => true,
			));
		}

		// Validate and upload image
		$uploaded_image = $this->handle_image_upload();
		if ( is_wp_error( $uploaded_image ) ) {
			wp_send_json_error( array(
				'message' => $uploaded_image->get_error_message(),
			));
		}

		// Get product image
		$product = wc_get_product( $product_id );
		if ( ! $product ) {
			wp_send_json_error( array(
				'message' => __( 'Product not found.', 'product-interior-visualizer' ),
			));
		}

		$product_image_id = $product->get_image_id();
		$product_image_path = get_attached_file( $product_image_id );

		if ( ! $product_image_path || ! file_exists( $product_image_path ) ) {
			wp_send_json_error( array(
				'message' => __( 'Product image not found.', 'product-interior-visualizer' ),
			));
		}

		// Generate visualization
		$api_handler = new \PIV\API\GeminiHandler();
		$result = $api_handler->generate_visualization(
			$uploaded_image['file'],
			$product_image_path,
			$product_id
		);

		if ( ! $result['success'] ) {
			// Clean up uploaded file
			wp_delete_file( $uploaded_image['file'] );
			
			wp_send_json_error( array(
				'message' => $result['error'] ?? __( 'Failed to generate visualization.', 'product-interior-visualizer' ),
				'api_response' => $result['api_response'] ?? null,
			));
		}

		// Log request
		$limit_checker->log_request( $product_id );

		// Return success with image URLs and API response
		wp_send_json_success( array(
			'original_image' => $uploaded_image['url'],
			'visualized_image' => $result['image_url'],
			'remaining_requests' => $limit_checker->get_remaining_requests(),
			'api_response' => $result['api_response'] ?? null,
		));
	}

	/**
	 * Handle image upload
	 *
	 * @return array|WP_Error
	 */
	private function handle_image_upload() {
		// Validate file
		$file = $_FILES['image'];
		
		// Check file size
		$max_size = absint( get_option( 'piv_image_max_size', 5 ) ) * 1024 * 1024; // Convert MB to bytes
		if ( $file['size'] > $max_size ) {
			return new \WP_Error(
				'file_too_large',
				sprintf(
					__( 'File size exceeds maximum allowed size of %dMB.', 'product-interior-visualizer' ),
					absint( get_option( 'piv_image_max_size', 5 ) )
				)
			);
		}

		// Check file type
		$allowed_types = array( 'image/jpeg', 'image/jpg', 'image/png', 'image/webp' );
		$file_type = wp_check_filetype( $file['name'] );
		
		if ( ! in_array( $file['type'], $allowed_types, true ) ) {
			return new \WP_Error(
				'invalid_file_type',
				__( 'Invalid file type. Only JPG, PNG, and WEBP images are allowed.', 'product-interior-visualizer' )
			);
		}

		// Upload file
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );

		$upload_overrides = array(
			'test_form' => false,
			'test_type' => true,
		);

		$uploaded_file = wp_handle_upload( $file, $upload_overrides );

		if ( isset( $uploaded_file['error'] ) ) {
			return new \WP_Error( 'upload_error', $uploaded_file['error'] );
		}

		return $uploaded_file;
	}
}
