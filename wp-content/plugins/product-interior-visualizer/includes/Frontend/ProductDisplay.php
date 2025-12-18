<?php
/**
 * Product Display Handler
 *
 * @package ProductInteriorVisualizer
 */

namespace PIV\Frontend;

class ProductDisplay {
	/**
	 * Constructor
	 */
	public function __construct() {
		// Auto-display on product pages
		add_action( 'woocommerce_after_single_product_summary', array( $this, 'display_visualizer' ), 9 );
	}

	/**
	 * Display visualizer on product page
	 */
	public function display_visualizer() {
		// Check if we're on a product page
		if ( ! is_product() ) {
			return;
		}

		// Get product
		global $product;
		if ( ! $product || ! is_a( $product, 'WC_Product' ) ) {
			return;
		}

		// Check if visualizer is enabled for this product
		$enabled = get_post_meta( $product->get_id(), '_piv_enabled', true );
		if ( $enabled !== 'yes' ) {
			return;
		}

		// Check if API key is set
		$api_key = get_option( 'piv_api_key' );
		if ( empty( $api_key ) ) {
			echo $this->render_error( __( 'API key not configured. Please contact site administrator.', 'product-interior-visualizer' ) );
			return;
		}

		// Check usage limits
		$limit_checker = new \PIV\Core\LimitChecker();
		if ( ! $limit_checker->can_make_request() ) {
			echo $this->render_error( __( 'Daily request limit reached. Please try again tomorrow.', 'product-interior-visualizer' ) );
			return;
		}

		// Render visualizer
		$this->render_visualizer_html( $product );
	}

	/**
	 * Render visualizer HTML
	 *
	 * @param \WC_Product $product
	 */
	private function render_visualizer_html( $product ) {
		$product_id = $product->get_id();
		$product_image = wp_get_attachment_image_url( $product->get_image_id(), 'large' );
		$product_name = $product->get_name();
		?>
		<div class="piv-visualizer-container" data-product-id="<?php echo esc_attr( $product_id ); ?>">
			<div class="piv-visualizer-content">
				<div class="piv-upload-section">
					<h2 class="qodef-h3  "><?php esc_html_e( 'Try in interior:', 'product-interior-visualizer' ); ?></h2>
					<p><?php esc_html_e( 'Upload interior picture and see how product looks in it.', 'product-interior-visualizer' ); ?></p>
					
					<div class="piv-upload-area">
						<input type="file" 
							   id="piv-image-upload" 
							   accept="image/*" 
							   class="piv-file-input">
						<label for="piv-image-upload" class="piv-upload-label">
							<svg class="piv-upload-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
							</svg>
							<span class="piv-upload-text"><?php esc_html_e( 'Click to upload or drag and drop', 'product-interior-visualizer' ); ?></span>
							<span class="piv-upload-hint"><?php esc_html_e( 'JPG, PNG or WEBP (MAX. 5MB)', 'product-interior-visualizer' ); ?></span>
						</label>
						<div class="piv-preview-container" style="display:none;">
							<img src="" alt="Preview" class="piv-preview-image">
							<button type="button" class="piv-remove-image">&times;</button>
						</div>
					</div>

					<button type="button" class="piv-visualize-btn button" disabled>
						<?php esc_html_e( 'Visualize Interior', 'product-interior-visualizer' ); ?>
					</button>
				</div>

				<div class="piv-product-section">
					<div class="piv-loading" style="display:none;">
						<div class="piv-spinner"></div>
						<p class="piv-loading-text"><?php esc_html_e( 'AI is creating your visualization...', 'product-interior-visualizer' ); ?></p>
					</div>
				
					<?php if ( $product_image ) : ?>
						<img src="<?php echo esc_url( $product_image ); ?>" 
							 alt="<?php echo esc_attr( $product_name ); ?>" 
							 class="piv-product-image">
					<?php endif; ?>
					
					<button type="button" class="piv-save-image-btn button" style="display:none;">
						<?php esc_html_e( 'Save Image', 'product-interior-visualizer' ); ?>
					</button>
				</div>
			</div>

			<div class="piv-result-container" style="display:none;">
				<h3><?php esc_html_e( 'Your Visualization', 'product-interior-visualizer' ); ?></h3>
				<div class="piv-result-images">
					<div class="piv-result-image-wrapper">
						<h4><?php esc_html_e( 'Original', 'product-interior-visualizer' ); ?></h4>
						<img src="" alt="Original" class="piv-original-image">
					</div>
					<div class="piv-result-image-wrapper">
						<h4><?php esc_html_e( 'With Product', 'product-interior-visualizer' ); ?></h4>
						<img src="" alt="Visualization" class="piv-visualized-image">
					</div>
				</div>
				<button type="button" class="piv-try-again-btn btn">
					<?php esc_html_e( 'Try Another Image', 'product-interior-visualizer' ); ?>
				</button>
			</div>
		</div>
		<?php
	}

	/**
	 * Render error message
	 *
	 * @param string $message
	 * @return string
	 */
	private function render_error( $message ) {
		return sprintf(
			'<div class="piv-error-message"><p>%s</p></div>',
			esc_html( $message )
		);
	}
}
