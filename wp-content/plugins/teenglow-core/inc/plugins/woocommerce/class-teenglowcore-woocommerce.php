<?php

if ( ! class_exists( 'TeenglowCore_WooCommerce' ) ) {
	class TeenglowCore_WooCommerce {
		private static $instance;

		public function __construct() {

			if ( qode_framework_is_installed( 'woocommerce' ) ) {
				// Include files
				$this->include_files();
			}
		}

		/**
		 * @return TeenglowCore_WooCommerce
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function include_files() {

			// Include helper functions
			include_once TEENGLOW_CORE_PLUGINS_PATH . '/woocommerce/helper.php';

			// Include options
			include_once TEENGLOW_CORE_PLUGINS_PATH . '/woocommerce/dashboard/admin/woocommerce-options.php';
			include_once TEENGLOW_CORE_PLUGINS_PATH . '/woocommerce/dashboard/admin/woocommerce-cart-options.php';
			include_once TEENGLOW_CORE_PLUGINS_PATH . '/woocommerce/dashboard/admin/woocommerce-info-options.php';
			include_once TEENGLOW_CORE_PLUGINS_PATH . '/woocommerce/dashboard/admin/woocommerce-social-share-options.php';

			// Include meta boxes
			include_once TEENGLOW_CORE_PLUGINS_PATH . '/woocommerce/dashboard/meta-box/product-meta-box.php';

			// Include single variations
			foreach ( glob( TEENGLOW_CORE_PLUGINS_PATH . '/woocommerce/single/variations/*/include.php' ) as $variation ) {
				include_once $variation;
			}

			// Include shortcodes
			add_action( 'qode_framework_action_before_shortcodes_register', array( $this, 'include_shortcodes' ) );

			// Include widgets
			add_action( 'qode_framework_action_before_widgets_register', array( $this, 'include_widgets' ) );

			// Include plugin addons
			foreach ( glob( TEENGLOW_CORE_PLUGINS_PATH . '/woocommerce/plugins/*/include.php' ) as $plugin ) {
				include_once $plugin;
			}

			// Set product list layout
			add_action( 'qode_framework_action_after_options_init_' . TEENGLOW_CORE_OPTIONS_NAME, array( $this, 'set_product_list_layout' ) );
		}

		function include_shortcodes() {
			foreach ( glob( TEENGLOW_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/*/include.php' ) as $shortcode ) {
				include_once $shortcode;
			}
		}

		function include_widgets() {
			foreach ( glob( TEENGLOW_CORE_PLUGINS_PATH . '/woocommerce/widgets/*/include.php' ) as $widget ) {
				include_once $widget;
			}
		}

		function set_product_list_layout() {
			/**
			 * Shop page templates hooks
			 */
			$list_item_layouts = apply_filters( 'teenglow_core_filter_product_list_layouts', array() );
			$options_map       = teenglow_core_get_variations_options_map( $list_item_layouts );

			if ( $options_map['visibility'] ) {
				$options_map['default_value'] = teenglow_core_get_option_value( 'admin', 'qodef_product_list_item_layout', $options_map['default_value'] );
			}

			// This conditional can't be inside constructor because Elementor doesn't recognize it
			if ( qode_framework_is_installed( 'theme' ) ) {
				do_action( 'teenglow_core_action_shop_list_item_layout_' . $options_map['default_value'] );
			}
		}
	}

	TeenglowCore_WooCommerce::get_instance();
}
