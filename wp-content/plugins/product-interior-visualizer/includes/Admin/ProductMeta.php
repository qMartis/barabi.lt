<?php
/**
 * Product Meta Box
 *
 * @package ProductInteriorVisualizer
 */

namespace PIV\Admin;

class ProductMeta {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'save_meta_box' ) );
	}

	/**
	 * Add meta box
	 */
	public function add_meta_box() {
		add_meta_box(
			'piv_product_visualizer',
			__( 'Interior Visualizer', 'product-interior-visualizer' ),
			array( $this, 'render_meta_box' ),
			'product',
			'side',
			'default'
		);
	}

	/**
	 * Render meta box
	 *
	 * @param \WP_Post $post
	 */
	public function render_meta_box( $post ) {
		// Add nonce for security
		wp_nonce_field( 'piv_save_meta_box', 'piv_meta_box_nonce' );

		// Get current value
		$enabled = get_post_meta( $post->ID, '_piv_enabled', true );
		?>
		<div class="piv-meta-box">
			<p>
				<label>
					<input type="checkbox" 
						   name="piv_enabled" 
						   value="yes" 
						   <?php checked( $enabled, 'yes' ); ?>>
					<?php esc_html_e( 'Enable AI Visualizer', 'product-interior-visualizer' ); ?>
				</label>
			</p>
			<p class="description">
				<?php esc_html_e( 'Allow customers to visualize this product in their interior photos using AI.', 'product-interior-visualizer' ); ?>
			</p>
		</div>
		<style>
			.piv-meta-box { padding: 10px 0; }
			.piv-meta-box label { display: flex; align-items: center; cursor: pointer; }
			.piv-meta-box input[type="checkbox"] { margin-right: 8px; }
			.piv-meta-box .description { margin-top: 10px; font-style: italic; }
		</style>
		<?php
	}

	/**
	 * Save meta box
	 *
	 * @param int $post_id
	 */
	public function save_meta_box( $post_id ) {
		// Check nonce
		if ( ! isset( $_POST['piv_meta_box_nonce'] ) || 
			 ! wp_verify_nonce( $_POST['piv_meta_box_nonce'], 'piv_save_meta_box' ) ) {
			return;
		}

		// Check autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check permissions
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Save checkbox value
		$enabled = isset( $_POST['piv_enabled'] ) ? 'yes' : 'no';
		update_post_meta( $post_id, '_piv_enabled', $enabled );
	}
}
