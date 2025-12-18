<?php
/**
 * Plugin Name: Product Interior Visualizer
 * Plugin URI: https://barabi.com
 * Description: AI-powered interior visualization for WooCommerce products
 * Version: 1.0.0
 * Author: Barabi
 * Author URI: https://barabi.com
 * Text Domain: product-interior-visualizer
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * WC requires at least: 5.0
 * WC tested up to: 8.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugin constants
define( 'PIV_VERSION', '1.0.0' );
define( 'PIV_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PIV_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'PIV_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

// Autoloader
spl_autoload_register( function ( $class ) {
	$prefix = 'PIV\\';
	$base_dir = PIV_PLUGIN_DIR . 'includes/';

	$len = strlen( $prefix );
	if ( strncmp( $prefix, $class, $len ) !== 0 ) {
		return;
	}

	$relative_class = substr( $class, $len );
	$file = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

	if ( file_exists( $file ) ) {
		require $file;
	}
});

// Initialize plugin
function piv_init() {
	// Check if WooCommerce is active
	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'piv_woocommerce_missing_notice' );
		return;
	}

	// Initialize main plugin class
	PIV\Plugin::get_instance();
}
add_action( 'plugins_loaded', 'piv_init' );

// Admin notice for missing WooCommerce
function piv_woocommerce_missing_notice() {
	?>
	<div class="notice notice-error">
		<p><?php esc_html_e( 'Product Interior Visualizer requires WooCommerce to be installed and active.', 'product-interior-visualizer' ); ?></p>
	</div>
	<?php
}

// Activation hook
register_activation_hook( __FILE__, array( 'PIV\Installer', 'activate' ) );

// Deactivation hook
register_deactivation_hook( __FILE__, array( 'PIV\Installer', 'deactivate' ) );
