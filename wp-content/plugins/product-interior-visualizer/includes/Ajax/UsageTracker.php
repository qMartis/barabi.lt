<?php
/**
 * Usage Tracker AJAX Handler
 *
 * @package ProductInteriorVisualizer
 */

namespace PIV\Ajax;

class UsageTracker {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'wp_ajax_piv_check_remaining_requests', array( $this, 'check_remaining_requests' ) );
		add_action( 'wp_ajax_nopriv_piv_check_remaining_requests', array( $this, 'check_remaining_requests' ) );
	}

	/**
	 * Check remaining requests
	 */
	public function check_remaining_requests() {
		// Verify nonce
		if ( ! check_ajax_referer( 'piv_nonce', 'nonce', false ) ) {
			wp_send_json_error( array(
				'message' => __( 'Security check failed.', 'product-interior-visualizer' ),
			));
		}

		$limit_checker = new \PIV\Core\LimitChecker();
		$remaining = $limit_checker->get_remaining_requests();
		$daily_limit = absint( get_option( 'piv_daily_limit', 10 ) );

		wp_send_json_success( array(
			'remaining' => $remaining,
			'limit' => $daily_limit,
			'can_request' => $remaining > 0,
		));
	}
}
