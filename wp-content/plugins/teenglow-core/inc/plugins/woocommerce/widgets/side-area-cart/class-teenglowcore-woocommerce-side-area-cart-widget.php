<?php

if ( ! function_exists( 'teenglow_core_add_woo_side_area_cart_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function teenglow_core_add_woo_side_area_cart_widget( $widgets ) {
		$widgets[] = 'TeenglowCore_WooCommerce_Side_Area_Cart_Widget';

		return $widgets;
	}

	add_filter( 'teenglow_core_filter_register_widgets', 'teenglow_core_add_woo_side_area_cart_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class TeenglowCore_WooCommerce_Side_Area_Cart_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$this->set_base( 'teenglow_core_woo_side_area_cart' );
			$this->set_name( esc_html__( 'Teenglow WooCommerce Side Area Cart', 'teenglow-core' ) );
			$this->set_description( esc_html__( 'Display a shop cart icon with that shows products count that are in the cart', 'teenglow-core' ) );
		}

		public function load_assets() {
			wp_enqueue_style( 'perfect-scrollbar', TEENGLOW_CORE_URL_PATH . 'assets/plugins/perfect-scrollbar/perfect-scrollbar.css', array() );
			wp_enqueue_script( 'perfect-scrollbar', TEENGLOW_CORE_URL_PATH . 'assets/plugins/perfect-scrollbar/perfect-scrollbar.jquery.min.js', array( 'jquery' ), false, true );
		}

		public function render( $atts ) {
			?>
			<div class="qodef-widget-side-area-cart-inner">
				<?php teenglow_core_template_part( 'plugins/woocommerce/widgets/side-area-cart', 'templates/parts/opener' ); ?>
				<?php teenglow_core_template_part( 'plugins/woocommerce/widgets/side-area-cart', 'templates/content' ); ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'teenglow_core_woo_side_area_cart_add_to_cart_fragment' ) ) {
	/**
	 * Function that return|update new cart content for products which are added into the cart
	 *
	 * @param array $fragments
	 *
	 * @return array
	 */
	function teenglow_core_woo_side_area_cart_add_to_cart_fragment( $fragments ) {
		ob_start();
		?>
		<div class="qodef-widget-side-area-cart-inner">
			<?php teenglow_core_template_part( 'plugins/woocommerce/widgets/side-area-cart', 'templates/parts/opener' ); ?>
			<?php teenglow_core_template_part( 'plugins/woocommerce/widgets/side-area-cart', 'templates/content' ); ?>
		</div>
		<?php
		$fragments['.qodef-widget-side-area-cart-inner'] = ob_get_clean();

		return $fragments;
	}

	add_filter( 'woocommerce_add_to_cart_fragments', 'teenglow_core_woo_side_area_cart_add_to_cart_fragment' );
}
