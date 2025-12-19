<?php
/**
 * Plugin Installer
 *
 * @package ProductInteriorVisualizer
 */

namespace PIV;

class Installer {
	/**
	 * Activate plugin
	 */
	public static function activate() {
		// Create usage tracking table
		self::create_tables();
		
		// Set default options
		self::set_default_options();
		
		// Flush rewrite rules
		flush_rewrite_rules();
	}

	/**
	 * Deactivate plugin
	 */
	public static function deactivate() {
		// Flush rewrite rules
		flush_rewrite_rules();
	}

	/**
	 * Create database tables
	 */
	private static function create_tables() {
		global $wpdb;
		
		$table_name = $wpdb->prefix . 'piv_usage_log';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			user_id bigint(20) NOT NULL,
			product_id bigint(20) NOT NULL,
			ip_address varchar(45) NOT NULL,
			request_date date NOT NULL,
			created_at datetime DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id),
			KEY user_id (user_id),
			KEY request_date (request_date),
			KEY ip_address (ip_address)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	/**
	 * Set default options
	 */
	private static function set_default_options() {
		$defaults = array(
			'piv_api_key' => '',
			'piv_daily_limit' => 10,
			'piv_limit_type' => 'ip', // 'ip' or 'user'
			'piv_image_max_size' => 5, // MB
			'piv_allowed_formats' => array( 'jpg', 'jpeg', 'png', 'webp' ),
		);

		foreach ( $defaults as $key => $value ) {
			if ( false === get_option( $key ) ) {
				add_option( $key, $value );
			}
		}
	}
}
