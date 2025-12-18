<?php
/**
 * Gemini API Handler
 *
 * @package ProductInteriorVisualizer
 */

namespace PIV\API;

class GeminiHandler {
	/**
	 * API endpoint
	 */
	const API_ENDPOINT = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-image:generateContent';

	/**
	 * Generate visualization
	 *
	 * @param string $user_image_path Path to user's uploaded image
	 * @param string $product_image_path Path to product image
	 * @param int $product_id Product ID
	 * @return array Response with success status and image data
	 */
	public function generate_visualization( $user_image_path, $product_image_path, $product_id ) {
		$api_key = get_option( 'piv_api_key' );
		
		if ( empty( $api_key ) ) {
			return array(
				'success' => false,
				'error' => __( 'API key not configured.', 'product-interior-visualizer' ),
			);
		}

		// Retry logic for API failures
		$max_retries = 2;
		$retry_count = 0;
		
		while ( $retry_count <= $max_retries ) {
			try {
				// Read and encode images to base64
				$user_image_data = $this->encode_image( $user_image_path );
				$product_image_data = $this->encode_image( $product_image_path );

				if ( ! $user_image_data || ! $product_image_data ) {
					return array(
						'success' => false,
						'error' => __( 'Failed to process images.', 'product-interior-visualizer' ),
					);
				}

				// Prepare API request
				$request_body = $this->prepare_request_body( $user_image_data, $product_image_data, $product_id );

				// Make API request
				$response = wp_remote_post( self::API_ENDPOINT . '?key=' . $api_key, array(
					'timeout' => 200,
					'headers' => array(
						'Content-Type' => 'application/json',
					),
					'body' => wp_json_encode( $request_body ),
				));

				if ( is_wp_error( $response ) ) {
					if ( $retry_count < $max_retries ) {
						$retry_count++;
						sleep( 2 ); // Wait 2 seconds before retry
						continue;
					}
					return array(
						'success' => false,
						'error' => $response->get_error_message(),
					);
				}

				$response_code = wp_remote_retrieve_response_code( $response );
				$response_body = wp_remote_retrieve_body( $response );
			   
				$data = json_decode( $response_body, true );

				// Retry on 500 errors
				if ( 500 === $response_code && $retry_count < $max_retries ) {
					$retry_count++;
					sleep( 2 );
					continue;
				}

				if ( 200 !== $response_code ) {
					$error_message = $data['error']['message'] ?? __( 'API request failed.', 'product-interior-visualizer' );
					return array(
						'success' => false,
						'error' => $error_message,
						'api_response' => $data,
						'response_code' => $response_code,
					);
				}

				// Process response
				return $this->process_response( $data );

			} catch ( \Exception $e ) {
				if ( $retry_count < $max_retries ) {
					$retry_count++;
					sleep( 2 );
					continue;
				}
				return array(
					'success' => false,
					'error' => $e->getMessage(),
				);
			}
		}
		
		return array(
			'success' => false,
			'error' => __( 'API request failed after multiple retries.', 'product-interior-visualizer' ),
		);
	}

	/**
	 * Encode image to base64
	 *
	 * @param string $image_path
	 * @return string|false
	 */
	private function encode_image( $image_path ) {
		if ( ! file_exists( $image_path ) ) {
			return false;
		}

		$image_data = file_get_contents( $image_path );
		if ( false === $image_data ) {
			return false;
		}

		return base64_encode( $image_data );
	}

	/**
	 * Prepare request body
	 *
	 * @param string $user_image_data
	 * @param string $product_image_data
	 * @param int $product_id
	 * @return array
	 */
	private function prepare_request_body( $user_image_data, $product_image_data, $product_id ) {
		$product = wc_get_product( $product_id );
		$product_name = $product ? $product->get_name() : 'this product';

		$prompt = sprintf(
			'You are an expert interior designer. I have two images: 
			1. An interior room photo
			2. A product image of %s

			Please create a photorealistic visualization showing how this product would look naturally placed in the interior room. 
			The product should be seamlessly integrated into the space, maintaining proper perspective, lighting, and shadows.
			Make sure the product fits the scale and style of the room.
			Return the resulting image.',
			$product_name
		);

		return array(
			'contents' => array(
				array(
					'parts' => array(
						array(
							'text' => $prompt,
						),
						array(
							'inline_data' => array(
								'mime_type' => 'image/jpeg',
								'data' => $user_image_data,
							),
						),
						array(
							'inline_data' => array(
								'mime_type' => 'image/jpeg',
								'data' => $product_image_data,
							),
						),
					),
				),
			),
			'generationConfig' => array(
				'temperature' => 0.7,
				'topK' => 40,
				'topP' => 0.95,
				'maxOutputTokens' => 1024,
			),
		);
	}

	/**
	 * Process API response
	 *
	 * @param array $data
	 * @return array
	 */
	private function process_response( $data ) {
		if ( ! isset( $data['candidates'][0]['content']['parts'] ) ) {
			return array(
				'success' => false,
				'error' => __( 'No visualization generated.', 'product-interior-visualizer' ),
				'api_response' => $data,
			);
		}

		$parts = $data['candidates'][0]['content']['parts'];

		// Loop through parts to find the image data
		foreach ( $parts as $part ) {
			if ( isset( $part['inlineData']['data'] ) ) {
				$image_data = $part['inlineData']['data'];
				$mime_type = $part['inlineData']['mimeType'] ?? 'image/jpeg';

				// Save image to uploads directory
				$saved_image = $this->save_generated_image( $image_data, $mime_type );

				if ( $saved_image ) {
					return array(
						'success' => true,
						'image_url' => $saved_image['url'],
						'image_path' => $saved_image['path'],
						'api_response' => $data,
					);
				}
			}
		}

		return array(
			'success' => false,
			'error' => __( 'Failed to save generated image.', 'product-interior-visualizer' ),
			'api_response' => $data,
		);
	}

	/**
	 * Save generated image
	 *
	 * @param string $image_data Base64 encoded image
	 * @param string $mime_type
	 * @return array|false
	 */
	private function save_generated_image( $image_data, $mime_type ) {
		$upload_dir = wp_upload_dir();
		$piv_dir = $upload_dir['basedir'] . '/piv-visualizations';

		// Create directory if it doesn't exist
		if ( ! file_exists( $piv_dir ) ) {
			$created = wp_mkdir_p( $piv_dir );
			error_log( 'PIV Creating directory: ' . $piv_dir . ' - ' . ( $created ? 'Success' : 'Failed' ) );
		}

		// Check if directory is writable
		if ( ! is_writable( $piv_dir ) ) {
			error_log( 'PIV Error: Directory not writable: ' . $piv_dir );
			return false;
		}

		// Generate unique filename
		$extension = 'jpeg';
		if ( strpos( $mime_type, 'png' ) !== false ) {
			$extension = 'png';
		} elseif ( strpos( $mime_type, 'webp' ) !== false ) {
			$extension = 'webp';
		}

		$filename = 'visualization-' . wp_generate_password( 12, false ) . '.' . $extension;
		$file_path = $piv_dir . '/' . $filename;

		// Decode and save image
		$decoded_data = base64_decode( $image_data );
		
		if ( false === $decoded_data || empty( $decoded_data ) ) {
			error_log( 'PIV Error: Failed to decode base64 image data' );
			return false;
		}

		error_log( 'PIV Attempting to save file: ' . $file_path . ' (size: ' . strlen( $decoded_data ) . ' bytes)' );
		$saved = file_put_contents( $file_path, $decoded_data );

		if ( false === $saved ) {
			error_log( 'PIV Error: file_put_contents failed for: ' . $file_path );
			return false;
		}

		error_log( 'PIV Success: Saved ' . $saved . ' bytes to: ' . $file_path );

		$file_url = $upload_dir['baseurl'] . '/piv-visualizations/' . $filename;

		return array(
			'path' => $file_path,
			'url' => $file_url,
		);
	}
}
