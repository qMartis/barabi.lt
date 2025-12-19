<?php
/**
 * Main Plugin Class
 *
 * @package ProductInteriorVisualizer
 */

namespace PIV;

class Plugin {
	/**
	 * Single instance of the class
	 *
	 * @var Plugin
	 */
	private static $instance = null;

	/**
	 * Admin instance
	 *
	 * @var Admin\Settings
	 */
	private $admin;

	/**
	 * Frontend instance
	 *
	 * @var Frontend\Shortcode
	 */
	private $product_display;

	/**
	 * API Handler instance
	 *
	 * @var API\GeminiHandler
	 */
	private $api_handler;

	/**
	 * Get single instance
	 *
	 * @return Plugin
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		$this->init_hooks();
		$this->init_components();
	}

	/**
	 * Initialize hooks
	 */
	private function init_hooks() {
		add_action( 'init', array( $this, 'load_textdomain' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
	}

	/**
	 * Initialize components
	 */
	private function init_components() {
		$this->admin = new Admin\Settings();
		
		// Add product meta box in admin
		if ( is_admin() ) {
			new Admin\ProductMeta();
		}
		
		$this->product_display = new Frontend\ProductDisplay();
		$this->api_handler = new API\GeminiHandler();
		
		// Initialize AJAX handlers
		new Ajax\ImageUploadHandler();
		new Ajax\UsageTracker();
	}

	/**
	 * Load text domain
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 
			'product-interior-visualizer', 
			false, 
			dirname( PIV_PLUGIN_BASENAME ) . '/languages' 
		);
	}

	/**
	 * Enqueue frontend assets
	 */
	public function enqueue_frontend_assets() {
		if ( is_product() || has_shortcode( get_post()->post_content ?? '', 'piv_visualizer' ) ) {
			wp_enqueue_style( 
				'piv-frontend', 
				PIV_PLUGIN_URL . 'assets/css/frontend.css', 
				array(), 
				PIV_VERSION 
			);

			wp_enqueue_script( 
				'piv-frontend', 
				PIV_PLUGIN_URL . 'assets/js/frontend.js', 
				array( 'jquery' ), 
				PIV_VERSION, 
				true 
			);

			wp_localize_script( 'piv-frontend', 'pivData', array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'piv_nonce' ),
				'strings' => array(
					'uploading' => __( 'Uploading image...', 'product-interior-visualizer' ),
					'processing' => __( 'AI is visualizing your interior...', 'product-interior-visualizer' ),
					'error' => __( 'An error occurred. Please try again.', 'product-interior-visualizer' ),
					'limitReached' => __( 'Daily request limit reached. Please try again tomorrow.', 'product-interior-visualizer' ),
					'selectImage' => __( 'Please select an image first.', 'product-interior-visualizer' ),
				),
			));
		}
	}

	/**
	 * Enqueue admin assets
	 */
	public function enqueue_admin_assets( $hook ) {
		if ( 'settings_page_piv-settings' !== $hook ) {
			return;
		}

		wp_enqueue_style( 
			'piv-admin', 
			PIV_PLUGIN_URL . 'assets/css/admin.css', 
			array(), 
			PIV_VERSION 
		);

		wp_enqueue_script( 
			'piv-admin', 
			PIV_PLUGIN_URL . 'assets/js/admin.js', 
			array( 'jquery' ), 
			PIV_VERSION, 
			true 
		);
	}
}
