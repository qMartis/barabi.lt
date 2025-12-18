<?php
/**
 * Limit Checker
 *
 * @package ProductInteriorVisualizer
 */

namespace PIV\Core;

class LimitChecker {
	/**
	 * Check if user/IP can make request
	 *
	 * @return bool
	 */
	public function can_make_request() {
		$limit_type = get_option( 'piv_limit_type', 'ip' );
		$daily_limit = absint( get_option( 'piv_daily_limit', 10 ) );

		$identifier = $this->get_identifier( $limit_type );
		$today_count = $this->get_today_count( $identifier, $limit_type );

		return $today_count < $daily_limit;
	}

	/**
	 * Log request
	 *
	 * @param int $product_id
	 * @return bool
	 */
	public function log_request( $product_id ) {
		global $wpdb;
		
		$limit_type = get_option( 'piv_limit_type', 'ip' );
		$identifier = $this->get_identifier( $limit_type );

		$table_name = $wpdb->prefix . 'piv_usage_log';
		
		$user_id = 'user' === $limit_type ? get_current_user_id() : 0;
		$ip_address = $this->get_user_ip();

		return $wpdb->insert(
			$table_name,
			array(
				'user_id' => $user_id,
				'product_id' => $product_id,
				'ip_address' => $ip_address,
				'request_date' => current_time( 'Y-m-d' ),
			),
			array( '%d', '%d', '%s', '%s' )
		);
	}

	/**
	 * Get identifier based on limit type
	 *
	 * @param string $limit_type
	 * @return string|int
	 */
	private function get_identifier( $limit_type ) {
		if ( 'user' === $limit_type ) {
			return get_current_user_id();
		}
		return $this->get_user_ip();
	}

	/**
	 * Get today's count for identifier
	 *
	 * @param string|int $identifier
	 * @param string $limit_type
	 * @return int
	 */
	private function get_today_count( $identifier, $limit_type ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'piv_usage_log';
		$today = current_time( 'Y-m-d' );

		if ( 'user' === $limit_type ) {
			$count = $wpdb->get_var( $wpdb->prepare(
				"SELECT COUNT(*) FROM $table_name WHERE user_id = %d AND request_date = %s",
				$identifier,
				$today
			));
		} else {
			$count = $wpdb->get_var( $wpdb->prepare(
				"SELECT COUNT(*) FROM $table_name WHERE ip_address = %s AND request_date = %s",
				$identifier,
				$today
			));
		}

		return absint( $count );
	}

	/**
	 * Get user IP address
	 *
	 * @return string
	 */
	private function get_user_ip() {
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
		}

		return sanitize_text_field( $ip );
	}

	/**
	 * Get remaining requests for today
	 *
	 * @return int
	 */
	public function get_remaining_requests() {
		$limit_type = get_option( 'piv_limit_type', 'ip' );
		$daily_limit = absint( get_option( 'piv_daily_limit', 10 ) );
		$identifier = $this->get_identifier( $limit_type );
		$today_count = $this->get_today_count( $identifier, $limit_type );

		return max( 0, $daily_limit - $today_count );
	}
}
